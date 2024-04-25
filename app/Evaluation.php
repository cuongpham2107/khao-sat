<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Evaluation extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    public function criteria(){
        return $this->belongsTo(\App\Criteria::class, 'criteria_id', 'id');
    }
    public function unit(){
        return $this->belongsTo(\App\Unit::class, 'unit_id', 'id');
    }
}
