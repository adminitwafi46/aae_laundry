<?php

namespace Modules\HR\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Modules\Core\Http\Controllers\BaseController;
use Modules\HR\Http\Requests\StoreDivisionRequest;
use Modules\HR\Http\Requests\UpdateDivisionRequest;
use Modules\HR\Services\DivisionService;

class DivisionController extends BaseController
{
    protected DivisionService $divisionService;

    /**
     * DivisionController constructor
     */
    public function __construct(DivisionService $divisionService)
    {
        $this->divisionService = $divisionService;
    }

    /**
     * Display a listing of divisions
     */
    public function index(): JsonResponse
    {
        try {
            $divisions = $this->divisionService->getAll();

            return $this->successResponse(
                $divisions,
                'Divisions retrieved successfully'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to retrieve divisions',
                $e->getMessage(),
                500
            );
        }
    }

    /**
     * Store a newly created division
     */
    public function store(StoreDivisionRequest $request): JsonResponse
    {
        try {
            $division = $this->divisionService->create($request->validated());

            return $this->createdResponse(
                $division,
                'Division created successfully'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to create division',
                $e->getMessage(),
                500
            );
        }
    }

    /**
     * Display the specified division
     */
    public function show(int $id): JsonResponse
    {
        try {
            $division = $this->divisionService->getById($id);

            if (!$division) {
                return $this->notFoundResponse('Division not found');
            }

            return $this->successResponse(
                $division,
                'Division retrieved successfully'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to retrieve division',
                $e->getMessage(),
                500
            );
        }
    }

    /**
     * Update the specified division
     */
    public function update(UpdateDivisionRequest $request, int $id): JsonResponse
    {
        try {
            $division = $this->divisionService->update($id, $request->validated());

            return $this->successResponse(
                $division,
                'Division updated successfully'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to update division',
                $e->getMessage(),
                500
            );
        }
    }

    /**
     * Remove the specified division
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $deleted = $this->divisionService->delete($id);

            if (!$deleted) {
                return $this->notFoundResponse('Division not found');
            }

            return $this->deletedResponse('Division deleted successfully');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to delete division',
                $e->getMessage(),
                500
            );
        }
    }

    /**
     * Get active divisions only
     */
    public function active(): JsonResponse
    {
        try {
            $divisions = $this->divisionService->getActiveDivisions();

            return $this->successResponse(
                $divisions,
                'Active divisions retrieved successfully'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to retrieve active divisions',
                $e->getMessage(),
                500
            );
        }
    }
}
