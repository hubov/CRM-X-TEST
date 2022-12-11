<?php

namespace App\Modules\Importer\Services;

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
}