<?php

namespace App\Http\Controllers;

use App\Models\{User, Commande, Facture, ElementElement, BankAccount, CPaiement, Bank, Paiement, PaiementFacture};
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function create(Commande $commande)
    {
        $accounts = BankAccount::all();
        $types = CPaiement::where('active', 1)->get();

        return view('web.payment')->with('commande', $commande)
                                  ->with('accounts', $accounts)
                                  ->with('types', $types);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Models\Commande  $commande
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Commande $commande)
    {
        $validated = $request->validate([
            'account' => 'required|exists:mysqlerp.llx_bank_account,rowid',
            'reference' => 'required|string',
            'date' => 'required|date_format:d/m/Y',
            'type' => 'required|exists:mysqlerp.llx_c_paiement,id',
            'amount' => 'required|numeric'
        ]);

        $user = User::find(Auth::user()->rowid);

        if ($commande->factures->count() <= 0) {
            $query = Facture::select('ref')->orderBy('ref', 'desc')->first();
            $last_ref = explode("-", $query);

            if (isset($last_ref[1])) {
                $correlative = intval($last_ref[1]) + 1;
            } else {
                $correlative = 1;
            }
            
            $correlative = str_pad($correlative, 4, '0', STR_PAD_LEFT);
            $ref = 'FA'.date('ym').'-'.$correlative;

            /* Crear la Factura */
            $facture = Facture::create([
                'ref' => $ref,
                'entity' => 1,
                'type' => 0,
                'fk_soc' => $user->society->rowid,
                'datec' => Carbon::now(),
                'datef' => Carbon::now(),
                'date_valid' => Carbon::now(),
                'tms' => Carbon::now(),
                'paye' => 0,
                'total_tva' => $commande->total_tva,
                'total_ht' => $commande->total_ht,
                'total_ttc' => $commande->total_ttc,
                'fk_statut' => 1,
                'fk_user_author' => $user->rowid,
                'fk_user_valid' => $user->rowid,
                'fk_multicurrency' => 1,
                'multicurrency_code' => 'USD',
                'multicurrency_tx' => $commande->multicurrency_tx,  // Tasa del USD
                'multicurrency_total_ht' => $commande->multicurrency_total_ht,
                'multicurrency_total_tva' => $commande->multicurrency_total_tva,
                'multicurrency_total_ttc' => $commande->multicurrency_total_ttc
            ]);

            foreach ($commande->commande_detail as $item) {
                $facture->facture_detail()->create([
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
                    'fk_multicurrency' => 1,
                    'multicurrency_code' => 'USD',
                    'multicurrency_subprice' => $item->multicurrency_subprice,
                    'multicurrency_total_ht' => $item->multicurrency_total_ht,
                    'multicurrency_total_tva' => $item->multicurrency_total_tva,
                    'multicurrency_total_ttc' => $item->multicurrency_total_ttc
                ]);
            }

            ElementElement::create([
                'fk_source' => $commande->rowid,
                'sourcetype' => 'commande',
                'fk_target' => $facture->rowid,
                'targettype' => 'facture'
            ]);
        } else {
            $facture = $commande->factures()->first();
        }

        $bank = Bank::create([
            'dataec' => Carbon::createFromFormat('d/m/Y', $validated['date']),
            'tms' => Carbon::createFromFormat('d/m/Y', $validated['date']),
            'dateo' => Carbon::createFromFormat('d/m/Y', $validated['date']),
            'amount' => $validated['amount'],
            'label' => 'CustomerInvoicePayment',
            'fk_account' => $validated['account'],
            'fk_user_author' => $user->rowid,
            'fk_type' => $validated['type'],
            'num_chq' => $validated['reference']
        ]);

        $query = Paiement::select('ref')->orderBy('ref', 'desc')->first();
        $last_ref = explode("-", $query);

        if (isset($last_ref[1])) {
            $correlative = intval($last_ref[1]) + 1;
        } else {
            $correlative = 1;
        }
        
        $correlative = str_pad($correlative, 4, '0', STR_PAD_LEFT);
        $ref = 'PAY'.date('ym').'-'.$correlative;

        $paiement = Paiement::create([
            'ref' => $ref,
            'entity' => 1,
            'datec' => Carbon::createFromFormat('d/m/Y', $validated['date']),
            'datep' => Carbon::createFromFormat('d/m/Y', $validated['date']),
            'tms' => Carbon::createFromFormat('d/m/Y', $validated['date']),
            'amount' => $validated['amount'],
            'multicurrency_amount' => $validated['amount'],
            'fk_paiement' => $validated['type'],
            'num_paiement' => $validated['reference'],
            'fk_bank' => $bank->rowid,
            'fk_user_creat' => $user->rowid
        ]);

        $paiement_facture = PaiementFacture::create([
            'fk_paiement' => $paiement->rowid,
            'fk_facture' => $facture->rowid,
            'amount' => $validated['amount'],
            'multicurrency_code' => 'USD',
            'multicurrency_tx' => $facture->multicurrency_tx,
            'multicurrency_amount' => $validated['amount']
        ]);

        return redirect()->route('orders.show', $commande)->with('success', 'Pago registrado con éxito.');
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
