<?php

namespace App\Modules\Importer\Services;

use App\Modules\Importer\Models\Importer;

/**
 * Class WorkOrderDataServiceContract
 *
 * Get necessary data for WorkOrder module (used in selects or displaying colour
 * boxes)
 *
 * @package App\Modules\WorkOrder\Services
 */
interface ImporterExportServiceContract
{
    /**
     * Generate export file
     *
     * @return mixed
     */
    public function generate($data, $path);
}