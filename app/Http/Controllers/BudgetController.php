<?php

namespace App\Http\Controllers;

use App\Models\Propal;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $budgets = Propal::query()->where('fk_soc', '=', Auth::user()->society->rowid)
                              ->orderBy('rowid', 'DESC')
                              ->paginate();

    return view('web.budgets.index')->with('budgets', $budgets);
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
   * @param  \App\Models\Propal  $propal
   * @return \Illuminate\Http\Response
   */
  public function show(Propal $propal)
  {
    if (Auth::user()->society->rowid == $propal->fk_soc) {
      $commande = $propal->commandes()->first();

      return view('web.budgets.show')->with('propal', $propal)->with('commande', $commande);
    } else {
      return redirect()->route('budgets.index');
    }
  }

  /**
   * PDF.
   *
   * @param  \App\Models\Propal  $propal
   * @return \Illuminate\Http\Response
   */
  public function pdf(Propal $propal)
  {
    if (Auth::user()->society->rowid == $propal->fk_soc) {
      $data = [
        'propal' => $propal
      ];

      $pdf = Pdf::loadView('web.budgets.pdf', $data);
      $filename = 'CDSOLEC-'.$propal->ref.'.pdf';

      return $pdf->stream($filename);
    }
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Propal  $propal
   * @return \Illuminate\Http\Response
   */
  public function edit(Propal $propal)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Propal  $propal
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Propal $propal)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Propal  $propal
   * @return \Illuminate\Http\Response
   */
  public function name(Request $request, Propal $propal)
  {
    $data = $request->validate(['name' => 'required|string']);

    $propal->update(['ref_client' => $data['name']]);

    return redirect()->back()->with('success', 'Nombre guardado con éxito.');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Propal  $propal
   * @return \Illuminate\Http\Response
   */
  public function destroy(Propal $propal)
  {
    //
  }
}
