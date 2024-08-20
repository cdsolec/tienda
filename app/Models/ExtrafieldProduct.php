<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExtrafieldProduct extends Model
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
  protected $table = 'llx_product_extrafields';

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
    'tms', 'fk_object', 'import_key', 
    'at1', 'at2', 'at3', 'at4', 'at5', 'at6', 'at7', 'at8', 'at9', 'at10', 'at11', 'at12', 'at13', 'at14', 'at15', 
    'at16', 'at17', 'at18', 'at19', 'at20', 'at21', 'at22', 'at23', 'at24', 'at25', 'at26', 'at27', 'at28', 'at29', 
    'at30'
  ];
  
  /**
   * Get the product that owns the phone.
   */
  public function product()
  {
    return $this->belongsTo(Product::class, 'fk_object', 'rowid');
  }
}
