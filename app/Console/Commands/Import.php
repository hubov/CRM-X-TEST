<?php

namespace App\Console\Commands;

use App\Modules\Importer\Models\Importer;
use App\Modules\Importer\Services\WorkOrdersParserServiceContract;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class Import extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:workorders {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import work orders from HTML file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(Importer $importer, WorkOrdersParserServiceContract $parser)
    {
        $importer->type = 0;
        $importer->saveQuietly();

        Storage::disk('local')->put('workorders/' . $importer->id . '.html', file_get_contents(base_path() . '/' . $this->argument('file')));

        $fileName = $importer->id . '.html';

        $parser->setImporter($importer);

        $filePath = $parser->parse(Storage::get('workorders/' . $fileName))->storeWorkOrders();

        $this->info('Import successful! Your CSV report is here: storage/public/' . $filePath);
    }
}