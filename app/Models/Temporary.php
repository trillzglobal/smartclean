<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Temporary extends Model
{
    use HasFactory;



    public function token() {
        return $this->belongsTo(Token::class);
    }
    
}
