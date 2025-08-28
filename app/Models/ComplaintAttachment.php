<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplaintAttachment extends Model
{
    use HasFactory;
    protected $fillable = ['complaint_id', 'file_name', 'file_type', 'file_size', 'attachment_type'];

    public static function rules()
    {
        return [
            'complaint_id' => 'required|exists:complaints,id',
            'file_name' => 'required|string|max:255',
            'file_type' => 'required|string|max:50',
            'file_size' => 'nullable|integer|min:0',
            'attachment_type' => 'required|in:صورة هوية,صورة شخصية,شهادة,عقد,غيرها',
        ];
    }

    public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }
}
