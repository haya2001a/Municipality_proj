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
            'title' => 'required|string|max:255',
            'description' => 'required|string'
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
