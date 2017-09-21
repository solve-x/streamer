<?php

namespace App\Http\Controllers;

use App\Entities\User;
use App\Services\UserService;
use App\ViewModels\CreateEditUserViewModel;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class UsersController extends Controller
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * UsersController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->middleware('auth');
        $this->userService = $userService;
    }

    /**
     * Return all users.
     *
     * @return View
     */
    public function index(): View
    {
        $users = $this->userService->getAllUsers();
        return view('users/index', ['model' => $users]);
    }

    /**
     * Returns the view for creating a new user or editing an existing one.
     *
     * @param null $id
     * @return View
     */
    public function createEdit($id = null): View
    {
        $user = User::empty();
        if (null !== $id) {
            $user = $this->userService->getUserById($id);
        }

        $userRoles = $this->userService->getAllUserRoles();

        return view('users/createEdit', [
            'model' => $user,
            'userRoles' => $userRoles
        ]);
    }

    /**
     * Creates or updates a user.
     *
     * @param CreateEditUserViewModel $model
     * @return ResponseFactory|RedirectResponse|Response
     * @throws \RuntimeException
     */
    public function postCreateEdit(CreateEditUserViewModel $model)
    {
        if (!$model->isValid()) {
            return response([
                'message' => 'Invalid model!',
                'model' => $model
            ], 400);
        }

        $this->userService->createUpdateUser(
            $model->id,
            $model->name,
            $model->email,
            $model->password,
            $model->userRoles
        );

        return response()->redirectToRoute('users');
    }
}