<?php

namespace App\Models;

use App\Queries\QueryFilter;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;

class User extends Authenticatable implements Auditable
{
  use HasApiTokens;
  use HasFactory;
  use HasProfilePhoto;
  use Notifiable;
  use TwoFactorAuthenticatable;
  use \OwenIt\Auditing\Auditable;

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
  protected $table = 'llx_user';

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
    'entity', 'ref_ext', 'ref_int', 'admin', 'employee', 'fk_establishment', 'datec', 'tms', 'fk_user_creat', 
    'fk_user_modif', 'login', 'pass_encoding', 'pass', 'pass_crypted', 'pass_temp', 'api_key', 'gender', 'civility', 
    'lastname', 'firstname', 'address', 'zip', 'town', 'fk_state', 'fk_country', 'birth', 'job', 'office_phone', 
    'office_fax', 'user_mobile', 'personal_mobile', 'email', 'personal_email', 'signature', 'solcialnetworks', 
    'fk_soc', 'fk_socpeople', 'fk_member', 'fk_user', 'fk_user_expense_validator', 'fk_user_holiday_validator', 
    'idpers1', 'idpers2', 'idpers3', 'note_public', 'note', 'model_pdf', 'datelastlogin', 'datepreviouslogin', 
    'datelastpassvalidation', 'datestartvalidity', 'dateendvalidity', 'iplastlogin', 'ippreviouslogin', 
    'egroupware_id', 'ldap_sid', 'openid', 'statut', 'photo', 'lang', 'color', 'barcode', 'fk_barcode_type', 
    'accountancy_code', 'nb_holiday', 'thm', 'tjm', 'salary', 'salaryextra', 'dateemployment', 'dateemploymentend', 
    'weeklyhours', 'import_key', 'default_range', 'default_c_exp_tax_cat', 'fk_warehouse'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'pass_encoding', 
    'pass', 
    'pass_crypted', 
    'pass_temp',
  ];

  /**
   * The accessors to append to the model's array form.
   *
   * @var array
   */
  protected $appends = [
    'identification', 'company', 'type'
  ];

  /**
  * Overrides the method to ignore the remember token.
  */
  public function setAttribute($key, $value)
  {
    $isRememberTokenAttribute = $key == $this->getRememberTokenName();

    if (!$isRememberTokenAttribute) {
      parent::setAttribute($key, $value);
    }
  }

  /**
   * Get the user's password.
   * 
   * @return string
   */
  public function getAuthPassword()
  {
    return $this->pass_crypted;
  }

  /**
   * Get the user's full name.
   * 
   * @return string
   */
  public function getFullNameAttribute()
  {
    return "{$this->firstname} {$this->lastname}";
  }

  /**
   * Get the user's identification.
   * 
   * @return string
   */
  public function getIdentificationAttribute()
  {
    return $this->society->siren;
  }

  /**
   * Get the user's company.
   * 
   * @return string
   */
  public function getCompanyAttribute()
  {
    $contains = Str::contains($this->society->nom, ['(', ')']);

    if ($contains) {
      return Str::between($this->society->nom, '(', ')');
    } 
    
    return '';
  }

  /**
   * Get the user's type.
   * 
   * @return string
   */
  public function getTypeAttribute()
  {
    return optional($this->society->categories->first())->rowid;
  }

  /**
   * Search Filters.
   */
  public function scopeFilterBy($query, QueryFilter $filters, array $data)
  {
    return $filters->applyTo($query, $data);
  }

  /**
   * Get the society that owns the user.
   */
  public function society()
  {
    return $this->belongsTo(Society::class, 'fk_soc', 'rowid');
  }
}
