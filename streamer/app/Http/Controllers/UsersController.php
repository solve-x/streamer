<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\ViewModels\UserViewModel;

class UsersController extends Controller
{
    /**
     * @var UserService
     */
    private $userService = null;

    /**
     * UsersController constructor.
     */
    public function __construct(UserService $userService)
    {
        $this->middleware('auth');
        $this->userService = $userService;
    }

    /**
     * Return all users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->userService->getAllUsers();
        return view('users/index', ['model' => $users]);
    }
}