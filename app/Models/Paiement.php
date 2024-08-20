<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
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
  protected $table = 'llx_paiement';

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
    'ref', 'ref_ext', 'entity', 'datec', 'tms', 'datep', 'amount', 'multicurrency_amount', 'fk_paiement', 
    'num_paiement', 'note', 'ext_payment_id', 'ext_payment_site', 'fk_bank', 'fk_user_creat', 'fk_user_modif', 
    'statut', 'fk_export_compta', 'pos_change'
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array
   */
  protected $casts = [
    'datec' => 'datetime:Y-m-d',
    'datep' => 'datetime:Y-m-d',
  ];
  
  /**
   * Get the type that owns the paiement.
   */
  public function type()
  {
    return $this->belongsTo(CPaiement::class, 'fk_paiement', 'id');
  }
}
