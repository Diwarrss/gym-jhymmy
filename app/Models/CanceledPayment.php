<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CanceledPayment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'description',
      'payment_id',
      'user_id',
      'cancellation_reason_id'
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function payment()
    {
        return $this->belongsTo(\App\Models\Payment::class);
    }

    public function cancellation_reason()
    {
        return $this->belongsTo(\App\Models\CancellationReason::class);
    }
}
