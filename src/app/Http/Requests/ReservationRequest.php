<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
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
            'reservation_date' => 'required|date|after_or_equal:today',
            'reservation_time' => 'required|date_format:H:i',
            'party_size' => 'required|integer|min:1'
        ];
    }

    public function messages()
    {
        return [
            'reservation_date.required' => '予約日を入力してください',
            'reservation_date.date' => '予約日は日付形式で入力してください',
            'reservation_date.after_or_equal' => '予約日は今日以降の日付を入力してください',
            'reservation_time.required' => '予約時間を入力してください',
            'reservation_time.date_format' => '予約時間は時刻形式で入力してください',
            'party_size.required' => '予約人数を入力してください',
            'party_size.integer' => '予約人数は整数で入力してください',
            'party_size.min' => '予約人数は1以上で入力してください'
        ];
    }
}
