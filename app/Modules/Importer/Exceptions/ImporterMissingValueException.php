<?php

namespace App\Modules\Importer\Exceptions;

use Exception;

class ImporterMissingValueException extends Exception
{

    /**
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->value = $value;

        parent::__construct();
    }

    public function errorMessage() : string
    {
        return 'Missing value for column: '.$this->value;
    }
}