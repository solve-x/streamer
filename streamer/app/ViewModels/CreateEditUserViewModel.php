<?php

namespace App\ViewModels;

use SolveX\ViewModel\ViewModel;
use SolveX\ViewModel\Annotations as VM;
use SolveX\ViewModel\Annotations\DataType;

class CreateEditUserViewModel extends ViewModel
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
    public $email;

    /**
     * @VM\DataType(DataType::String)
     * @var string
     */
    public $password;

    /**
     * @VM\DataType(DataType::String)
     * @var string
     */
    public $repeatPassword;

    /**
     * @VM\DataType(DataType::IntArray)
     * @VM\Required()
     * @var int[]
     */
    public $userRoles;
}