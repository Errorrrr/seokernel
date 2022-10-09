<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SearchRegion
 * 
 * @property int $id
 * @property int $code
 * @property string $name
 *
 * @package App\Models
 */
class SearchRegion extends Model
{
	protected $table = 'search_region';
	public $timestamps = false;

	protected $casts = [
		'code' => 'int'
	];

	protected $fillable = [
		'code',
		'name'
	];
}
