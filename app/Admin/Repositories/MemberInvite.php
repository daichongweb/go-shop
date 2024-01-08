<?php

namespace App\Admin\Repositories;

use App\Models\MemberInvite as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class MemberInvite extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
