<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
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
  protected $table = 'llx_categorie';

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
    'entity', 'fk_parent', 'label', 'ref_ext', 'type', 'description', 'color', 'fk_soc', 'visible', 'date_creation', 
    'tms', 'fk_user_creat', 'fk_user_modif', 'import_key'
  ];

  /**
   * Get the parent that owns the category.
   */
  public function parent()
  {
    return $this->belongsTo(Category::class, 'fk_parent', 'rowid');
  }

  /**
   * Get the subcategories for the category.
   */
  public function subcategories()
  {
    return $this->hasMany(Category::class, 'fk_parent', 'rowid');
  }

  /**
   * The societes that belong to the category.
   */
  public function societies()
  {
    return $this->belongsToMany(Society::class, 'llx_categorie_societe', 'fk_categorie', 'fk_soc');
  }

  /**
   * The products that belong to the category.
   */
  public function products()
  {
    return $this->belongsToMany(Product::class, 'llx_categorie_product', 'fk_categorie', 'fk_product');
  }

  /**
   * Get the attributes associated with the product.
   */
  public function attributes()
  {
    $this->connection = DB::connection('mysql');
    
    return $this->hasOne(Attribute::class, 'rowid_erp', 'rowid');
  }
}
