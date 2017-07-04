<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Cartalyst\Stripe\Stripe;
use App\Services\StripeService;
use App\Http\Controllers\Controller;
use App\Repositories\Setting\SettingRepository;
use App\Http\Requests\SettingValidationRequest;

class AdminSettingsApiController extends Controller
{
    protected $setting;
    protected $stripeService;

    public function __construct(SettingRepository $setting, Stripe $stripeService)
    {
        $this->setting = $setting;
        $this->stripeService = $stripeService;
    }

    public function index()
    {
        return $this->setting->getAll();
    }

    public function appLogo(SettingValidationRequest $request)
    {
        $data = Input::all();
        if ($this->setting->validate($data, 'churchLogo')) {
            return response('success', 200);
        } else {
            return response($setting->getErrors(), 422);
        }
    }

    /**
     * Get the app name, email, and stripe key
     * to display in the settings page.
     */
    public function details()
    {
        return $this->setting->getDetails();
    }

    public function updateWelcomeEmail($slug, SettingValidationRequest $request)
    {
        return $this->setting->emailContent($slug, $request);
    }

    public function saveStripeKey(SettingValidationRequest $request)
    {
        return $this->setting->stripeKey($request);
    }

    public function getStripeKey()
    {
        return $this->setting->getStripeKey();
    }

    public function saveStripePlan($slug, SettingValidationRequest $request)
    {
        $this->setting->stripePlan($slug, $request);
        $this->stripeService->createPlan($request);

        return response()->json(['created', true]);
    }

    public function saveContactEmail(SettingValidationRequest $request)
    {
        return $this->setting->contactEmail($request);
    }

    public function saveChurchName(SettingValidationRequest $request)
    {
        return $this->setting->churchName($request);
    }

    public function sliderImageUpload(Request $request)
    {
        if ($this->setting->sliderIsLessThan5()) {
            return $this->setting->bannerUpload($request);
        } else {
            return response('The slider can take only 5 images', 422);
        }
    }

    public function deleteSliderImage(Request $request)
    {
        return $this->setting->delete($request);
    }

    public function getSliderImages()
    {
        return $this->setting->sliderImages();
    }
}
