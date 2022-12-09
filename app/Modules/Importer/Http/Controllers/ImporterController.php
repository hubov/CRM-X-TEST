<?php

namespace App\Modules\Importer\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Importer\Repositories\ImporterRepository;
use Illuminate\Config\Repository as Config;
use App\Modules\Importer\Http\Requests\ImporterRequest;
use Illuminate\Http\Response;
use App;

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
        $this->middleware('auth');
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
        $this->checkPermissions(['importer.index']);
        $onPage = $config->get('system_settings.importer_pagination');
        $list = $this->importerRepository->paginate($onPage);

        return response()->json($list);
    }

    /**
     * Display the specified Importer
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $this->checkPermissions(['importer.show']);
        $id = (int) $id;

        return response()->json($this->importerRepository->show($id));
    }

    /**
     * Return module configuration for store action
     *
     * @return Response
     */
    public function create()
    {
        $this->checkPermissions(['importer.store']);
        $rules['fields'] = $this->importerRepository->getRequestRules();

        return response()->json($rules);
    }

    /**
     * Store a newly created Importer in storage.
     *
     * @param ImporterRequest $request
     *
     * @return Response
     */
    public function store(ImporterRequest $request)
    {
        $this->checkPermissions(['importer.store']);
        $model = $this->importerRepository->create($request->all());

        return response()->json(['item' => $model], 201);
    }

    /**
     * Display Importer and module configuration for update action
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $this->checkPermissions(['importer.update']);
        $id = (int) $id;

        return response()->json($this->importerRepository->show($id, true));
    }

    /**
     * Update the specified Importer in storage.
     *
     * @param ImporterRequest $request
     * @param  int $id
     *
     * @return Response
     */
    public function update(ImporterRequest $request, $id)
    {
        $this->checkPermissions(['importer.update']);
        $id = (int) $id;

        $record = $this->importerRepository->updateWithIdAndInput($id,
            $request->all());

        return response()->json(['item' => $record]);
    }

    /**
     * Remove the specified Importer from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $this->checkPermissions(['importer.destroy']);
        App::abort(404);
        exit;

        /* $id = (int) $id;
        $this->importerRepository->destroy($id); */
    }
}
