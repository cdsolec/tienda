<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fournisseur extends Model
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
  protected $table = 'llx_commande_fournisseur';

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
     'ref', 'entity', 'ref_ext', 'ref_supplier', 'fk_soc', 'fk_projet', 'tms', 'date_creation', 'date_valid', 'date_approve', 'date_approve2', 'date_commande', 'fk_user_author', 'fk_user_modif', 'fk_user_valid', 'fk_user_approve', 'fk_user_approve2', 'source', 'fk_statut', 'billed', 'amount_ht', 'remise_percent', 'remise', 'total_tva', 'localtax1', 'localtax2', 'total_ht', 'total_ttc', 'note_private', 'note_public', 'model_pdf', 'last_main_doc', 'date_livraison', 'fk_account', 'fk_cond_reglement', 'fk_mode_reglement', 'fk_input_method', 'fk_incoterms', 'location_incoterms', 'import_key', 'extraparams', 'fk_multicurrency', 'multicurrency_code', 'multicurrency_tx', 'multicurrency_total_ht', 'multicurrency_total_tva', 'multicurrency_total_ttc'
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array
   */
  protected $casts = [
    'date_creation' => 'datetime:Y-m-d',
    'date_valid' => 'datetime:Y-m-d',
    'date_approve' => 'datetime:Y-m-d',
    'date_approve2' => 'datetime:Y-m-d',
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
      case 2: $status = 'Aprobado'; break;
      case 3: $status = 'En espera de recibir'; break;
      case 4: $status = 'Recibido parcialmente'; break;
      case 5: $status = 'Todos los productos recibidos'; break;
      default: $status = 'Borrador'; break;
    }

    return $status;
  }

  /**
   * Get the commande_detail for the commande.
   */
  public function fournisseur_detail()
  {
    return $this->hasMany(FournisseurDetail::class, 'fk_commande', 'rowid');
  }

  /**
   * The society that belong to the commande.
   */
  public function society()
  {
    return $this->belongsTo(Society::class, 'fk_soc', 'rowid');
  }

 
}
