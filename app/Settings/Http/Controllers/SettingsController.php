<?php

declare(strict_types=1);

namespace App\Settings\Http\Controllers;

use App\Http\Requests\FormRequest;
use App\Settings\Http\Requests\SettingsRequest;
use Illuminate\Http\Response;

class SettingsController
{
    public function create(SettingsRequest $request): Response
    {
        $shopId = $request->shopId();

        // TODO: Save the posted settings for this shop in the database. We will need them to query the webshop API.

        return new Response('', Response::HTTP_NO_CONTENT);
    }

    public function delete(FormRequest $request): Response
    {
        $shopId = $request->shopId();

        // TODO: Remove any saved settings for this shop from the database.

        return new Response('', Response::HTTP_NO_CONTENT);
    }
}
