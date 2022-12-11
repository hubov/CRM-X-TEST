<?php

namespace App\Modules\Importer\Jobs;

use App\Modules\Importer\Models\Importer;
use App\Modules\Importer\Services\WorkOrdersParserServiceContract;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ParseWorkOrders implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $importer;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Importer $importer)
    {
        $this->importer = $importer;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(WorkOrdersParserServiceContract $parser)
    {
        $parser->setImporter($this->importer);

        $parser->parse(Storage::get('workorders/'.$this->importer->id.'.html'))->storeWorkOrders();
    }
}