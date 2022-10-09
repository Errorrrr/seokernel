<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MainQuery
 * 
 * @property int $id
 * @property string $query
 * @property string $nameExcelFile
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $user_id
 * 
 * @property User $user
 * @property Collection|Query[] $queries
 *
 * @package App\Models
 */
class MainQuery extends Model
{
	protected $table = 'main_queries';

	protected $casts = [
		'user_id' => 'int'
	];

	protected $fillable = [
		'query',
		'nameExcelFile',
		'user_id'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function queries()
	{
		return $this->hasMany(Query::class, 'main_queries_id');
	}
}
