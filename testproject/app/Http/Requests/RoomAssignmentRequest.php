<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class RoomAssignmentRequest extends FormRequest
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
            'user_id' => 'required',
            'room_id' => [
                'required',
                Rule::unique('rooms_assignments')->where(function ($query) {
                    return $query->where('room_id', $this->room_id); // or $this->house_id
                }),
            ],
        ];
    }

    public function messages()
    {
        return [
            'room_id.unique' => 'Room has already been assigned, please choose a different room.',
        ];
    }
}


