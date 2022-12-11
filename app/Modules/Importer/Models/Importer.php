<?php

namespace App\Modules\Importer\Models;

use App\Core\LogModel;

class Importer extends LogModel
{
    protected $table = 'importer_log';
    protected $primaryKey  = 'id';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'modified_at';

    protected $fillable = [
        'type',
        'run_at',
        'entries_processed',
        'entries_created'
    ];

    public function __construct(array $attributes = [])
    {
        if (!isset($attributes['run_at'])) {
            $attributes['run_at'] = (new \DateTime('now'))->format('Y-m-d H:i:s');
        }
        if (!isset($attributes['entries_processed'])) {
            $attributes['entries_processed'] = 0;
        }
        if (!isset($attributes['entries_created'])) {
            $attributes['entries_created'] = 0;
        }

        parent::__construct($attributes);
    }
    // relationships

    // scopes

    // getters
}