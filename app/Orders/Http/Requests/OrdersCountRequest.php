<?php

declare(strict_types=1);

namespace App\Orders\Http\Requests;

use App\Http\Requests\FormRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class OrdersCountRequest extends FormRequest
{
    public function dateFrom(): Carbon
    {
        $from = $this->query('date_from');
        if (!$from) {
            return Carbon::now()->subDay();
        }

        $this->validateDateFormat($from);

        return Carbon::createFromFormat('Y-m-d', $from);
    }

    public function dateTo(): Carbon
    {
        $to = $this->query('date_to');
        if (!$to) {
            return Carbon::now();
        }

        $this->validateDateFormat($to);

        return Carbon::createFromFormat('Y-m-d', $to);
    }

    private function validateDateFormat(string $date): void
    {
        Validator::validate(
            ['date' => $date],
            ['date' => 'date_format:Y-m-d'],
        );
    }
}
