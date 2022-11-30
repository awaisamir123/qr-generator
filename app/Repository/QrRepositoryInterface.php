<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface QrRepositoryInterface extends EloquentRepositoryInterface {

    public function all(array $columns = ['*'], array $relations = []): Collection;

    public function create(array $payload): ?Model;
}
