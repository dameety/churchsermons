<?php

namespace App\Repositories\Setting;

interface SettingRepository
{
    public function getAll();

    public function getTestimonials();

    public function getBySlug($slug);

    public function emailContent($slug, $request);

    public function stripePlan($slug, $request);

    public function stripeKey($request);

    public function contactEmail($request);

    public function churchName($request);

    public function bannerUpload($request);
}
