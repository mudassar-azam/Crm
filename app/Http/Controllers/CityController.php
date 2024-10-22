<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    public function store(Request $request)
    {
        $town = Country::find($request->country_id);
        if ($town) {


            $validator = Validator::make($request->all(), [
                'country_id' => 'required',
                'name' => 'required|unique:cities|max:255',

            ], [
                'name.required' =>  __('validation_messages.town.name'),
                'country_id.required' => __('validation_messages.town.country_id'),
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first(),
                ]);
            }

            $city = City::create([
                'name' => $request->input('name'),
                'country_id' => $request->input('country_id')
            ]);

            return response()->json([
                'success' => true,
                'message' =>  __('validation_messages.town.created_success'),

            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' =>  __('validation_messages.town.not_found'),

            ]);
        }
    }
    public function update(Request $request, $id)
    {
        $city = City::find($id);
        if ($city) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'country_id' => 'required|exists:countries,id',
            ], [
                'name.required' => 'Name is required.',
                'country_id.required' => 'Country ID is required.',
                'country_id.exists' => 'Invalid country ID.',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first(),
                ]);
            }

            $city->update([
                'name' => $request->input('name'),
                'country_id' => $request->input('country_id'),
            ]);

            return response()->json([
                'success' => true,
                'message' =>  __('validation_messages.town.updated_success'),
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Town not found.',
            ]);
        }
    }
}
