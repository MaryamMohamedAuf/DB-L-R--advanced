<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

use App\Http\Requests\ApplicantRequest;

use App\Http\Requests\FilterApplicantRequest;
use App\Services\ApplicantService;

class ApplicantController extends Controller
{
    protected $applicantService;

    /**
     * Create a new controller instance.
     */
    public function __construct(ApplicantService $applicantService)
    {
        $this->applicantService = $applicantService;
    }
           // $applicants = $this->applicantService->filterApplicants($validatedFilters['filters'] ?? [], $searchTerm);

    public function filter(FilterApplicantRequest $request)
    {
        // Get validated data from the request
        $validatedFilters = $request->validated();
        $searchTerm = $validatedFilters['search'] ?? null;

        // Use the validated data to filter applicants
        $applicants = $this->applicantService->filterApplicants($validatedFilters, $searchTerm);

        // Return the filtered applicants as JSON
        return response()->json($applicants);
    }
    public function getFilterOptions(FilterApplicantRequest $request)
    {
        $filterOptions = $this->applicantService->getFilterOptions();
        // Return the filtered applicants as JSON
        return response()->json(['original' => $filterOptions]);
    }

    
    /**
     * Display a listing of the applicants.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
{
    $applicant = $this->applicantService->getAllApplicants();
    return response()->json($applicant);
}

    

    /**
     * Store a newly created applicant in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ApplicantRequest $request)
    {
        $applicant = $this->applicantService->createApplicant($request->validated());

        return response()->json([
            'message' => 'Applicant created successfully',
            'applicant' => $applicant,
        ], 201);
    }

    /**
     * Display the specified applicant.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        $applicant = $this->applicantService->getApplicantById($id);

        return response()->json($applicant);
    }

    /**
     * Update the specified applicant in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ApplicantRequest $request, int $id)
    {
        $applicant = $this->applicantService->updateApplicant($id, $request->validated());

        return response()->json([
            'message' => 'Applicant updated successfully',
            'applicant' => $applicant,
        ], 200);
    }

    /**
     * Remove the specified applicant from storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        $this->applicantService->deleteApplicant($id);

        return response()->json([
            'message' => 'Applicant deleted successfully',
        ], 200);
    }
}
