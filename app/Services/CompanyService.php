<?php

namespace App\Services;

class CompanyService
{
    protected $url;
    protected $token;

    public function __construct()
    {
        $this->url   = config('services.micro_02.url');
        $this->token = config('services.micro_02.token');
    }
}