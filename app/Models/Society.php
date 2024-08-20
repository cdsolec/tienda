<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Society extends Model
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
  protected $table = 'llx_societe';

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
    'nom', 'name_alias', 'entity', 'ref_ext', 'ref_int', 'statut', 'parent', 'status', 'code_client', 
    'code_fournisseur', 'code_compta', 'code_compta_fournisseur', 'address', 'zip', 'town', 'fk_departament', 
    'fk_pays', 'fk_account', 'phone', 'fax', 'url', 'email', 'socialnetworks', 'skype', 'twitter', 'facebook', 
    'linkedin', 'instagram', 'snapchat', 'googleplus', 'youtube', 'whatsapp', 'fk_effectif', 'fk_typent', 
    'fk_forme_juridique', 'fk_currency', 'siren', 'siret', 'ape', 'idprof4', 'idprof5', 'idprof6', 'tva_intra', 
    'capital', 'fk_stcomm', 'note_private', 'note_public', 'model_pdf', 'prefix_comm', 'client', 'fournisseur', 
    'supplier_account', 'fk_prospectlevel', 'fk_incoterms', 'location_incoterms', 'customer_bad', 'customer_rate', 
    'supplier_rate', 'remise_client', 'remise_supplier', 'mode_reglement', 'cond_reglement', 'transport_mode', 
    'mode_reglement_supplier', 'cond_reglement_supplier', 'transport_mode_supplier', 'fk_shipping_method', 
    'tva_assuj', 'localtaxt1_assuj', 'localtaxt1_value', 'localtaxt2_assuj', 'localtaxt2_value', 'barcode', 
    'fk_barcode_type', 'price_level', 'outstanding_limit', 'order_min_amount', 'supplier_order_min_amount', 
    'default_lang', 'logo', 'logo_squarred', 'canvas', 'fk_entrepot', 'webservices_url', 'webservices_key', 'tms', 
    'datec', 'fk_user_creat', 'fk_user_modif', 'fk_multicurrency', 'multicurrency_code', 'import_key'
  ];

	/**
	 * Atributo Url Image.
	 */
	public function getUrlImageAttribute()
	{
    $image = 'img/favicon/apple-icon.png';

    if(App::environment('production') && $this->logo) {
      $image = 'storage/societe/'.$this->rowid.'/logos/'.$this->logo;
    }

		return $image;
	}

  /**
   * Get the user that owns the society.
   */
  public function user()
  {
    return $this->belongsTo(User::class, 'fk_soc', 'rowid');
  }

  /**
   * The categories that belong to the society.
   */
  public function categories()
  {
    return $this->belongsToMany(Category::class, 'llx_categorie_societe', 'fk_soc', 'fk_categorie');
  }
}
