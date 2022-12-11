<?php

namespace App\Modules\Importer\Exceptions;

use Exception;

class ImporterNoOrdersFoundException extends Exception
{
    public function errorMessage() : string
    {
        return 'No orders found in the file provided.';
    }
}