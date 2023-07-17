<?php

declare(strict_types=1);

namespace App\Settings\Http\Requests;

use App\Http\Requests\FormRequest;

class SettingsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'data.settings' => 'array',
        ];
    }
}
