<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Foundation\Auth\Archive as Authenticatable;

class Feedback extends Model
{
	/**
     * 关联到模型的数据表
     *
     * @var string
     */
	protected $table = 'feedback';
	Protected $fillable = [
			'id', 'feedbacker','email', 'message',
	];
}