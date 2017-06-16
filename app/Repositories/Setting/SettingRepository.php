<?php

namespace App\Repositories\Setting;

interface SettingRepository
{
    public function getAll();

    public function getBySlug($slug);

    public function updateEmailContent($request);

    public function stripePlan($request);

    public function stripeKey($request);

    public function contactEmail($request);

    public function churchName($request);

    public function bannerUpload($request);
}
