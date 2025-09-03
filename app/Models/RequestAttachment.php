<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestAttachment extends Model
{
    use HasFactory;
    protected $fillable = ['request_id', 'file_name', 'file_type', 'file_size', 'attachment_type'];

    public static function rules()
    {
        return [
            'request_id' => 'required|exists:service_requests,id',
            'file_name' => 'required|string|max:255',
            'file_type' => 'required|string|max:50',
            'file_size' => 'nullable|integer|min:0'
        ];
    }

    public function serviceRequest()
    {
        return $this->belongsTo(ServiceRequest::class, 'request_id');
    }
}
