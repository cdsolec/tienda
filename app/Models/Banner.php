<?php

namespace App\Models;

use App\Queries\QueryFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Facades\Storage;

class Banner extends Model implements Auditable
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
		'name', 'image'
	];

	/**
	 * Get the url image.
	 *
	 * @return string
	 */
	public function getUrlImageAttribute()
	{
		// $url = Storage::url('banners/'.$this->image);
		$url = env('APP_URL').'/storage2/banners/'.$this->image;
		return $url;
	}

	/**
	 * Search Filters.
	 */
	public function scopeFilterBy($query, QueryFilter $filters, array $data)
	{
		return $filters->applyTo($query, $data);
	}
}
