<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountTransaction extends Model
{
    use HasFactory;
     protected $fillable = ['user_id','request_id','amount','notes','approved_by'];

    public static function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'request_id' => 'required|exists:service_requests,id',
            'amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'approved_by' => 'nullable|exists:users,id',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function request()
    {
        return $this->belongsTo(ServiceRequest::class, 'request_id');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
