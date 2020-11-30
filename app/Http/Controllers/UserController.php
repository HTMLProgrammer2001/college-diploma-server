<?php

namespace App\Http\Controllers;


use App\Http\Requests\ImportRequest;
use App\Http\Requests\User\AddUserRequest;
use App\Http\Requests\User\AllUserRequest;
use App\Http\Requests\User\EditUserRequest;
use App\Http\Resources\Users\UserResource;
use App\Http\Resources\Users\UsersGroupTableResource;
use App\Imports\UsersImport;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * UserController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->authorizeResource(User::class);
    }

    /**
     * @param AllUserRequest $request
     * @return UsersGroupTableResource
     */
    public function index(AllUserRequest $request)
    {
        $inputData = $request->query();

        $rules = $this->userService->createRules($inputData);
        $pageSize = $request->query('pageSize', 5);
        $users = $this->userService->filterPaginate($rules, $pageSize);

        return new UsersGroupTableResource($users);
    }

    /**
     * @param User $user
     * @return UserResource|void
     */
    public function single(User $user)
    {
        if(!$user)
            return abort(404);

        return new UserResource($user);
    }

    /**
     * @param AddUserRequest $request
     * @return JsonResponse
     */
    public function store(AddUserRequest $request)
    {
        $data = $request->all();
        $this->userService->create($data);

        return response()->json([
            'message' => 'Created'
        ]);
    }

    /**
     * @param EditUserRequest $request
     * @param User $user
     * @return UserResource
     */
    public function update(EditUserRequest $request, User $user)
    {
        Validator::make($request->all(), [
            'email' => [Rule::unique('users', 'email')->ignore($user->id)]
        ]);

        $data = $request->all();
        $user = $this->userService->update($user->id, $data);

        return new UserResource($user);
    }

    /**
     * @param User $user
     * @return JsonResponse|void
     */
    public function destroy(User $user)
    {
        if($this->userService->destroy($user->id))
            return response()->json(['message' => 'ok']);
        else
            return abort(422);
    }

    /**
     * @param ImportRequest $request
     * @return JsonResponse
     */
    public function import(ImportRequest $request)
    {
        try {
            //Import models
            Excel::import(new UsersImport(), $request->file('importFile'));
        }
        catch(\Exception $exception){
            return response()->json([
                'message' => 'Error in import'
            ], 422);
        }

        //return success response
        return response()->json(['message' => 'Ok']);
    }
}
