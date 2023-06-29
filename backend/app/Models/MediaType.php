<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaType extends Model
{
    use HasFactory;

    const AUDIO_MEDIA_TYPE = 1;
    const VIDEO_MEDIA_TYPE = 2;
    const IMAGE_MEDIA_TYPE = 3;
}
