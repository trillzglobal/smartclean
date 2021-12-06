<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardDetail extends Model
{
    use HasFactory;

    protected $attributes = [
        'api_response' => json_encode(['default', 'null'])
    ];
}
