<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class SocietyPeople extends Model
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
  protected $table = 'llx_socpeople';

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
     'datec', 'tms', 'fk_soc', 'entity', 'ref_ext', 'civility', 'lastname', 'firstname', 'address', 'zip', 'town', 'fk_departement', 'fk_pays', 'birthday', 'poste', 'phone', 'phone_perso', 'phone_mobile', 'fax', 'email', 'socialnetworks', 'photo', 'no_email', 'priv', 'fk_prospectlevel', 'fk_stcommcontact', 'fk_user_creat', 'fk_user_modif', 'note_private', 'note_public', 'default_lang', 'canvas', 'import_key', 'statut'
  ];

  

	
}
