<?php
namespace App\Admin\Controls;

use App\Admin\Services\TableService;
use Illuminate\Support\Facades\DB;

class DatetimeControl extends Control
{
    protected const TYPE_NAME = 'datetime';

    protected mixed $dataType = 'varchar';

    protected function init()
    {
        $this->isNull = ($this->isNull != 1) ? 'NULL' : 'NOT NULL';
        $this->default = $this->default ? "DEFAULT {$this->default}" : '';
        $this->length = 30;
    }
}
