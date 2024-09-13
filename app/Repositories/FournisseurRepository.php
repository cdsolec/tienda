<?php

namespace App\Repositories;

use App\Models\Fournisseur;
use Illuminate\Support\Facades\Auth;
use DB;


final class FournisseurRepository{

    public function __construct(
        private readonly Fournisseur $model,
        )
    {
    }

    public function find($id)
    {
        return  $this->model->find($id);
    }

    public function create(array $data)
    {

    }

    public function update($id, array $data)
    {
       
    }

    public function delete($id)
    {
        $user = $this->model->findOrFail($id);
        $user->delete();

    }

    public function all()
    {
        return  $this->model->select('*')->get();
    }

    public function searchBy(array $data)
    {
        $query = $this->model->select('*');

        foreach($data as $key=>$value){
            $query->where($key, $value);
        }
        
        return $query->get();
    }


    public function searchOneBy(array $data)
    {
        $query = $this->model->select('*');

        foreach($data as $key=>$value){
            $query->where($key, $value);
        }
        
        return  $query->first();
    }

    public function getStockInTransit(){
        
        return $this->model
            //->select(
            //'llx_commande_fournisseurdet.fk_product',
           // 'llx_commande_fournisseurdet.qty',
         //   DB::raw('SUM(llx_commande_fournisseurdet.qty) as total')
          //  )
            ->join('llx_commande_fournisseurdet', 'llx_commande_fournisseur.rowid','=','llx_commande_fournisseurdet.fk_commande' )
            ->where('llx_commande_fournisseur.fk_statut', '=', 3)
            ->whereNotNull('llx_commande_fournisseurdet.fk_product')
            //->groupBY('llx_commande_fournisseurdet.fk_product')
           ->pluck('llx_commande_fournisseurdet.qty', 'llx_commande_fournisseurdet.fk_product' )
           ->toArray();

    }

}