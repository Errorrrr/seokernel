<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Price
 * 
 * @property int $id
 * @property float $cluster_price
 * @property float $conc_price
 *
 * @package App\Models
 */
class Price extends Model
{
	protected $table = 'prices';
	public $timestamps = false;

	protected $casts = [
		'cluster_price' => 'float',
		'conc_price' => 'float'
	];

	protected $fillable = [
		'cluster_price',
		'conc_price'
	];
}
