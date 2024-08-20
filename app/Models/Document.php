<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
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
  protected $table = 'llx_ecm_files';

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
    'ref', 'label', 'share', 'entity', 'filepath', 'filename', 'src_object_type', 'src_object_id', 'fullpath_orig', 
    'description', 'keywords', 'cover', 'position', 'gen_or_uploaded', 'extraparams', 'date_c', 'tms', 'fk_user_c',  
    'fk_user_m',  'acl'
  ];

  /**
   * Get the product that owns the price.
   */
  public function product()
  {
    return $this->belongsTo(Product::class, 'src_object_id', 'rowid')
                ->where('src_object_type', '=', 'product');
  }
}
