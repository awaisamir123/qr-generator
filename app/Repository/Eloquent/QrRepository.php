<?php

namespace App\Repository\Eloquent;

use App\Models\QrGenerator;
use App\Repository\QrRepositoryInterface;
use \SimpleSoftwareIO\QrCode\Facades\QrCode;
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
        $qrName = \Helper::characterGenerator(2).time().\Helper::characterGenerator(3);

        list($bgR, $bgG, $bgB) = sscanf(isset($payload['bg_color'])?$payload['bg_color']:"#000000", '#%02x%02x%02x');
        list($fillR, $fillG, $fillB) = sscanf(isset($payload['fill_color'])?$payload['fill_color']:"#ffffff", '#%02x%02x%02x');
        QrCode::size($payload['size'])
            ->backgroundColor($bgR, $bgG, $bgB)
            ->color($fillR, $fillG, $fillB)
            ->generate($payload['qr_content'], public_path("qr-codes-svg/$qrName.svg"));

        $payload['bg_color'] = "$bgR, $bgG, $bgB";
        $payload['fill_color'] = "$fillR, $fillG, $fillB";
        $payload['svg_url'] = asset('qr-codes-svg/'.$qrName.'.svg');

        return parent::create($payload);
    }




}
