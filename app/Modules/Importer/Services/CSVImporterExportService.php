<?php

namespace App\Modules\Importer\Services;

use App\Modules\Importer\Models\Importer;
use App\Modules\WorkOrder\Models\WorkOrder;
use Illuminate\Container\Container;
use Symfony\Component\DomCrawler\Crawler;

class CSVImporterExportService implements ImporterExportServiceContract
{
    /**
     * Initialize class parameters
     *
     * @param Container $app
     */

    public function __construct(Container $app)
    {
        $this->app = $app;
    }

    public function generate($data, $path)
    {
        $file = fopen(storage_path('app/public/'.$path), 'a+');

        foreach ($data as $row) {
            fputcsv($file, $row);
        }

        fclose($file);
    }
}