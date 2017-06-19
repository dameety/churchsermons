<?php

namespace App\Repositories\Setting;

interface SettingRepository
{
    public function getAll();

    public function getBySlug($slug);

    public function emailContent($slug, $request);

    public function stripePlan($slug, $request);

    public function stripeKey($request);

    public function contactEmail($slug, $request);

    public function churchName($slug, $request);

    public function bannerUpload($request);
}
