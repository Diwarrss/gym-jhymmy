<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'value',
      'to_date',
      'from_date',
      'user_id',
      'creator_user_id'
    ];

    public function userAdm()
    {
        return $this->belongsTo(\App\Models\User::class, 'creator_user_id');
    }
    public function userCli()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
