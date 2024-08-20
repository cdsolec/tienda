<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
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
  protected $table = 'llx_bank_account';

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
    'datec', 'tms', 'ref', 'label', 'entity', 'fk_user_author', 'fk_user_modif', 'bank', 'code_banque', 
    'code_guichet', 'number', 'cle_rib', 'bic', 'iban_prefix', 'country_iban', 'domiciliation', 'state_id', 
    'fk_pays', 'proprio', 'owner_address', 'courant', 'clos', 'rappro', 'url', 'account_number', 
    'fk_accountancy_journal', 'currency_code', 'min_allowed', 'min_desired', 'comment', 'note_public', 
    'model_pdf', 'import_key', 'extraparams'
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array
   */
  protected $casts = [
    'datec' => 'datetime:Y-m-d',
  ];
}
