<?php

namespace App\Repository\Eloquent;

use App\Models\QrGenerator;
use App\Repository\QrRepositoryInterface;
use http\Params;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class QrRepository extends BaseRepository implements QrRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(QrGenerator $model)
    {
        $this->model = $model;
    }

    public function all(array $columns = ['*'], array $relations = []): Collection
    {
        return parent::all();
    }

    public function create(array $payload): ?Model
    {
        return parent::create($payload);
    }




}
