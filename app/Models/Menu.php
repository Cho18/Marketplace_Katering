<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'photo',
        'price',
        'description',
        'user_id',
        'type_of_food',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
