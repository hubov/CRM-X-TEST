<?php

namespace App\Modules\Importer\Exceptions;

use Exception;

class ImporterDateFormatInvalidException extends Exception
{
    public function errorMessage() : string
    {
        return 'Parsed date format is invalid.';
    }
}