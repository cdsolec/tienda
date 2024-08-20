<?php

namespace App\Models;

use App\Queries\QueryFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Content extends Model implements Auditable
{
	use HasFactory;
	use SoftDeletes;
	use \OwenIt\Auditing\Auditable;
  
	/**
	 * The attributes that are mass assignable.
	 * 
	 * @var array
	 */
	protected $fillable = [
		'name', 'description'
	];

	/**
	 * Search Filters.
	 */
	public function scopeFilterBy($query, QueryFilter $filters, array $data)
	{
		return $filters->applyTo($query, $data);
	}
}
