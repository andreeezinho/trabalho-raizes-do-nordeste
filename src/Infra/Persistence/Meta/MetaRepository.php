<?php

namespace App\Infra\Persistence\Meta;

use App\Domain\Models\Meta\Meta;
use App\Domain\Repositories\Meta\MetaRepositoryInterface;
use App\Infra\Persistence\BaseRepository;

class MetaRepository extends BaseRepository implements MetaRepositoryInterface {

    public static $className = Meta::class;

    public function __construct() {
        parent::__construct();
        $this->model = new Meta();
    }

}