<?php
namespace App\Admin\Controls;

use App\Admin\Services\TableService;
use Illuminate\Support\Facades\DB;

class ColorControl extends Control
{
    protected const TYPE_NAME = 'color';

    protected mixed $dataType = 'varchar';

    protected function init()
    {
        $this->isNull = ($this->isNull != 1) ? 'NULL' : 'NOT NULL';
        $this->default = $this->default ? "DEFAULT {$this->default}" : '#000000';
        $this->length = 10;
    }
}
