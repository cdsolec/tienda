<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Price extends Model
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
  protected $table = 'llx_product_price';

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
    'entity', 'tms', 'fk_product', 'date_price', 'price_level', 'price', 'price_ttc', 'price_min', 'price_min_ttc', 
    'price_base_type', 'default_vat_code', 'tva_tx', 'recuperableonly', 'localtax1_tx', 'localtax1_type', 
    'localtax2_tx', 'localtax2_type', 'fk_user_author', 'tosell', 'price_by_qty', 'fk_price_expression', 
    'import_key', 'fk_multicurrency', 'multicurrency_code', 'multicurrency_tx', 'multicurrency_price', 'multicurrency_price_ttc'
  ];

  /**
   * Get the Price with Discount.
   * 
   * @return string
   */
  public function getPriceDiscountAttribute()
  {
    if (Auth::check() && Auth::user()->society) { $discount_rate = Auth::user()->society->remise_client; } else { $discount_rate = 0; }

    $discount = ($this->price * $discount_rate) / 100;

    $price_discount = $this->price - $discount;
    
    return $price_discount;
  }

  /**
   * Get the product that owns the price.
   */
  public function product()
  {
    return $this->belongsTo(Product::class, 'fk_product', 'rowid');
  }
}
