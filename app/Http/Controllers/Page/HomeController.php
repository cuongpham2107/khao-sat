<?php

namespace App\Http\Controllers\Page;

use App\CategoryCriteria;
use App\Competition;
use App\Criteria;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Evaluation;
use App\Unit;
use App\Department;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::guard('members')->user();
        $competition = Competition::where('status', 'hd')->first();
        if ($user && $user->type == "dv") {
            $unit = Unit::where('member_id', $user->id)->first();

            $message = null;
            if ($competition != null) {
                $evaluations = Evaluation::with('criteria')->where('unit_id', $unit->id)->where('competition_id', $competition->id)->get();
                $tree = $this->buildTreeUnit(null, $unit->type, $evaluations->pluck('id', 'criteria_id'));
                return view('home.unit')
                    ->with(compact(
                        'evaluations',
                        'tree',
                        'unit',
                        'competition',
                        'message'
                    ));
            } else {
                $message = "Hiện tại không có TIÊU CHÍ CHẤM ĐIỂM THI ĐUA nào đang diễn ra";

                return view('home.unit')->with(compact('message'));
            }
        } elseif ($user &&  $user->type == "k") {
            $department = Department::with('categoryCriteria')->where('member_id', $user->id)->first();
            $message = null;
            if ($competition != null && $department != null) {
                $evaluations = Evaluation::with('criteria','unit')->where('competition_id', $competition->id)->where('department_id',$department->id)->get()
                ->groupBy('unit.name');
              
                return view('home.department')
                    ->with(
                        compact(
                            'evaluations',
                            'department',
                            'message',
                            'competition'
                        )
                    );
            } else {
                $message = "Hiện tại không có TIÊU CHÍ CHẤM ĐIỂM THI ĐUA nào đang diễn ra";

                return view('home.department')->with(compact('message'));
            }
        }
    }
   
    private function buildTreeUnit($parent_id = null, $type, $evaluations = null)
    {
        $categories = CategoryCriteria::where('parent_id', $parent_id)->where('type', $type)->get();

        $tree = [];

        foreach ($categories as $category) {

            $children = $this->buildTreeUnit($category->id, $type, $evaluations);
            $criteriaIds = $evaluations->keys()->toArray();
            $criteria = Criteria::where('category_id', $category->id)
                ->whereIn('id', $criteriaIds)
                ->get()
                ->map(function ($item) use ($evaluations) {

                    $item->evaluation_id = $evaluations[$item->id];
                    return $item;
                });

            if ($criteria) {
                $category->criteria = $criteria;
            }
            if ($children->isNotEmpty()) {
                $category->children = $children;
            }
            $tree[] = $category;
        }

        return collect($tree);
    }
    public function send_evaluation(Request $request)
    {
       
        // try {
          
            $path = "evaluations";
            $user = Auth::guard('members')->user();
           
            $points = $request->input('point');
           
            if ($points) {
                if($request->input('type') && $request->input('type') == "department"){
                    $alert = [
                        "type" => "success",
                        "title" => __("Thành công"),
                        "body" => __("Cảm ơn bạn đã đánh giá tiêu chí cho các đợn vị!")
                    ];
                    foreach ($points as $key => $item) {
                        $department = Department::where('member_id', $user->id)->first();
                        $evaluation = Evaluation::where('department_id', $department->id)->find($key);
                        $evaluation->block_score = $item;
                        $evaluation->block_evaluation_date = date('Y-m-d');
                        $evaluation->save();
                    }
                }
                else{
                    $alert = [
                        "type" => "success",
                        "title" => __("Thành công"),
                        "body" => __("Cảm ơn bạn đã tự chấm điểm tiêu chí của đơn vị mình!")
                    ];
                    foreach ($points as $key => $item) {
                        $unit = Unit::where('member_id', $user->id)->first();
                        $evaluation = Evaluation::where('unit_id', $unit->id)->find($key);
                        if (array_key_exists($key, $request->file('file')) && $request->file('file')[$key]) {
                            $evaluation->file =  Storage::disk(config('voyager.storage.disk'))->putFile($path, $request->file('file')[$key]);
                        }
                        $evaluation->unit_evaluation_date = date('Y-m-d');
                        $evaluation->uint_score = $item;
                        $evaluation->save();
                    }
                }
            }
        // } catch (\Throwable $th) {
        //     $alert = [
        //         "type" => "error",
        //         "title" => __("Không thành công"),
        //         "body" => __("Có lỗi đã xảy ra, vui lòng thử lại!")
        //     ];
        // }
        return redirect()->back()->with('alert', $alert);
    }
}
