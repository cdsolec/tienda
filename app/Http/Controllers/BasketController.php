<?php

namespace App\Http\Controllers;

use App\Models\{Propal, Product, Setting, User};
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BasketController extends Controller
{
    /**
   * Display a listing of the resource.
   * 
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $basket = $request->session()->get('basket', []);
    $mybasket = [];

    foreach ($basket as $item) {
      $product = Product::findOrFail($item['product']);

      if (app()->environment('production')) {
        $image = null;
        if ($product->documents->isNotEmpty()) {
          $documents = $product->documents;
          $total = count($product->documents);
          $i = 0;
          while (!$image && ($i < $total)) {
            if (!$image && (pathinfo($documents[$i]->filename, PATHINFO_EXTENSION) == 'jpg')) {
              $image = 'storage/produit/'.$product->ref.'/'.$documents[$i]->filename;
            }
            $i++;
          }
        }

        if (!$image) { $image = 'img/favicon/apple-icon.png'; }
      } else {
        $image = 'img/favicon/apple-icon.png';
      }

      $mybasket[$product->rowid] = [
        'id' => $product->rowid,
        'image' => $image,
        'ref' => $product->ref,
        'label' => $product->label,
        'quantity' => $item['quantity']
      ];
    }

    return view('web.basket')->with('basket', $mybasket);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $data = $request->validate([
      'product' => 'required|exists:mysqlerp.llx_product,rowid',
      'quantity' => 'required|integer|min:1',
    ]);
    
    try {
      $product = Product::findOrFail($data['product']);

      if ($data['quantity'] > 0) {
        $basket = $request->session()->get('basket', []);

        $basket[$product->rowid] = [
          'product' => $product->rowid,
          'quantity' => $data['quantity'] ?? 1
        ];

        $request->session()->put('basket', $basket);

        return redirect()->route('basket.index');
      } else {
        return redirect()->route('basket.index')->withErrors([
          'product' => 'Cantidad no disponible'
        ]);
      }
    } catch (\Throwable $th) {
      //throw $th;
      return redirect()->route('basket.index')->withErrors([
        'product' => 'Producto no encontrado'
      ]);
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $data = $request->validate([
      'quantity' => 'required|integer|min:1',
    ]);
    
    try {
      $product = Product::findOrFail($id);

      if ($data['quantity'] > 0) {
        $basket = $request->session()->get('basket', []);

        $basket[$product->rowid] = [
          'product' => $product->rowid,
          'quantity' => $data['quantity']
        ];

        $request->session()->put('basket', $basket);

        return response()->json(['error' => false]);
      } else {
        return response()->json(['error' => true]);
      }
    } catch (\Throwable $th) {
      //throw $th;
      return response()->json(['error' => true]);
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(Request $request, $id)
  {
    $basket = $request->session()->get('basket', []);

    if (count($basket) > 1) {  // comprobamos si la order tiene mas de un producto
      unset($basket[$id]);
      $request->session()->put('basket', $basket);
    } else {  // si solo tiene uno eliminamos las variables de sesión q no voy a utilizar mas
      $request->session()->forget(['basket']);
    }

    return redirect()->route('basket.index');
  }

  /**
   * Remove all basket.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function clear(Request $request)
  {
    $request->session()->forget(['basket']);

    return redirect()->route('basket.index');
  }

  /**
   * Checkout basket.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function checkout(Request $request)
  {
    $basket = $request->session()->get('basket', []);
    $percent_iva = Setting::find(1)->value;
    $tasa_usd = Setting::find(2)->value;

    if ($request->checkout_basket == 1) {
      $basket = $request->session()->get('cart', []);
    }

    if (Auth::check() && Auth::user()->society) { $price_level = Auth::user()->society->price_level; } else { $price_level = 1; }
    $user = User::find(Auth::user()->rowid);

    $query = Propal::select('ref')->orderBy('ref', 'desc')->first();
    $last_ref = explode("-", $query);
    $correlative = intval($last_ref[1]) + 1;
    $correlative = str_pad($correlative, 4, '0', STR_PAD_LEFT);
    $ref = 'PR'.date('ym').'-'.$correlative;

    /* Crear el Presupuesto */
    $propal = Propal::create([
      'ref' => $ref,
      'fk_soc' => $user->society->rowid,
      'datec' => Carbon::now(),
      'datep' => Carbon::now(),
      'fin_validite' => Carbon::now()->addDays(15),
      'date_valid' => Carbon::now(),
      'fk_user_author' => $user->rowid,
      'fk_user_valid' => $user->rowid,
      'fk_statut' => 1,
      'total_ht' => 0,   // Total sin IVA
      'total_tva' => 0,  // IVA
      'total_ttc' => 0,  // Total + IVA
      'fk_multicurrency' => 1,
      'multicurrency_code' => 'USD',
      'multicurrency_tx' => $tasa_usd,  // Tasa del USD
      'multicurrency_total_ht' => 0,
      'multicurrency_total_tva' => 0,
      'multicurrency_total_ttc' => 0
    ]);

    foreach ($basket as $item) {
      $product = Product::findOrFail($item['product']);

      $tva_tx = $percent_iva;

      $propal->propal_detail()->create([
        'fk_product' => $product->rowid,
        'label' => $product->ref,
        'description' => $product->label,
        'tva_tx' => $tva_tx,                           // IVA del Producto
        'qty' => $item['quantity'],
        'remise_percent' => 0,                         // Porcentaje Descuento al Producto
        'price' => 0,                                  // Precio del Producto con Descuento
        'subprice' => 0,                               // Precio del Producto sin Descuento
        'total_ht' => 0,                               // Precio total del Producto sin IVA (price*qty)
        'total_tva' => 0,                              // Monto total del IVA aplicado a ese Producto
        'total_ttc' => 0,                              // Precio total del Producto + IVA (total_ht+total_tva)
        'product_type' => 0,                           // 0 = Producto | 1 = Servicio
        'fk_multicurrency' => 1,
        'multicurrency_code' => 'USD',
        'multicurrency_subprice' => 0,
        'multicurrency_total_ht' => 0,
        'multicurrency_total_tva' => 0,
        'multicurrency_total_ttc' => 0
      ]);
    }

    $request->session()->forget(['basket']);

    // Mail::to($user->email, 'Compra CD-SOLEC')->cc('ventas@cd-solec.com', 'Compra CD-SOLEC')->send(new OrderMail($commande));

    return redirect()->route('budgets.show', $propal);
  }
}
