<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
  /**
   * The database connection that should be used by the model.
   *
   * @var string
   */
  protected $connection = 'mysqlerp';

  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'llx_facture';

  /**
   * The primary key associated with the table.
   *
   * @var string
   */
  protected $primaryKey = 'rowid';

  /**
   * Indicates if the model should be timestamped.
   *
   * @var bool
   */
  public $timestamps = false;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'ref', 'entity', 'ref_ext', 'ref_int', 'ref_client', 'type', 'fk_soc', 'datec', 'datef', 
    'date_pointoftax', 'date_valid', 'tms', 'date_closing', 'paye', 'remise_percent', 'remise_absolue', 
    'remise', 'close_code', 'close_note', 'total_tva', 'localtax1', 'localtaxt2', 'revenuestamp', 'total_ht', 
    'total_ttc', 'fk_statut', 'fk_user_author', 'fk_user_modif', 'fk_user_valid', 'fk_user_closing', 
    'module_source', 'pop_source', 'fk_fac_rec_source', 'fk_facture_source', 'fk_project', 'increment', 
    'fk_account', 'fk_currency', 'fk_cond_reglement', 'fk_mode_reglement', 'date_lim_reglement', 
    'note_private', 'note_public', 'model_pdf', 'last_main_doc', 'fk_incoterms', 'location_incoterms', 
    'fk_mode_transport', 'situation_cycle_ref', 'situation_counter', 'situation_final', 
    'retained_warranty', 'retained_warranty_date_limit', 'retained_warranty_fk_cond_reglement', 
    'import_key', 'extraparams', 'fk_multicurrency', 'multicurrency_code', 'multicurrency_tx', 
    'multicurrency_total_ht', 'multicurrency_total_tva', 'multicurrency_total_ttc'
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array
   */
  protected $casts = [
    'datec' => 'datetime:Y-m-d',
    'datef' => 'datetime:Y-m-d',
    'date_pointoftax' => 'datetime:Y-m-d',
    'date_valid' => 'datetime:Y-m-d',
    'date_closing' => 'datetime:Y-m-d',
    'date_lim_reglement' => 'datetime:Y-m-d',
  ];

  /**
   * Get the facture_detail for the facture.
   */
  public function facture_detail()
  {
    return $this->hasMany(FactureDetail::class, 'fk_facture', 'rowid');
  }

  /**
   * The commandes that belong to the facture.
   */
  public function commandes()
  {
    return $this->belongsToMany(Commande::class, 'llx_element_element', 'fk_target', 'fk_source')
                ->where('sourcetype', 'commande')
                ->where('targettype', 'facture');
  }

  /**
   * The propals that belong to the commande.
   */
  public function propals()
  {
    return $this->belongsToMany(Propal::class, 'llx_element_element', 'fk_target', 'fk_source')
                ->where('sourcetype', 'propal')
                ->where('targettype', 'facture');
  }

  /**
   * The paiements that belong to the commande.
   */
  public function paiements()
  {
    return $this->belongsToMany(Paiement::class, 'llx_paiement_facture', 'fk_facture', 'fk_paiement');
  }
}
