<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Repositories\Service\ServiceRepository;

class ServiceComposer
{

    protected $service;

    public function __construct(ServiceRepository $service)
    {
        $this->service = $service;
    }

    public function compose(View $view)
    {
        $view->with('services', $this->service->getAllOrderByLatest());
    }

    public function filter(View $view)
    {
        // $view->with('services', $this->service->sermonServiceFilters());
    }
}
