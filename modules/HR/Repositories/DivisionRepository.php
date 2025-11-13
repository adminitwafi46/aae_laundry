<?php

namespace Modules\HR\Repositories;

use Modules\Core\Repositories\BaseRepository;
use Modules\HR\Models\Division;

class DivisionRepository extends BaseRepository
{
    /**
     * DivisionRepository constructor
     */
    public function __construct(Division $model)
    {
        parent::__construct($model);
    }

    /**
     * Find division by code
     */
    public function findByCode(string $code): ?Division
    {
        return $this->model->where('code', $code)->first();
    }

    /**
     * Get active divisions only
     */
    public function getActive(): mixed
    {
        return $this->model->where('is_active', true)->get();
    }
}
