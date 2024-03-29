<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CancellationReason extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'name',
      'state',
      'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
