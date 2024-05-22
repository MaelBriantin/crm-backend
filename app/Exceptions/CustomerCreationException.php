<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use App\Models\Brand;

class CustomerCreationException extends Exception
{
    public function __construct(Exception $e)
    {
        if ($e instanceof QueryException) {
            if ($e->getCode() == 23000) {
                if (str_contains($e->getMessage(), 'customers_sector_id_foreign')) {
                    $message = trans('customers.invalid_sector_id');
                }
            } else {
                $message = trans('customers.creation_error');
            }
        } else {
            $message = $e->getMessage();
        }

        parent::__construct($message, $e->getCode(), $e);
    }
}