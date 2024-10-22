<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreResourceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        return [
        'name' => 'required|string|max:255',
        'group_link' => 'nullable',
        'email' => 'required|string|email|max:255|unique:users',
        'region' => 'nullable|string|max:255',
        'nationality' => 'nullable|string|max:255',
        'language' => 'nullable|string|max:255',
        'proficiency_level' => 'nullable|string|max:255',
        'whatsapp_link' => 'nullable|url',
        'certification' => 'nullable|string|max:255',
        'worked_with_us' => 'nullable', //boolean /required
        'whatsapp' => 'nullable|string|max:15',
        'linked_in' => 'nullable|url',
        'tools_catagory' => 'nullable|string|max:255',
        'tool_id' => 'nullable|exists:tools,id',
        'BGV' => 'required|boolean',
        'personal_details' => 'nullable|string',
      //  'right_to_work' => 'nullable',  //require /boolean
        'record' => 'required|boolean',
        'last_degree' => 'nullable|string|max:255',
        'country_id' => 'nullable|exists:countries,id',
        'city_id' => 'nullable|exists:cities,id',
        'skill_id' => 'nullable|exists:skills,id',
        'latitude' => 'nullable|numeric',
        'longitude' => 'nullable|numeric',
        'address' => 'nullable|string',
        'work_status' => 'nullable|string|max:255',
        'resume' => 'nullable|url',
        'visa' => 'nullable|string|max:255',
        'license' => 'nullable|string|max:255',
        'passport' => 'nullable|string|max:255',
        'daily_rate' => 'nullable|numeric',
        'hourly_rate' => 'nullable|numeric',
        'rates' => 'nullable|string|max:255',
        'rate_date' => 'nullable|date',
        'rate_currency' => 'nullable|string|max:10',
        'half_day_rates' => 'nullable|numeric',
        'rate_snap' => 'nullable|string',
        'account_payment_details_id' => 'nullable|exists:account_payment_details,id',

        ];
    }
}
