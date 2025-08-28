<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'service_id', 'status', 'priority', 'price', 'assigned_to', 'department_id', 'completed_at'];

    public static function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'status' => 'required|in:بانتظار الموافقة,مرفوض,مكتمل,مدفوع',
            'priority' => 'required|in:غير عاجل,متوسط,عاجل',
            'price' => 'nullable|numeric|min:0',
            'assigned_to' => 'nullable|exists:users,id',
            'department_id' => 'nullable|exists:departments,id',
            'completed_at' => 'nullable|date',
        ];
    }

    protected $casts = [
        'completed_at' => 'datetime',
        'price' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
