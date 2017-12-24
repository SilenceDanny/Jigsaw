<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Foundation\Auth\Archive as Authenticatable;

class archive extends Model
{
	/**
     * 关联到模型的数据表
     *
     * @var string
     */
	protected $table = 'archives';
	Protected $fillable = [
			'archive_id', 'puzzle_id', 'owner', 'archive_path',
	];
}