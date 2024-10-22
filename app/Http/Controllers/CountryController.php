<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CountryController extends Controller
{
    public function store(Request $request)
    {
        // App::setLocale($lang);

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:countries|max:255',
        ], [
            'name.required' => __('validation.country.name_required'),
            'name.unique' => __('validation.country.name_unique'),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ]);
        }

        $country = Country::create([
            'name' => $request->input('name'),
        ]);

        return response()->json([
            'success' => true,
            'message' => __('validation.country.created_success')

        ]);
    }


    public function update(Request $request, $id)
    {
        $country = Country::find($id);
        if ($country) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
            ], [
                'name.required' => 'Name is required.',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first(),
                ]);
            }



            $country->update([
                'name' => $request->input('name'),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'updated successfully',

            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'not found',

            ]);
        }
    }

    public function destroy(Request $request)
    {
        $country = Country::find($request->id);

        if ($country->cities()->exists()) {
            return response()->json([
                'success' => false,
                'message' => __('Country cannot be deleted because it is connected to the City')
            ], 404);
        }
        if ($country) {
            $country->delete();
            return response()->json([
                'success' => true,
                'message' => 'deleted successfully',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'not found',
            ]);
        }
    }
}
