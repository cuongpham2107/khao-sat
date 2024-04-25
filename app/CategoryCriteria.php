<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CategoryCriteria extends Model
{
    protected $fillable = ['name','type'];
    public function category_parent(){
        return $this->belongsTo(\App\CategoryCriteria::class, 'parent_id', 'id');
    }
    
    public function getFullNameAttribute(){
        $type = '';
        if($this->type == 'MN'){
            $type = "Mầm non";
        }elseif($this->type == 'TH'){
            $type = "Tiểu học";
        }elseif($this->type == 'THCS'){
            $type = "Trung học cơ sở";
        }
        return "{$type }: {$this->name}";
    }
    public $additional_attributes = ['full_name'];
}
