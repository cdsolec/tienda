<?php

namespace App\Http\Controllers;

use App\Mail\OrderMail;
use App\Models\Commande;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $orders = Commande::query()->where('fk_soc', '=', Auth::user()->society->rowid)
                               ->orderBy('rowid', 'DESC')
                               ->paginate();

    return view('web.orders.index')->with('orders', $orders);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
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
   * @param  \App\Models\Commande  $commande
   * @return \Illuminate\Http\Response
   */
  public function show(Commande $commande)
  {
    if (Auth::user()->society->rowid == $commande->fk_soc) {
      $facture = $commande->factures()->first();

      return view('web.orders.show')->with('commande', $commande)->with('facture', $facture);
    } else {
      return redirect()->route('orders.index');
    }
  }

  /**
   * PDF.
   *
   * @param  \App\Models\Commande  $commande
   * @return \Illuminate\Http\Response
   */
  public function pdf(Commande $commande)
  {
    if (Auth::user()->society->rowid == $commande->fk_soc) {
      $data = [
        'commande' => $commande
      ];

      $pdf = Pdf::loadView('web.orders.pdf', $data);
      $filename = 'CDSOLEC-'.$commande->ref.'.pdf';

      return $pdf->stream($filename);
    }
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Commande  $commande
   * @return \Illuminate\Http\Response
   */
  public function edit(Commande $commande)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Commande  $commande
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Commande $commande)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Commande  $commande
   * @return \Illuminate\Http\Response
   */
  public function name(Request $request, Commande $commande)
  {
    $data = $request->validate(['name' => 'required|string']);

    $commande->update(['ref_client' => $data['name']]);

    return redirect()->back()->with('success', 'Nombre guardado con éxito.');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Commande  $commande
   * @return \Illuminate\Http\Response
   */
  public function destroy(Commande $commande)
  {
    //
  }

  /**
   * Display Mail the specified resource.
   *
   * @param  \App\Models\Commande  $commande
   * @return \Illuminate\Http\Response
   */
  public function mail(Commande $commande)
  {
    return new OrderMail($commande);
  }
}
