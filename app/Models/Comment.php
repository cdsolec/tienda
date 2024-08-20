<?php

namespace App\Models;

use App\Queries\QueryFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Comment extends Model implements Auditable
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
		'name', 'email', 'phone', 'message', 'answered', 'answer'
	];

	/**
	 * Search Filters.
	 */
	public function scopeFilterBy($query, QueryFilter $filters, array $data)
	{
		return $filters->applyTo($query, $data);
	}
}
