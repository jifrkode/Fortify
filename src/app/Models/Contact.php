<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name', 'last_name', 'gender', 'email', 'tell', 'address', 'building', 'category', 'detail'
    ];

    // アクセサを追加
    public function getGenderAttribute($value)
    {
        $genders = [
            1 => 'male',
            2 => 'female',
            3 => 'other'
        ];
        return $genders[$value];
    }

    // リレーションの定義
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
