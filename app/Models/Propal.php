<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Propal extends Model
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
  protected $table = 'llx_propal';

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
    'ref', 'entity', 'ref_ext', 'ref_int', 'ref_client', 'fk_soc', 'fk_projet', 'tms', 'datec',
    'datep', 'fin_validite', 'date_valid', 'date_cloture', 'fk_user_author', 'fk_user_modi',
    'fk_user_valid', 'fk_user_cloture', 'fk_statut', 'price', 'remise_percent',
    'remise_absolue', 'remise', 'total_ht', 'total_tva', 'localtax1', 'localtaxt2', 'total_ttc',
    'fk_account', 'fk_currency', 'fk_cond_reglement', 'fk_mode_reglement', 'note_private',
    'note_public', 'model_pdf', 'last_main_doc', 'date_livraison', 'fk_shipping_method',
    'fk_availability', 'fk_input_reason', 'fk_incoterms', 'location_incoterms', 'import_key',
    'extraparams', 'fk_delivery_address', 'fk_multicurrency', 'multicurrency_code',
    'multicurrency_tx', 'multicurrency_total_ht', 'multicurrency_total_tva',
    'multicurrency_total_ttc'
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array
   */
  protected $casts = [
    'created_at' => 'datetime:Y-m-d',
    'datec' => 'datetime:Y-m-d',
    'datep' => 'datetime:Y-m-d',
    'fin_validite' => 'datetime:Y-m-d',
    'date_valid' => 'datetime:Y-m-d',
    'date_cloture' => 'datetime:Y-m-d',
  ];

  /**
   * Get the propal's status.
   * 
   * @return string
   */
  public function getStatusAttribute()
  {
    switch ($this->fk_statut) {
      case 0: $status = 'Borrador'; break;
      case 1: $status = 'Abierto'; break;
      case 2: $status = 'Firmado (Aprobado)'; break;
      case 3: $status = 'No Firmado (Rechazado)'; break;
      case 4: $status = 'Facturado'; break;
      default: $status = 'Borrador'; break;
    }

    return $status;
  }

  /**
   * Get the propal_detail for the propal.
   */
  public function propal_detail()
  {
    return $this->hasMany(PropalDetail::class, 'fk_propal', 'rowid');
  }

  /**
   * The society that belong to the propal.
   */
  public function society()
  {
    return $this->belongsTo(Society::class, 'fk_soc', 'rowid');
  }

  /**
   * The commandes that belong to the propal.
   */
  public function commandes()
  {
    return $this->belongsToMany(Commande::class, 'llx_element_element', 'fk_source', 'fk_target')
                ->where('sourcetype', 'propal')
                ->where('targettype', 'commande');
  }
}
