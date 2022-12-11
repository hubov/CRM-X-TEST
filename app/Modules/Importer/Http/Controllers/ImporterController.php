<?php

namespace App\Modules\Importer\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Importer\Http\Requests\UploadRequest;
use App\Modules\Importer\Models\Importer;
use App\Modules\Importer\Repositories\ImporterRepository;
use App\Modules\Importer\Services\WorkOrdersParserServiceContract;
use Illuminate\Config\Repository as Config;
use App\Modules\Importer\Http\Requests\ImporterRequest;
use Illuminate\Http\Response;
use App;
use Illuminate\Support\Facades\Storage;

/**
 * Class ImporterController
 *
 * @package App\Modules\Importer\Http\Controllers
 */
class ImporterController extends Controller
{
    /**
     * Importer repository
     *
     * @var ImporterRepository
     */
    private $importerRepository;

    /**
     * Set repository and apply auth filter
     *
     * @param ImporterRepository $importerRepository
     */
    public function __construct(ImporterRepository $importerRepository)
    {
        $this->importerRepository = $importerRepository;
    }

    /**
     * Return list of Importer
     *
     * @param Config $config
     *
     * @return Response
     */
    public function index(Config $config)
    {
        $list = $this->importerRepository->getAll();
//        $onPage = $config->get('system_settings.importer_pagination');
//        $list = $this->importerRepository->paginate($onPage);

        return view('Importer.index', ['list' => $list]);
    }

    public function uploadFile(UploadRequest $request, WorkOrdersParserServiceContract $parser)
    {
        $importer = new Importer();
        $importer->type = 0;
        $importer->saveQuietly();

        Storage::disk('local')->put('workorders/' . $importer->id . '.html', file_get_contents($request->file('workorders')));

        $fileName = $importer->id . '.html';

        $parser->setImporter($importer);
        $filePath = $parser->parse(Storage::get('workorders/' . $fileName))->storeWorkOrders();

        $fileName = 'report-' . $importer->id . '.csv';

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        return response()->download(storage_path('app/public/' . $filePath), $fileName, $headers);
    }
}