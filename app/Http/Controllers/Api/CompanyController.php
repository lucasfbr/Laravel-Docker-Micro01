<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateCompany;
use App\Http\Resources\CompanyResource;
use App\Jobs\CompanyCreated;
use App\Models\Company;
use App\Services\EvaluationService;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    protected $company;
    protected $evaluationService;

    public function __construct(Company $company, EvaluationService $evaluationService)
    {
        $this->company = $company;
        $this->evaluationService = $evaluationService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $companies = $this->company->getCompanies($request->get('filter', ''));

        return CompanyResource::collection($companies);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateCompany $request)
    {
        $company = $this->company->create($request->validated());

        CompanyCreated::dispatch($company->email);

        return new CompanyResource($company);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        $company = $this->company->where('uuid', $uuid)->firstOrFail();
        
        $evaluations = $this->evaluationService->getEvaluationCompany($uuid);

        return (new CompanyResource($company))->additional(['evaluations' => json_decode($evaluations)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  strig  $uuid
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateCompany $request, $uuid)
    {
        $company = $this->company->where('uuid', $uuid)->firstOrFail();

        $company->update($request->validated());

        return response()->json(['Message' => 'Dados atualizados com sucesso']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        $company = $this->company->where('uuid', $uuid)->firstOrFail();

        $company->delete();

        return response()->json(['Message' => 'Dados removidos com sucesso']);
    }
}
