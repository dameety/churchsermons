<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Cartalyst\Stripe\Stripe;
use App\Http\Controllers\Controller;
use App\Http\Requests\SettingValidationRequest;
use App\Repositories\Setting\SettingRepository;

class AdminSettingsApiController extends Controller
{

    protected $setting;

    public function __construct(SettingRepository $setting)
    {
        $this->setting = $setting;
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

    public function nameAndEmail()
    {
        return $this->setting->getNameAndEmail();
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
        $stripe = new Stripe($setting->api_key);
        $plan = $stripe->plans()->create([
            'id'                   => $request->plan_id,
            'name'                 => $request->plan_name,
            'amount'               => $request->plan_amount,
            'currency'             => $request->plan_currency,
            'interval'             => $request->plan_interval,
            'statement_descriptor' => $request->plan_description,
        ]);
        return response()->json(['status', 200]);
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
