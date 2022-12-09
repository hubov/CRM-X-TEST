<?php

namespace App\Modules\Importer\Services;

use App\Modules\Importer\Repositories\ImporterRepository;
use App\Modules\WorkOrder\Models\WorkOrder;
use Illuminate\Container\Container;
use Symfony\Component\DomCrawler\Crawler;

class WorkOrdersParserService
{
    /**
     * @var Container
     */
    protected $app;

    /**
     * @var ImporterRepository
     */
    protected $importer;

    /**
     * Initialize class parameters
     *
     * @param Container $app
     * @param ImporterRepository $importer
     */
    public function __construct(Container $app, ImporterRepository $importer)
    {
        $this->app = $app;
        $this->importer = $importer;
    }

    public function parse($file)
    {
        $crawler = new Crawler($file);
        $rows = $crawler->filter('tr');
$rowsCount = 0;
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                $row = new Crawler($row);
                if ((($row->attr('class') == 'rgRow') || ($row->attr('class') == 'rgAltRow')) && ($row->children()->count() > 0)) {
                    if (!WorkOrder::where('work_order_number', $row->children()->first()->text())->exists()) {
//                        $workOrder = new WorkOrder();
                        dump([
                            'work_order_number' => $this->getOrderNumber($row),
                            'external_id' => $this->getExternalId($row),
                            'priority' => $this->getPriority($row),
                            'received_date' => $this->getReceivedDate($row),
                            'category' => $this->getCategory($row),
                            'fin_loc' => $this->getStoreName($row)
                            ]);
                    } else {
                        dd('JUZ JEST');
                    }
                    $rowsCount++;
                }
            }
        }
        dd($rowsCount);
    }

    protected function getOrderNumber($node)
    {
        try {
            $result = $node->children()->first()->text();
        }  catch (\Throwable $exception) {
            $result = '';
        }

        return $result;
    }

    protected function getExternalId($node)
    {
        try {
            $child = $node->filter('a');
            $result = explode("#", explode("&", explode("entityid=", $child->extract(['href'])[0])[1])[0])[0];
        }  catch (\Throwable $exception) {
            $result = '';
        }

        return $result;
    }

    protected function getPriority($node)
    {
        try {
            switch ($node->children()->count()) {
                case 10: { $result = NULL; break; }
                case 14: { $result = $node->children()->eq(3)->text(); break; }
            }


        }  catch (\Throwable $exception) {
            $result = '';
        }

        return $result;
    }

    protected function getReceivedDate($node)
    {
        try {
            switch ($node->children()->count()) {
                case 10: { $column = 1; break; }
                case 14: { $column = 4; break; }
            }

            $result = $node->children()->eq($column)->text();
        }  catch (\Throwable $exception) {
            $result = '';
        }

        return $result;
    }

    protected function getCategory($node)
    {
        try {
            switch ($node->children()->count()) {
                case 10: { $column = 5; break; }
                case 14: { $column = 8; break; }
            }

            $result = $node->children()->eq($column)->text();
        }  catch (\Throwable $exception) {
            $result = '';
        }
        return $result;
    }

    protected function getStoreName($node)
    {
        try {
            switch ($node->children()->count()) {
                case 10: { $column = 7; break; }
                case 14: { $column = 10; break; }
            }

            $result = $node->children()->eq($column)->text();
        }  catch (\Throwable $exception) {
            $result = '';
        }

        return $result;
    }

    protected function formatDate($date)
    {
        return (new \DateTime($date))->format('Y-m-d H:i:s');
    }
}