<?php

namespace App\Admin\Repositories;

use App\Models\VipApply as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class VipApply extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
