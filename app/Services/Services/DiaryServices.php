<?php


namespace App\Services\Services;


use App\Repositories\Contracts\DiaryInterface;
use App\Services\Contracts\DiaryServiceInterface;

class DiaryServices extends Service implements DiaryServiceInterface
{
    public function __construct(DiaryInterface $diaryRepository)
    {
        $this->setRepository($diaryRepository);
    }

    public function getDiaryOfUser()
    {
        return $this->repository->getDiaryOfUser();
    }

    public function createDiaryOfUser($request)
    {
        $result = $this->repository->createDiaryOfUser($request);

        $status = 201;
        if (!$result) {
            $status = 500;
        }

        $data = [
            'status' => $status,
            'result' => $result
        ];

        return $data;
    }

    public function updateDiaryOfUser($request, $id)
    {
        $result = $this->repository->getById($id);
        if (!$result) {
            $newResult = null;
            $status = 404;
        } else {
            $newResult = $this->repository->updateDiaryOfUser($request, $result);
            $status = 200;
        }

        $data = [
            'status' => $status,
            'result' => $newResult
        ];
        return $data;
    }
}
