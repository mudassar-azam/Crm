<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Note;

class NoteController extends Controller
{
    public function store(Request $request)
    {
        $rules = [
            'note' => 'required|string',
        ];
        
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errors = [];
            foreach ($validator->errors()->getMessages() as $field => $messages) {
                $errors[] = [
                    'field' => $field,
                    'message' => $messages[0]
                ];
            }
            return response()->json(['success' => false, 'errors' => $errors], 422);
        }

        $data = $request->all();
        $data['status'] = 'active';
        $data['user_id'] = Auth::user()->id;
        $note = Note::create($data);

        return response()->json(['success' => true, 'message' => 'Note created successfully!' , 'note' => $note]);
    }
    public function update(Request $request)
    {
        $rules = [
            'note' => 'required|string',
        ];
        
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errors = [];
            foreach ($validator->errors()->getMessages() as $field => $messages) {
                $errors[] = [
                    'field' => $field,
                    'message' => $messages[0]
                ];
            }
            return response()->json(['success' => false, 'errors' => $errors], 422);
        }
        $note = Note::find($request->input('noteId'));
        $note->update($request->all());
        $updatedNote = $note->fresh();

        return response()->json(['success' => true, 'message' => 'Note created successfully!' , 'note' => $updatedNote , 'noteId' => $request->input('noteId')]);
    }
    public function destroy($id)
    {
        $note = Note::findOrFail($id);
        $note->delete();
        return response()->json(['message' => 'Note deleted successfully']);
    }
}
