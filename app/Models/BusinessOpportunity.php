<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessOpportunity extends Model
{
    protected $fillable = [
        'category',
        'product_type',
        'product_name',
        'social_media',
        'website',
        'phone_number',
        'partner_need',
        'lat',
        'lng',
        'slug',
        'is_active',
        'is_featured',
        'image_path',
    ];

}
