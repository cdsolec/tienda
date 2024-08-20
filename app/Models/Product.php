<?php

namespace App\Models;

use App\Queries\QueryFilter;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
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
  protected $table = 'llx_product';

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
    'ref', 'entity', 'ref_ext', 'datec', 'tms', 'fk_parent', 'label', 'description', 'note_public', 'note', 
    'customcode', 'fk_country', 'fk_state', 'price', 'price_ttc', 'price_min', 'price_min_ttc', 'price_base_type', 
    'cost_price', 'default_vat_code', 'tva_tx', 'recuperableonly', 'localtax1_tx', 'localtax1_type', 
    'localtax2_tx', 'localtax2_type', 'fk_user_author', 'fk_user_modif', 'tosell', 'tobuy', 'onportal', 'tobatch', 
    'fk_product_type', 'duration', 'seuil_stock_alert', 'url', 'barcode', 'fk_barcode_type', 
    'accountancy_code_sell', 'accountancy_code_sell_intra', 'accountancy_code_sell_export', 'accountancy_code_buy', 
    'accountancy_code_buy_intra', 'accountancy_code_buy_export', 'partnumber', 'net_measure_units', 'weight', 
    'weight_units', 'length', 'length_units', 'width', 'width_units', 'height', 'height_units', 'surface', 
    'surface_units', 'volume', 'volume_units', 'stock', 'pmp', 'fifo', 'lifo', 'fk_default_warehouse', 'canvas', 
    'finished', 'hidden', 'import_key', 'model_pdf', 'fk_price_expression', 'desiredstock', 'fk_unit', 
    'price_autogen', 'fk_project'
  ];

  /**
   * Search Filters.
   */
  public function scopeFilterBy($query, QueryFilter $filters, array $data)
  {
    return $filters->applyTo($query, $data);
  }

  /**
   * Get the prices for the blog post.
   */
  public function prices()
  {
    return $this->hasMany(Price::class, 'fk_product', 'rowid');
  }

  /**
   * Get the documents for the blog post.
   */
  public function documents()
  {
    return $this->hasMany(Document::class, 'src_object_id', 'rowid')
                ->where('src_object_type', '=', 'product');
  }

  /**
   * The categories that belong to the product.
   */
  public function categories()
  {
    return $this->belongsToMany(Category::class, 'llx_categorie_product', 'fk_product', 'fk_categorie');
  }

  /**
   * Get the extrafields associated with the product.
   */
  public function extrafields()
  {
    return $this->hasOne(ExtrafieldProduct::class, 'fk_object', 'rowid');
  }
}
