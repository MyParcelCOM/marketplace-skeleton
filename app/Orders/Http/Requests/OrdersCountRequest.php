<?php

declare(strict_types=1);

namespace App\Orders\Http\Requests;

use App\Http\Requests\FormRequest;
use Carbon\Carbon;

class OrdersCountRequest extends FormRequest
{
    public function dateFrom(): Carbon
    {
        $from = $this->query('date_from');
        if ($from) {
            return Carbon::createFromFormat('Y-m-d', $from);
        }

        return Carbon::now()->subDay();
    }

    public function dateTo(): Carbon
    {
        $to = $this->query('date_to');
        if ($to) {
            return Carbon::createFromFormat('Y-m-d', $to);
        }

        return Carbon::now();
    }
}
