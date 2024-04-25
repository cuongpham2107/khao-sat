<?php

namespace App\Http\Controllers\Admin;

use App\Department;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Evaluation;

class EvaluationController extends Controller
{
    public function store($id){
        try {
            $competition = \App\Competition::find($id);
            $units = \App\Unit::where('status','active')->get();
            $criterias = \App\Criteria::with('categoryCriteria')
            ->where('status','active')
            ->get();

            $MNCriteria = $criterias->filter(function ($criteria) {
                return $criteria->categoryCriteria->type === 'MN';
            });
            
            $THCriteria = $criterias->filter(function ($criteria) {
                return $criteria->categoryCriteria->type === 'TH';
            });
            
            $THCSCriteria = $criterias->filter(function ($criteria) {
                return $criteria->categoryCriteria->type === 'THCS';
            });
            
            foreach($units as $unit){
               
                // dd($department_id);
                if($unit->type == "MN"){
                    $department_id = Department::where('type', "MN")->first()->id;
                    foreach($MNCriteria as $criteria){
                        $evaluation = new Evaluation();
                        $evaluation->department_id = $department_id;
                        $evaluation->unit_id = $unit->id;
                        $evaluation->criteria_id = $criteria->id;
                        $evaluation->competition_id = $id;
                        $evaluation->save();
                    }
                }elseif($unit->type == "TH"){
                    $department_id = Department::where('type', "TH")->first()->id;
                    foreach($THCriteria as $criteria){
                        $evaluation = new Evaluation();
                        $evaluation->unit_id = $unit->id;
                        $evaluation->department_id = $department_id;
                        $evaluation->criteria_id = $criteria->id;
                        $evaluation->competition_id = $id;
                        $evaluation->save();
                    }

                }elseif($unit->type == "THCS"){
                    $department_id = Department::where('type', "THCS")->first()->id;
                    foreach($THCSCriteria as $criteria){
                        $evaluation = new Evaluation();
                        $evaluation->unit_id = $unit->id;
                        $evaluation->department_id = $department_id;
                        $evaluation->criteria_id = $criteria->id;
                        $evaluation->competition_id = $id;
                        $evaluation->save();
                    }
                }
            }
            $competition->status = 'hd';
            $competition->save();
            $alert = [
                "type" => "success",
                "title" => __("Thành công"),
                "body" => __("Đã tạo tiêu chí cho các đơn vị trong đợi .' $competition->name '. thành công !")
              ];
        } catch (\Throwable $th) {
            $alert = [
                "type" => "error",
                "title" => __("Không thành công"),
                "body" => __("Có lỗi đã xảy ra, vui lòng thử lại!")
              ];
        }
        return redirect()->back()->with('alert', $alert);
    }
}
