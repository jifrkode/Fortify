<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['content'];

    public function categoryID($value)
    {
        $categoryIds = [
            1 => '商品のお届け',
            2 => '商品の交換',
            3 => '商品トラブル',
            4 => 'ショップへのお問い合わせ',
            5 => 'その他'
        ];
        return $categoryIds[$value];
    }
    // リレーションの定義
    public function contacts()
    {
        return $this->hasMany(Contact::class, 'category_id');
    }
}
