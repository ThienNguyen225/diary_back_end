<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUser;
use App\Http\Requests\UpdateUser;
use App\Services\Contracts\UserServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserApiController extends Controller
{
    protected $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        try {
            $data = $this->userService->getAll();
            return response()->json([
                'data' => $data,
                'status' => 200
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function store(StoreUser $request)
    {
        try {
            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            $data = $this->userService->create($input);
            return response()->json([
                'data' => $data['result'],
                'status' => $data['status']
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }


    public function update(UpdateUser $request, $id)
    {
        try {
            $input = $request->all();
            $data = $this->userService->update($input, $id);
            return response()->json([
                'data' => $data['result'],
                'status' => $data['status']
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function show($id)
    {
        try {
            $data = $this->userService->getById($id);
            return response()->json([
                'data' => $data['result'],
                'status' => $data['status']
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            $data = $this->userService->delete($id);
            if ($data) {
                return response()->json([
                    'data' => $data
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

}
