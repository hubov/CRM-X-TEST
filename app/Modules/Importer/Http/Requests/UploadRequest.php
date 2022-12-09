<?php

namespace App\Modules\Importer\Http\Requests;

use App\Http\Requests\Request;

class UploadRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'workorders' => 'required|file|mimetypes:text/html|max:2048'
        ];
    }
}