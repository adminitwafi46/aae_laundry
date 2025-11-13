<?php

namespace Modules\Core\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Contracts\RepositoryInterface;
use Modules\Core\Contracts\ServiceInterface;

abstract class BaseService implements ServiceInterface
{
    protected RepositoryInterface $repository;

    /**
     * BaseService constructor
     */
    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get all records
     */
    public function getAll(): Collection
    {
        return $this->repository->all();
    }

    /**
     * Get a single record
     */
    public function getById(int $id): ?Model
    {
        return $this->repository->find($id);
    }

    /**
     * Create a new record
     */
    public function create(array $data): Model
    {
        return $this->repository->create($data);
    }

    /**
     * Update a record
     */
    public function update(int $id, array $data): Model
    {
        $updated = $this->repository->update($id, $data);

        if (!$updated) {
            throw new \Exception('Record not found or update failed');
        }

        return $this->repository->find($id);
    }

    /**
     * Delete a record
     */
    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }
}
