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
     * @var array
     */
    protected $results = [];

    /**
     * @var integer
     */
    protected $parsedOrders;

    /**
     * @vaer integer
     */
    protected $newOrders;

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

        if (count($rows) > 0) {
            foreach ($rows as $row) {
                $row = new Crawler($row);
                if ((($row->attr('class') == 'rgRow') || ($row->attr('class') == 'rgAltRow')) && ($row->children()->count() > 0)) {
                    $this->results[$this->parsedOrders] = [
                        'work_order_number' => $this->getOrderNumber($row),
                        'external_id' => $this->getExternalId($row),
                        'priority' => $this->getPriority($row),
                        'received_date' => $this->formatDate($this->getReceivedDate($row)),
                        'category' => $this->getCategory($row),
                        'fin_loc' => $this->getStoreName($row)
                    ];

                    $this->parsedOrders++;
                }
            }
        }
        dump($this->parsedOrders);

        return $this;
    }

    public function storeWorkOrders()
    {
        dump($this->results);
        if (!empty($this->results)) {
            foreach ($this->results as $result) {
                if (!WorkOrder::where('work_order_number', $result['work_order_number'])->exists()) {
                    $order = new WorkOrder();
                    $order->work_order_number = $result['work_order_number'];
                    $order->external_id = $result['external_id'];
                    $order->priority = $result['priority'];
                    $order->received_date = $result['received_date'];
                    $order->category = $result['category'];
                    $order->fin_loc = $result['fin_loc'];
                    dump($order);
                    $order->saveQuietly();
                    dump('after');

                    dump($this->results[$this->parsedOrders-1]);

                    $this->newOrders++;
                }
            }
        }
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