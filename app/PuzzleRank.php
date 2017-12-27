<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Foundation\Auth\Archive as Authenticatable;

class PuzzleRank extends Model
{
	/**
     * 关联到模型的数据表
     *
     * @var string
     */
	protected $table = 'puzzle_rank';
	Protected $fillable = [
			'item_id', 'player_id','player_name', 'puzzle_id','time',
	];
}