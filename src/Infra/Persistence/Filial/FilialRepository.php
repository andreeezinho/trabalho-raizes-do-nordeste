<?php

namespace App\Infra\Persistence\Filial;

use App\Domain\Models\Filial\Filial;
use App\Domain\Repositories\Filial\FilialRepositoryInterface;
use App\Infra\Persistence\BaseRepository;

class FilialRepository extends BaseRepository implements FilialRepositoryInterface {

    public static $className = Filial::class;

    public function __construct() {
        parent::__construct();
        $this->model = new Filial();
    }

}