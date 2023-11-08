<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class labresults extends Model
{
    use HasFactory;
    public function labresult_images(){
        return $this->hasMany(labresults_images::class);
    }
}
