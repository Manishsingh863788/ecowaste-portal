<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecyclingTip extends Model
{
    protected $fillable = ['title', 'content', 'category', 'icon'];
}
