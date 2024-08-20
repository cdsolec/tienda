<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Attribute extends Model
{
  /**
   * The database connection that should be used by the model.
   *
   * @var string
   */
  protected $connection = 'mysql';

  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'tbatrib_categ';

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
    'numcategoria', 'numsubcategoria', 'categoria', 'subcategoria', 'rowid_erp', 'referencia_cds', 
    'referencia_fabricante', 'nombre_producto', 'descripcion', 'recomendaciones', 'alto', 'ancho', 'profundidad', 
    'peso', 'at1', 'at1f', 'at2', 'at2f', 'at3', 'at3f', 'at4', 'at4f', 'at5', 'at5f', 'at6', 'at6f', 'at7', 
    'at7f', 'at8', 'at8f', 'at9', 'at9f', 'at10', 'at10f', 'at11', 'at11f', 'at12', 'at12f', 'at13', 'at13f', 
    'at14', 'at14f', 'at15', 'at15f', 'at16', 'at16f', 'at17', 'at17f', 'at18', 'at18f', 'at19', 'at19f', 'at20', 
    'at20f', 'at21', 'at21f', 'at22', 'at22f', 'at23', 'at23f', 'at24', 'at24f', 'at25', 'at25f', 'at26', 'at26f', 
    'at27', 'at27f', 'at28', 'at28f', 'at29', 'at29f', 'at30', 'at30f', 'at31', 'at31f', 'at32', 'at32f', 'at33', 'at33f', 'at34', 'at34f', 'at35', 'at35f', 'at36', 'at36f', 'at37', 'at37f'
  ];

  /**
   * Get the category that owns the attribute.
   */
  public function category()
  {
    $this->connection = DB::connection('mysqlerp');
    
    return $this->belongsTo(Category::class, 'rowid_erp', 'rowid');
  }
}
