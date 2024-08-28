<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'property_id' => 'required',
            'room_id' => [
                'required',
                Rule::unique('rents')->where(function ($query) {
                    return $query->where('room_id', $this->room_id); // or $this->house_id
                }),
            ],
            'amount' => 'required|numeric',
            'deposit' => 'required|numeric',
            'rent_date'=>'required|date'
            // 'year' => 'required|integer|digits:4', // Ensures year is exactly 4 digits
            // 'month' => 'required|integer|between:1,12',
        ];
    }

    public function messages()
    {
        return [
            'room_id.unique' => 'Please choose a different room or update the existing rent.',
        ];
    }
    
}
