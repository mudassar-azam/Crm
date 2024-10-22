<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use Illuminate\Http\Request;

class ToolController extends Controller
{
    public function index()
    {
        $tools = Tool::all();

        return view('tools.index', compact('tools'));
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

     $tool=   Tool::create($request->all());

        return response()->json(['message' => 'Tool created successfully', 'skill' => $tool], 201);
    }

    public function show(Tool $tool)
    {
        return view('tools.show', compact('tool'));
    }


    public function edit(Tool $tool)
    {
        return view('tools.edit', compact('tool'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required|string|max:255', 
        ]);

        $tool = Tool::findOrFail($id);

        $tool->name = $request->input('name');
        $tool->save();

        return response()->json(['message' => 'Tool updated successfully'], 200);
    }

    public function destroy($id)
    {
        $tool = Tool::find($id);

        if ($tool) {
            $tool->delete();
            return response()->json(['message' => 'Tool deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Tool not found'], 404);
        }
    }
}
