<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    public function categoryCriteria(){
        return $this->belongsTo(\App\CategoryCriteria::class, 'category_id', 'id');
    }
    
    
}
