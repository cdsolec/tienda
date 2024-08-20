<?php

namespace App\Http\Controllers;

use App\Models\{Propal, Product, Setting, User};
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuotationController extends Controller
{
    /**
   * Display a listing of the resource.
   * 
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    return view('web.quotation');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //
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
    //
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
    //
  }

  /**
   * Checkout basket.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function checkout(Request $request)
  {
    $data = $request->validate([
      'codigo' => 'required|array',
      'codigo.0' => 'required|string',
      'codigo.*' => 'nullable|string',
      'fabricante' => 'required|array',
      'fabricante.0' => 'required|string',
      'fabricante.*' => 'nullable|string',
      'quantity' => 'required|array',
      'quantity.*' => 'required|integer|min:1',
    ]);

    $percent_iva = Setting::find(1)->value;
    $tasa_usd = Setting::find(2)->value;

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

    foreach ($data['codigo'] as $key => $item) {
      if ($item) {
        $tva_tx = $percent_iva;

        $propal->propal_detail()->create([
          'label' => $item,
          'description' => 'Código: '.$item.' | Fabricante: '.$data['fabricante'][$key],
          'tva_tx' => $tva_tx,                           // IVA del Producto
          'qty' => $data['quantity'][$key],
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
    }

    // Mail::to($user->email, 'Compra CD-SOLEC')->cc('ventas@cd-solec.com', 'Compra CD-SOLEC')->send(new OrderMail($commande));

    return redirect()->route('budgets.show', $propal);
  }
}
