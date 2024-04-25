<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Department extends Model
{
    public function categoryCriteria(){
        return $this->belongsToMany(CategoryCriteria::class,'department_category_criteria','department_id','category_criteria_id');
    }
}
