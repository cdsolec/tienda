<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
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
  protected $table = 'llx_commande';

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
    'ref', 'entity', 'ref_ext', 'ref_int', 'ref_client', 'fk_soc', 'fk_projet', 'tms', 'date_creation',
    'date_valid', 'date_cloture', 'date_commande', 'fk_user_author', 'fk_user_modif', 'fk_user_valid', 
    'fk_user_cloture', 'source', 'fk_statut', 'amount_ht', 'remise_percent', 'remise_absolue', 'remise',
    'total_tva', 'localtax1', 'localtaxt2', 'total_ht', 'total_ttc', 'note_private', 'note_public', 
    'model_pdf', 'last_main_doc', 'module_source', 'pop_source', 'facture', 'fk_account', 'fk_currency', 
    'fk_cond_reglement', 'fk_mode_reglement', 'date_livraison', 'fk_shipping_method', 'fk_warehouse', 
    'fk_availability', 'fk_input_reason', 'fk_delivery_address', 'fk_incoterms', 'location_incoterms', 
    'import_key', 'extraparams', 'fk_multicurrency', 'multicurrency_code', 'multicurrency_tx', 
    'multicurrency_total_ht', 'multicurrency_total_tva', 'multicurrency_total_ttc'
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array
   */
  protected $casts = [
    'date_creation' => 'datetime:Y-m-d',
    'date_valid' => 'datetime:Y-m-d',
    'date_cloture' => 'datetime:Y-m-d',
    'date_commande' => 'datetime:Y-m-d',
  ];

  /**
   * Get the commande's status.
   * 
   * @return string
   */
  public function getStatusAttribute()
  {
    switch ($this->fk_statut) {
      case 0: $status = 'Borrador'; break;
      case 1: $status = 'Validado'; break;
      case 2: $status = 'Envió en curso'; break;
      case 3: $status = 'Emitido'; break;
      default: $status = 'Borrador'; break;
    }

    return $status;
  }

  /**
   * Get the commande_detail for the commande.
   */
  public function commande_detail()
  {
    return $this->hasMany(CommandeDetail::class, 'fk_commande', 'rowid');
  }

  /**
   * The society that belong to the commande.
   */
  public function society()
  {
    return $this->belongsTo(Society::class, 'fk_soc', 'rowid');
  }

  /**
   * The propals that belong to the commande.
   */
  public function propals()
  {
    return $this->belongsToMany(Propal::class, 'llx_element_element', 'fk_target', 'fk_source')
                ->where('sourcetype', 'propal')
                ->where('targettype', 'commande');
  }

  /**
   * The factures that belong to the commande.
   */
  public function factures()
  {
    return $this->belongsToMany(Facture::class, 'llx_element_element', 'fk_source', 'fk_target')
                ->where('sourcetype', 'commande')
                ->where('targettype', 'facture');
  }
}
