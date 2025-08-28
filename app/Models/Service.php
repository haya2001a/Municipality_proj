<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'department_id', 'description', 'price', 'processing_time_min', 'processing_time_max', 'required_documents', 'terms_conditions', 'notes', 'status'];

    public static function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'processing_time_min' => 'nullable|integer|min:1',
            'processing_time_max' => 'nullable|integer|min:1',
            'required_documents' => 'nullable|array',
            'terms_conditions' => 'nullable|string',
            'notes' => 'nullable|string',
            'status' => 'required|in:فعّالة,غير فعّالة',
        ];
    }

    protected $casts = [
        'required_documents' => 'array',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
