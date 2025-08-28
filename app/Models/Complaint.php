<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','title','description','status','closed_at'];

    public static function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:قيد الانتظار,مرفوض,مكتمل',
            'closed_at' => 'nullable|date',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
