<?php

namespace App\Http\Controllers;

use App\Services\Contracts\DiaryServiceInterface;
use Illuminate\Http\Request;

class DiaryApiController extends Controller
{
    protected $diaryService;

    public function __construct(DiaryServiceInterface $diaryService)
    {
        $this->diaryService = $diaryService;
    }

    public function index()
    {
        try {
            $data = $this->diaryService->getAll();
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

    public function getDiaryOfUser()
    {
        try {
            $data = $this->diaryService->getDiaryOfUser();
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
            $input = $request->all();
            $data = $this->diaryService->createDiaryOfUser($input);
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
            $input = $request->all();
            $data = $this->diaryService->updateDiaryOfUser($input, $id);
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
            $data = $this->diaryService->getById($id);
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
            $data = $this->diaryService->delete($id);
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
