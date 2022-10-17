<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ClusterQuery
 *
 * @property int $id
 * @property string $query
 * @property string $nameExcelFile
 * @property int $region_code
 * @property array $siteList
 * @property array $queryList
 * @property int $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $user_id
 *
 * @property User $user
 *
 * @package App\Models
 */
class ClusterQuery extends Model
{
	protected $table = 'cluster_queries';

	protected $casts = [
		'region_code' => 'int',
		'siteList' => 'json',
		'queryList' => 'json',
		'status' => 'int',
		'user_id' => 'int'
	];

	protected $fillable = [
		'query',
		'nameExcelFile',
		'region_code',
		'siteList',
		'queryList',
		'status',
		'user_id',
		'countQueries',
		'countNowQueries',
		'countMinusQueries',
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
