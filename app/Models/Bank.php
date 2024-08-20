<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
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
  protected $table = 'llx_bank';

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
    'datec', 'tms', 'datev', 'dateo', 'amount', 'label', 'fk_account', 'fk_user_author', 'fk_user_rappro', 
    'fk_type', 'num_releve', 'num_chq', 'numero_compte', 'rappro', 'note', 'fk_bordereau', 'banque', 
    'emetteur', 'author', 'origin_id', 'origin_type', 'import_key'
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array
   */
  protected $casts = [
    'datev' => 'datetime:Y-m-d',
    'dateo' => 'datetime:Y-m-d',
  ];
}
