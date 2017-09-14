<?php

namespace App\Repositories;

use DB;

abstract class BaseRepository
{
    /**
     * @var string
     */
    protected $tableName;

    /**
     * @var \Illuminate\Database\Query\Builder
     */
    protected $table;

    public function __construct()
    {
        $this->table = DB::table($this->tableName);
    }
}
