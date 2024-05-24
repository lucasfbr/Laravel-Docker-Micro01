<?php

namespace App\Services;

use App\Services\Traits\ConsumerExternalService;

class EvaluationService
{
    use ConsumerExternalService;

    protected $url;
    protected $token;

    public function __construct()
    {
        $this->url   = config('services.micro_02.url');
        $this->token = config('services.micro_02.token');
    }

    public function getEvaluationCompany(string $company)
    { 
        $response = $this->request('get', "/evaluations/$company");

        return $response->body();
    }
}