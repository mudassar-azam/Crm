<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateResourceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
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
            'contact_no' => 'required|string|max:15',
            'group_link' => 'nullable|url',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('resources')->ignore($this->resource),
            ],
            'region' => 'nullable|string|max:255',
            'nationality' => 'nullable|string|max:255',
            'language' => 'nullable|string|max:255',
            'proficiency_level' => 'nullable|string|max:255',
            'whatsapp_link' => 'nullable|url',
            'certification' => 'nullable|string|max:255',
            'worked_with_us' => 'required|boolean',
            'whatsapp' => 'nullable|string|max:15',
            'linked_in' => 'nullable|url',
            'tools_catagory' => 'nullable|string|max:255',
            'tool_id' => 'nullable|exists:tools,id',
            'BGV' => 'required|boolean',
            'personal_details' => 'nullable|string',
            'right_to_work' => 'required|boolean',
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
