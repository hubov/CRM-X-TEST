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
interface WorkOrdersParserServiceContract
{
    /**
     * Execute parser on file given
     *
     * @return WorkOrdersParserServiceContract
     */
    public function parse($file);

    /**
     * Store parsing result and importer log in DB
     *
     * @return void
     */
    public function storeWorkOrders();

    /**
     * Set importer related to parsing job.
     *
     * @return void
     */
    public function setImporter(Importer $importer);
}