<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Authentication\Domain\Token;
use App\Exceptions\RequestInputException;
use App\Exceptions\RequestUnauthorizedException;
use Illuminate\Foundation\Http\FormRequest as IlluminateFormRequest;
use MyParcelCom\Integration\ShopId;
use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Ramsey\Uuid\Uuid;

class FormRequest extends IlluminateFormRequest
{

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
        return [];
    }

    public function shopId(): ShopId
    {
        $shopId = $this->query('shop_id');

        if (!$shopId) {
            throw new RequestInputException('Bad request', 'No shop_id provided in the request query');
        }

        try {
            $shopUuid = Uuid::fromString($shopId);
        } catch (InvalidUuidStringException) {
            throw new RequestInputException('Unprocessable entity', 'shop_id is not a valid UUID', 422);
        }

        return new ShopId($shopUuid);
    }

    public function token(): Token
    {
        $shopId = $this->shopId();
        $token = Token::findByShopId($shopId);

        if (!$token) {
            throw new RequestUnauthorizedException(
                'Unauthorized',
                "No access token found for shop ${shopId}. Is shop authenticated?"
            );
        }

        return $token;
    }
}
