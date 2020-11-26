<?php

namespace App\Http\Controllers;


use App\Http\Requests\ImportRequest;
use App\Http\Requests\User\AddUserRequest;
use App\Http\Requests\User\AllUserRequest;
use App\Http\Requests\User\EditUserRequest;
use App\Http\Resources\Users\UserResource;
use App\Http\Resources\Users\UsersGroupTableResource;
use App\Imports\UsersImport;

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
    private $userRep;

    /**
     * UserController constructor.
     * @param UserService $userRep
     */
    public function __construct(UserService $userRep)
    {
        $this->userRep = $userRep;
    }

    /**
     * @param AllUserRequest $request
     * @return UsersGroupTableResource
     */
    public function all(AllUserRequest $request)
    {
        $inputData = $request->query();

        $rules = $this->userRep->createRules($inputData);
        $pageSize = $request->query('pageSize', 5);
        $users = $this->userRep->filterPaginate($rules, $pageSize);

        return new UsersGroupTableResource($users);
    }

    /**
     * @param int $id
     * @return UserResource|void
     */
    public function single(int $id)
    {
        $user = $this->userRep->getById($id);

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
        $this->userRep->create($data);

        return response()->json([
            'message' => 'Created'
        ]);
    }

    /**
     * @param EditUserRequest $request
     * @param int $id
     * @return UserResource
     */
    public function update(EditUserRequest $request, int $id)
    {
        Validator::make($request->all(), [
            'email' => [Rule::unique('users', 'email')->ignore($id)]
        ]);

        $data = $request->all();
        $user = $this->userRep->update($id, $data);

        return new UserResource($user);
    }

    /**
     * @param int $id
     * @return JsonResponse|void
     */
    public function destroy(int $id)
    {
        if($this->userRep->destroy($id))
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
