<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAccount extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'total_charged', 'total_paid'];

    public static function rules()
    {
        return [
            'user_id' => 'required|exists:users,id|unique:user_accounts,user_id',
            'total_charged' => 'nullable|numeric|min:0',
            'total_paid' => 'nullable|numeric|min:0',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
