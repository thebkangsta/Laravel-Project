<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;

class GetDataRequest extends Request
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
            'chartselector' => 'required|in:views,subscribers,videos,earnings,total_views,total_subscribers,total_videos,total_earnings',
            'dateselector' => 'required|in:last30,last90,lastmonth,lifetime,customrange',
            'start' => 'required|date',
            'end' => 'required|date',
        ];
    }
}
