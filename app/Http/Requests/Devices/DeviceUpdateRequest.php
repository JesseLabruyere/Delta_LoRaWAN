<?php

namespace App\Http\Requests\Devices;

use App\Http\Requests\Request;

class DeviceUpdateRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
        ];
    }
}