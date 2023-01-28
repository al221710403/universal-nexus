<?php

namespace App\Models\Publish;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $table = 'images_post';

    protected $fillable = [
        'image_url',
        'post_id'
    ];
}
