<?php

namespace Modules\Core\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface ServiceInterface
{
    /**
     * Get all records
     */
    public function getAll(): Collection;

    /**
     * Get a single record
     */
    public function getById(int $id): ?Model;

    /**
     * Create a new record
     */
    public function create(array $data): Model;

    /**
     * Update a record
     */
    public function update(int $id, array $data): Model;

    /**
     * Delete a record
     */
    public function delete(int $id): bool;
}
