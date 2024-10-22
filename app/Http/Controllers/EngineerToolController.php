<?php

namespace App\Http\Controllers;

use App\Models\EngineerTool;
use Illuminate\Http\Request;

class EngineerToolController extends Controller
{
    public function index()
    {
        $engineerTool = EngineerTool::all();
        return view('tools.index', compact('engineerTool'));
    }


    public function create()
    {
        return view('tools.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:tools|max:255',
        ]);
        $tool=   EngineerTool::create($request->all());
        return response()->json(['message' => 'Tool created successfully', 'skill' => $tool], 201);
    }

    public function show(EngineerTool $engineerTool)
    {
        return view('tools.show', compact('engineerTool'));
    }

    public function edit(Tool $tool)
    {
        return view('tools.edit', compact('engineerTool'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255', 
        ]);
        $tool = EngineerTool::findOrFail($id);
        $tool->name = $request->input('name');
        $tool->save();
        return response()->json(['message' => 'Tool updated successfully'], 200);
    }

    public function destroy($id)
    {
        // Find the skill by ID
        $tool = EngineerTool::find($id);
        // If the skill exists, delete it
        if ($tool) {
            $tool->delete();
            return response()->json(['message' => 'Tool deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Tool not found'], 404);
        }
    }
}
