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
                    // dd($query->where('room_id', $this->room_id)->where('status','!=', 1)->get());
                    return $query->where('room_id', $this->room_id)->where('user_id', $this->user_id); // or $this->house_id
                }),
            ],
        ];
    }

    public function messages()
    {
        return [
            'room_id.unique' => 'You already submitted a request for this room, please choose a different room.',
        ];
    }
}


