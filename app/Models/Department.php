<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'manager_id', 'phone', 'location', 'working_hours'];

    public static function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'manager_id' => 'required|exists:users,id',
            'phone' => 'nullable|string|max:20',
            'location' => 'nullable|string',
            'working_hours' => 'nullable|array',
        ];
    }

    protected $casts = [
        'working_hours' => 'array',
    ];

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function employees()
    {
        return $this->hasMany(User::class, 'department_id');
    }
}
