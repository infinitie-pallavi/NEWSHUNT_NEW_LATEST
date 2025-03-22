<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    protected $fillable = [
        'user_id',
        'setting_key',
        'setting_value',
    ];

    // Define relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
