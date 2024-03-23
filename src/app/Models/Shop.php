<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'area_id',
        'genre_id',
        'description',
        'opening_time',
        'closing_time',
        'image_url',
    ];

    public function area()
    {
        return $this->belongsTo('App\Models\Area', 'area_id', 'id');
    }

    public function genre()
    {
        return $this->belongsTo('App\Models\Genre', 'genre_id', 'id');
    }

    public function favorite()
    {
        return $this->belongsTo('App\Models\Favorite', 'id', 'shop_id')->where('user_id', 1); // TODO::user_idは仮
    }

    public function favoriteOnly()
    {
        return $this->hasOne('App\Models\Favorite')->where('user_id', auth()->id());
    }

    public function shopUsers()
    {
        return $this->hasMany('App\Models\ShopUser');
    }

    public function reservations()
    {
        return $this->hasMany('App\Models\Reservation');
    }
}
