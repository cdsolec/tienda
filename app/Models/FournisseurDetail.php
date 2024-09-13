<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FournisseurDetail extends Model
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
  protected $table = 'llx_commande_fournisseurdet';

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
    'fk_commande', 'fk_parent_line', 'fk_product', 'ref', 'label', 'description', 'vat_src_code', 'tva_tx', 'localtax1_tx', 'localtax1_type', 'localtax2_tx', 'localtax2_type', 'qty', 'remise_percent', 'remise', 'subprice', 'total_ht', 'total_tva', 'total_localtax1', 'total_localtax2', 'total_ttc', 'product_type', 'date_start', 'date_end', 'info_bits', 'special_code', 'rang', 'import_key', 'fk_unit', 'fk_multicurrency', 'multicurrency_code', 'multicurrency_subprice', 'multicurrency_total_ht', 'multicurrency_total_tva', 'multicurrency_total_ttc'
  ];
  
  /**
   * Get the commande that owns the commande_detail.
   */
  public function commande()
  {
    return $this->belongsTo(Commande::class, 'fk_commande', 'rowid');
  }
  
  /**
   * Get the product that owns the commande_detail.
   */
  public function product()
  {
    return $this->belongsTo(Product::class, 'fk_product', 'rowid');
  }
}
