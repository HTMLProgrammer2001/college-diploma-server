<?php

namespace App\Http\Controllers;


use App\Http\Requests\ImportRequest;
use App\Http\Requests\User\AddUserRequest;
use App\Http\Requests\User\AllUserRequest;
use App\Http\Requests\User\EditUserRequest;
use App\Http\Resources\Users\UserResource;
use App\Http\Resources\Users\UsersGroupResource;
use App\Http\Resources\Users\UsersGroupTableResource;
use App\Imports\UsersImport;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    private $userRep;

    public function __construct(UserRepositoryInterface $userRep)
    {
        $this->userRep = $userRep;
    }

    public function all(AllUserRequest $request)
    {
        $inputData = $request->query();

        $rules = $this->userRep->createRules($inputData);
        $pageSize = $request->query('pageSize', 5);
        $users = $this->userRep->filterPaginate($rules, $pageSize);

        return new UsersGroupTableResource($users);
    }

    public function single(int $id)
    {
        $user = $this->userRep->getById($id);

        if(!$user)
            return abort(404);

        return new UserResource($user);
    }

    public function store(AddUserRequest $request)
    {
        $data = $request->except('datePresentation');
        $data['date_presentation'] = $request->input('datePresentation');
        $this->userRep->create($data);

        return response()->json([
            'message' => 'Created'
        ]);
    }

    public function update(EditUserRequest $request, int $id)
    {
        $data = $request->all();
        $user = $this->userRep->update($id, $data);

        return new UserResource($user);
    }

    public function destroy(int $id)
    {
        if($this->userRep->destroy($id))
            return response()->json(['message' => 'ok']);
        else
            return abort(422);
    }

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
