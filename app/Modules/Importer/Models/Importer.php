<?php

namespace App\Modules\Importer\Models;

use App\Core\LogModel;

class Importer extends LogModel
{
    protected $table = 'importer_log';
    protected $primaryKey  = 'id';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'modified_at';

    protected $fillable = ['type', 'run_at', 'entries_processed', 'entries_created'];

    // relationships

    // scopes

    // getters
}