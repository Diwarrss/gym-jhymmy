<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tracing extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'back',
      'chest',
      'calf',
      'leg',
      'arm',
      'waist',
      'weight',
      'size',
      'user_id',
      'state'
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
