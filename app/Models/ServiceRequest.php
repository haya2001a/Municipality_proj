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
            'service_id' => 'required|exists:services,id',
            'documents.*' => 'nullable|file|max:5120'
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
    public function attachments()
    {
        return $this->hasMany(RequestAttachment::class, 'request_id');
    }
}
