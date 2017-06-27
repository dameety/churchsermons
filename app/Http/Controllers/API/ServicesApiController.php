<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceValidationRequest;
use App\Models\Service;
use App\Repositories\Service\ServiceRepository;

class ServicesApiController extends Controller
{
    protected $service;

    public function __construct(ServiceRepository $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->service->get30Paginated();
    }

    public function all()
    {
        return $this->service->getAllOrderByLatest();
    }

    public function count()
    {
        return $this->service->countAll();
    }

    public function fetchServices()
    {
        return $this->service->getAll();
    }

    public function newServiceData(ServiceValidationRequest $request)
    {
        return $this->service->create($request);
    }

    public function serviceUpdate($slug, ServiceValidationRequest $request)
    {
        return $this->service->update($slug, $request);
    }

    public function sermonServiceFilter(Service $service)
    {
        return $this->service->sermons;
    }

    public function deleteService($slug)
    {
        return $this->service->delete($slug);
    }
}
