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
            'property_code'=>'required',
            'room_code' => [
                'required',
                Rule::unique('rooms')->where(function ($query) {
                    return $query->where('property_code', $this->property_code); // or $this->house_id
                }),
            ],
            'amount'=>'required|float',
            'deposit'=>'required|float',
            'year' => 'required|integer|digits:4', // Ensures year is exactly 4 digits
            'month' => 'required|integer|between:1,12',
        ];
    }
}
