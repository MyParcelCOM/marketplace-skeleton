<?php

declare(strict_types=1);

namespace App\Authentication\Http\Requests;

use App\Rules\UuidRule;
use Illuminate\Foundation\Http\FormRequest;
use MyParcelCom\Integration\ShopId;
use Ramsey\Uuid\Uuid;

class InitAuthRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'data.shop_id'      => ['required', 'string', new UuidRule()],
            'data.redirect_uri' => ['required', 'string'],
        ];
    }

    public function shopId(): ShopId
    {
        return new ShopId(Uuid::fromString($this->input('data.shop_id')));
    }

    public function redirectUri(): string
    {
        return $this->input('data.redirect_uri');
    }
}
