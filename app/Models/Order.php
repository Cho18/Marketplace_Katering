<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_id',
        'user_id',
        'quantity',
        'delivery_date',
        'delivery_time'
    ];

    // Relasi ke model Menu
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    // Relasi ke model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke model Invoice
    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
