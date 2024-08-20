<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Extrafield extends Model
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
  protected $table = 'llx_extrafields';

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
    'name', 'entity', 'elementtype', 'label', 'type', 'size', 'fieldcomputed', 'fielddefault', 'fieldunique', 
    'fieldrequired', 'perms', 'enabled', 'pos', 'alwaysediable', 'param', 'list', 'printable', 'totalizable', 
    'langs', 'help', 'fk_user_author', 'fk_user_modif', 'datec', 'tms'
  ];
}
