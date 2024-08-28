<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoomRequest extends FormRequest
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
            //
            'property_id' =>'required',
            'room_code' => [
                'required',
                Rule::unique('rooms')->where(function ($query) {
                    return $query->where('property_id', $this->property_id); // or $this->house_id
                }),
            ]
            
        ];
    }
}
