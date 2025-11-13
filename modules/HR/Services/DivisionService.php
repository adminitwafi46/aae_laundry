<?php

namespace Modules\HR\Services;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Services\BaseService;
use Modules\HR\Repositories\DivisionRepository;

class DivisionService extends BaseService
{
    protected DivisionRepository $divisionRepository;

    /**
     * DivisionService constructor
     */
    public function __construct(DivisionRepository $repository)
    {
        parent::__construct($repository);
        $this->divisionRepository = $repository;
    }

    /**
     * Create a new division with validation
     */
    public function create(array $data): Model
    {
        // Check if code already exists
        if ($this->divisionRepository->findByCode($data['code'])) {
            throw new \Exception('Division code already exists');
        }

        return parent::create($data);
    }

    /**
     * Update division with code uniqueness check
     */
    public function update(int $id, array $data): Model
    {
        // Check if code is being changed and if new code exists
        if (isset($data['code'])) {
            $existing = $this->divisionRepository->findByCode($data['code']);
            if ($existing && $existing->id !== $id) {
                throw new \Exception('Division code already exists');
            }
        }

        return parent::update($id, $data);
    }

    /**
     * Get active divisions
     */
    public function getActiveDivisions(): mixed
    {
        return $this->divisionRepository->getActive();
    }
}
