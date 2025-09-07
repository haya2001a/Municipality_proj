<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    use HasFactory;
    protected $table = 'trades';

    protected $fillable = ['user_id', 'trade_name', 'opened_since', 'issue_date', 'expiry_date', 'last_payment', 'status', 'fees', 'paid_fees'];

     protected $casts = [
        'opened_since' => 'datetime',
        'issue_date' => 'datetime',
        'expiry_date' => 'datetime',
        'last_payment' => 'datetime',
    ];

    public static function calculateFees($lastPayment)
    {
        $lastPayment = Carbon::parse($lastPayment);
        $today = Carbon::now();

        $daysPassed = $today->diffInDays($lastPayment);

        $yearsToPay = max(0, ceil($daysPassed / 365) - 1);

        return $yearsToPay * 25;
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
