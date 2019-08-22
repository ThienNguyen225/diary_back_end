<?php

namespace App\Http\Controllers;

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

    public function store(Request $request)
    {
        try {
            $newRequest = $this->bcryptPassword($request->all());
            $data = $this->userService->create($newRequest);
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


    public function update(Request $request, $id)
    {
        try {
            $newRequest = $this->bcryptPassword($request->all());
            $data = $this->userService->update($newRequest, $id);
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

    public function bcryptPassword($request)
    {
        foreach ($request as $key => $value) {
            if ($key === "password") {
                $request["$key"] = Hash::make("$value");
                break;
            }
        }
        return $request;
    }
}
