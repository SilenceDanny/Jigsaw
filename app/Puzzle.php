<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Foundation\Auth\Archive as Authenticatable;

class Puzzle extends Model
{
	/**
     * 关联到模型的数据表
     *
     * @var string
     */
	protected $table = 'puzzles';
	Protected $fillable = [
			'puzzle_id', 'owner_id','owner_name', 'puzzle_name', 'path', 'mode',
	];
}