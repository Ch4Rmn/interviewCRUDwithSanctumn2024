<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'description',
        'price',
        'image',
        'type'
    ];

    public $appends = [
        'image_url',
        'human_readable_created_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function
    getImageUrlAttribute()
    {
        return asset('/uploads/' . $this->image);
    }

    // Created At
    public function getHumanReadableCreatedAtAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}
