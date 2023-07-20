<?php

declare(strict_types=1);

namespace App\Shops\Http\Requests;

use App\Http\Requests\FormRequest;

class ShopRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'data.settings' => 'array',
        ];
    }
}
