<?php


namespace App\ViewModels;

use SolveX\ViewModel\ViewModel;
use SolveX\ViewModel\Annotations as VM;
use SolveX\ViewModel\Annotations\DataType;

class AddEditStreamViewModel extends ViewModel
{
    /**
     * @VM\DataType(DataType::Int)
     * @var int
     */
    public $id;

    /**
     * @VM\DataType(DataType::String)
     * @VM\Required()
     * @var string
     */
    public $name;

    /**
     * @VM\DataType(DataType::String)
     * @VM\Required()
     * @var string
     */
    public $streamKey;

    /**
     * @VM\DataType(DataType::Int)
     * @VM\Required()
     * @var int
     */
    public $type;
}