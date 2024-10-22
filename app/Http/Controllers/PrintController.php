<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use Illuminate\Support\Facades\DB;

class PrintController extends Controller
{
    public function activityPrint($id)
    {
        $activity = Activity::find($id);
        $resource_id = $activity->resource_id;
        $resourceSkills = DB::table('resource_skill')
            ->join('skills', 'resource_skill.skill_id', '=', 'skills.id')
            ->where('resource_skill.resource_id', $resource_id)
            ->select('resource_skill.*', 'skills.name as skill_name')
            ->get();
        return view('printables.activity-print', compact('activity', 'resourceSkills'));
    }
}
