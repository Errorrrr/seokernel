<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Query
 * 
 * @property int $id
 * @property int $ws
 * @property string $query
 * @property int $wsk
 * @property int $numwords
 * @property int $main_queries_id
 * 
 * @property MainQuery $main_query
 *
 * @package App\Models
 */
class Query extends Model
{
	protected $table = 'queries';
	public $timestamps = false;

	protected $casts = [
		'ws' => 'int',
		'wsk' => 'int',
		'numwords' => 'int',
		'main_queries_id' => 'int'
	];

	protected $fillable = [
		'ws',
		'query',
		'wsk',
		'numwords',
		'main_queries_id'
	];

	public function main_query()
	{
		return $this->belongsTo(MainQuery::class, 'main_queries_id');
	}
}
