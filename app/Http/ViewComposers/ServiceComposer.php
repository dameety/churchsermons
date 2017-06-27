<?php

namespace App\Http\ViewComposers;

use App\Repositories\Service\ServiceRepository;
use Illuminate\View\View;

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
