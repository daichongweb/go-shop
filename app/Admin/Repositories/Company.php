<?php

namespace App\Admin\Repositories;

use App\Models\Company as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Company extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;

    public static function statusMap(): array
    {
        return [
            0 => '待审核',
            1 => '已审核',
            -1 => '已驳回',
            -2 => '已下线'
        ];
    }

    public static function getStatus($status): string
    {
        return self::statusMap()[$status];
    }
}
