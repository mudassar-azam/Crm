<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function index()
    {
        // Fetch all skills from the database
        $skills = Skill::all();
        // Return the skills as a JSON response
        return response()->json($skills, 200);
    }
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $skill = new Skill();
        $skill->name = $request->name;
        $skill->save();
        // Return a response indicating success
        return response()->json(['message' => 'Skill created successfully'], 201);
    }
    public function update(Request $request, $id)
    {


        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255', // You can adjust the validation rules as needed
        ]);

        // Find the skill by ID
        $skill = Skill::findOrFail($id);

        // Update the skill name
        $skill->name = $request->input('name');
        $skill->save();

        // Return a response
        return response()->json(['message' => 'Skill updated successfully'], 200);
    }
    public function destroy($id)
    {
        // Find the skill by ID
        $skill = Skill::find($id);

        // If the skill exists, delete it
        if ($skill) {
            $skill->delete();
            return response()->json(['message' => 'Skill deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Skill not found'], 404);
        }
    }
}
