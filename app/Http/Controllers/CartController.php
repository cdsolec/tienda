<?php

namespace App\Http\Controllers;

use App\Mail\OrderMail;
use App\Models\{Product, Setting, User, Propal, Commande, ElementElement};
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CartController extends Controller
{
  /**
   * Display a listing of the resource.
   * 
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $iva = Setting::find(1)->value;
    $tasa_usd = Setting::find(2)->value;

    $cart = $request->session()->get('cart', []);
    $mycart = [];

    if (Auth::check() && Auth::user()->society) { $price_level = Auth::user()->society->price_level; } else { $price_level = 1; }

    foreach ($cart as $item) {
      $product = Product::findOrFail($item['product']);

      $stock = $product->stock - $product->seuil_stock_alerte;

      $price_original = $product->prices()->where('price_level', '=', 1)->orderBy('date_price', 'desc')->first();
      $price_client = $product->prices()->where('price_level', '=', $price_level)->orderBy('date_price', 'desc')->first();
      if ($price_client == null) {
        $price_client = $price_original;
      }

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

      $mycart[$product->rowid] = [
        'id' => $product->rowid,
        'image' => $image,
        'ref' => $product->ref,
        'label' => $product->label,
        'price' => $price_client->price_discount,
        'stock' => $stock,
        'quantity' => $item['quantity']
      ];
    }

    return view('web.cart')->with('percent_iva', $iva)
                           ->with('tasa_usd', $tasa_usd)
                           ->with('cart', $mycart);
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
      $stock = $product->stock - $product->seuil_stock_alerte;

      if (($data['quantity'] > 0) && ($data['quantity'] <= $stock)) {
        $cart = $request->session()->get('cart', []);

        $cart[$product->rowid] = [
          'product' => $product->rowid,
          'quantity' => $data['quantity']
        ];

        $request->session()->put('cart', $cart);

        return redirect()->route('cart.index');
      } else {
        return redirect()->route('cart.index')->withErrors([
          'product' => 'Cantidad no disponible'
        ]);
      }
    } catch (\Throwable $th) {
      //throw $th;
      return redirect()->route('cart.index')->withErrors([
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
      $percent_iva = Setting::find(1)->value;
      $tasa_usd = Setting::find(2)->value;

      $product = Product::findOrFail($id);
      $stock = $product->stock - $product->seuil_stock_alerte;

      if (Auth::check() && Auth::user()->society) { $price_level = Auth::user()->society->price_level; } else { $price_level = 1; }

      if (($data['quantity'] > 0) && ($data['quantity'] <= $stock)) {
        $cart = $request->session()->get('cart', []);

        $cart[$product->rowid] = [
          'product' => $product->rowid,
          'quantity' => $data['quantity']
        ];

        $request->session()->put('cart', $cart);

        $subtotal_bs = 0;
        $subtotal_usd = 0;
        foreach ($cart as $item) {
          $product = Product::findOrFail($item['product']);

          $price_original = $product->prices()->where('price_level', '=', 1)->orderBy('date_price', 'desc')->first();
          $price_client = $product->prices()->where('price_level', '=', $price_level)->orderBy('date_price', 'desc')->first();
          if ($price_client == null) {
            $price_client = $price_original;
          }

          $subtotal_bs += $price_client->price_discount * $tasa_usd * $item['quantity'];
          $subtotal_usd += $price_client->price_discount * $item['quantity'];
        }
        $iva_bs = ($subtotal_bs * $percent_iva) / 100;
        $iva_usd = ($subtotal_usd * $percent_iva) / 100;
        $total_bs = $subtotal_bs + $iva_bs;
        $total_usd = $subtotal_usd + $iva_usd;

        return response()->json([
          'error' => false,
          'subtotal_bs' => number_format($subtotal_bs, 2, ',', '.'),
          'subtotal_usd' => number_format($subtotal_usd, 2, ',', '.'),
          'iva_bs' => number_format($iva_bs, 2, ',', '.'),
          'iva_usd' => number_format($iva_usd, 2, ',', '.'),
          'total_bs' => number_format($total_bs, 2, ',', '.'),
          'total_usd' => number_format($total_usd, 2, ',', '.')
        ]);
      } else {
        return response()->json([
          'error' => true,
          'subtotal_bs' => 0,
          'subtotal_usd' => 0,
          'iva_bs' => 0,
          'iva_usd' => 0,
          'total_bs' => 0,
          'total_usd' => 0
        ]);
      }
    } catch (\Throwable $th) {
      //throw $th;
      return response()->json([
        'error' => true,
        'subtotal_bs' => 0,
        'subtotal_usd' => 0,
        'iva_bs' => 0,
        'iva_usd' => 0,
        'total_bs' => 0,
        'total_usd' => 0
      ]);
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
    $cart = $request->session()->get('cart', []);

    if (count($cart) > 1) {  // comprobamos si la order tiene mas de un producto
      unset($cart[$id]);
      $request->session()->put('cart', $cart);
    } else {  // si solo tiene uno eliminamos las variables de sesión q no voy a utilizar mas
      $request->session()->forget(['cart']);
    }

    return redirect()->route('cart.index');
  }

  /**
   * Remove all cart.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function clear(Request $request)
  {
    $request->session()->forget(['cart']);

    return redirect()->route('cart.index');
  }

  /**
   * Checkout cart.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function checkout(Request $request)
  {
    $cart = $request->session()->get('cart', []);
    $percent_iva = Setting::find(1)->value;
    $tasa_usd = Setting::find(2)->value;

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
      'fk_statut' => 2,
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

    $subtotal_bs = 0;
    $subtotal_usd = 0;
    foreach ($cart as $item) {
      $product = Product::findOrFail($item['product']);

      $stock = $product->stock - $product->seuil_stock_alerte;

      $price_original = $product->prices()->where('price_level', '=', 1)->orderBy('date_price', 'desc')->first();
      $price_client = $product->prices()->where('price_level', '=', $price_level)->orderBy('date_price', 'desc')->first();
      if ($price_client == null) {
        $price_client = $price_original;
      }

      $subtotal_bs += $price_client->price_discount * $tasa_usd * $item['quantity'];
      $subtotal_usd += $price_client->price_discount * $item['quantity'];

      $total_ht = $price_client->price_discount * $item['quantity'];
      $tva_tx = $percent_iva;
      $total_tva = ($price_client->price_discount * $item['quantity'] * $percent_iva) / 100;
      $total_ttc = $total_ht + $total_tva;

      $propal->propal_detail()->create([
        'fk_product' => $product->rowid,
        'label' => $product->ref,
        'description' => $product->label,
        'tva_tx' => $tva_tx,                           // IVA del Producto
        'qty' => $item['quantity'],
        'remise_percent' => 0,                         // Porcentaje Descuento al Producto
        'price' => $price_client->price_discount,      // Precio del Producto con Descuento
        'subprice' => $price_client->price_discount,   // Precio del Producto sin Descuento
        'total_ht' => $total_ht,                       // Precio total del Producto sin IVA (price*qty)
        'total_tva' => $total_tva,                     // Monto total del IVA aplicado a ese Producto
        'total_ttc' => $total_ttc,                     // Precio total del Producto + IVA (total_ht+total_tva)
        'product_type' => 0,                           // 0 = Producto | 1 = Servicio
        'fk_multicurrency' => 1,
        'multicurrency_code' => 'USD',
        'multicurrency_subprice' => $price_client->price_discount,
        'multicurrency_total_ht' => $total_ht,
        'multicurrency_total_tva' => $total_tva,
        'multicurrency_total_ttc' => $total_ttc
      ]);
    }
    $iva_bs = ($subtotal_bs * $percent_iva) / 100;
    $iva_usd = ($subtotal_usd * $percent_iva) / 100;
    $total_bs = $subtotal_bs + $iva_bs;
    $total_usd = $subtotal_usd + $iva_usd;

    $propal->update([
      'total_ht' => $subtotal_usd,  // Total sin IVA
      'total_tva' => $iva_usd,      // IVA
      'total_ttc' => $total_usd,    // Total + IVA
      'multicurrency_total_ht' => $subtotal_usd,
      'multicurrency_total_tva' => $iva_usd,
      'multicurrency_total_ttc' => $total_usd
    ]);

    $query = Commande::select('ref')->orderBy('ref', 'desc')->first();
    $last_ref = explode("-", $query);
    $correlative = intval($last_ref[1]) + 1;
    $correlative = str_pad($correlative, 4, '0', STR_PAD_LEFT);
    $ref = 'CO'.date('ym').'-'.$correlative;

    /* Crear el Pedido */
    $commande = Commande::create([
      'ref' => $ref,
      'entity' => 1,
      'fk_soc' => $user->society->rowid,
      'date_creation' => Carbon::now(),
      'date_valid' => Carbon::now(),
      'date_cloture' => Carbon::now(),
      'date_commande' => Carbon::now(),
      'fk_user_author' => $user->rowid,
      'fk_user_valid' => $user->rowid,
      'fk_statut' => 1,
      'total_ht' => $propal->total_ht,    // Total sin IVA
      'total_tva' => $propal->total_tva,  // IVA
      'total_ttc' => $propal->total_ttc,  // Total + IVA
      'fk_multicurrency' => 1,
      'multicurrency_code' => 'USD',
      'multicurrency_tx' => $propal->multicurrency_tx,  // Tasa del USD
      'multicurrency_total_ht' => $propal->multicurrency_total_ht,
      'multicurrency_total_tva' => $propal->multicurrency_total_tva,
      'multicurrency_total_ttc' => $propal->multicurrency_total_ttc,
    ]);

    foreach ($propal->propal_detail as $item) {
      $commande->commande_detail()->create([
        'fk_product' => $item->fk_product,
        'label' => $item->label,
        'description' => $item->description,
        'tva_tx' => $item->tva_tx,  // IVA del Producto
        'qty' => $item->qty,
        'remise_percent' => $item->remise_percent,  // Porcentaje Descuento al Producto
        'price' => $item->price, // Precio del Producto con Descuento
        'subprice' => $item->subprice,  // Precio del Producto sin Descuento
        'total_ht' => $item->total_ht,  // Precio total del Producto sin IVA (price*qty)
        'total_tva' => $item->total_tva,  // Monto total del IVA aplicado a ese Producto
        'total_ttc' => $item->total_ttc,  // Precio total del Producto + IVA (total_ht+total_tva)
        'product_type' => $item->product_type,  // 0 = Producto | 1 = Servicio
        'fk_multicurrency' => 1,
        'multicurrency_code' => 'USD',
        'multicurrency_subprice' => $item->multicurrency_subprice,
        'multicurrency_total_ht' => $item->multicurrency_total_ht,
        'multicurrency_total_tva' => $item->multicurrency_total_tva,
        'multicurrency_total_ttc' => $item->multicurrency_total_ttc
      ]);
    }

    ElementElement::create([
      'fk_source' => $propal->rowid,
      'sourcetype' => 'propal',
      'fk_target' => $commande->rowid,
      'targettype' => 'commande'
    ]);

    $request->session()->forget(['cart']);

    Mail::to($user->email, 'Compra CD-SOLEC')->cc('ventas@cd-solec.com', 'Compra CD-SOLEC')->send(new OrderMail($commande));

    return redirect()->route('orders.show', $commande);
  }

  /**
   * Reload Cart.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function reload(Request $request, string $type, int $id)
  {
    if ($type == 'budget') {
      $propal = Propal::find($id);
      $cart = [];

      foreach ($propal->propal_detail as $item) {
        $product = Product::findOrFail($item->fk_product);
        $stock = $product->stock - $product->seuil_stock_alerte;

        if ($stock > 0) {
          if ($stock > $item->qty) { $qty = $item->qty; } else { $qty = $stock; }

          $cart[$item->fk_product] = [
            'product' => $item->fk_product,
            'quantity' => $qty
          ];
        }
      }

      $request->session()->put('cart', $cart);

      return redirect()->route('cart.index');
    }

    if ($type == 'order') {
      $commande = Commande::find($id);
      $cart = [];

      foreach ($commande->commande_detail as $item) {
        $product = Product::findOrFail($item->fk_product);
        $stock = $product->stock - $product->seuil_stock_alerte;

        if ($stock > 0) {
          if ($stock > $item->qty) { $qty = $item->qty; } else { $qty = $stock; }

          $cart[$item->fk_product] = [
            'product' => $item->fk_product,
            'quantity' => $qty
          ];
        }
      }

      $request->session()->put('cart', $cart);

      return redirect()->route('cart.index');
    }

    return redirect()->back();
  }
}
