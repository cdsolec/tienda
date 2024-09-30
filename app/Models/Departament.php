<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departament extends Model
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
  protected $table = 'llx_c_departements';

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
    'rowid','code_departement', 'fk_region', 'cheflieu', 'tncc', 'ncc', 'nom', 'active'
  ];

  
}
