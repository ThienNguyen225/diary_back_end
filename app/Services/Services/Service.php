<?php


namespace App\Services\Services;


use App\Services\Contracts\ServiceInterface;

abstract class Service implements ServiceInterface
{
    protected $repository;

    public function setUserRepository($repository)
    {
        $this->repository = $repository;
    }

    public function getAll()
    {
        return $this->repository->getAll();
    }

    public function getById($id)
    {
        $result = $this->repository->getById($id);
        $status = 200;

        if (!$result) {
            $status = 404;
        };

        $data = [
            'status' => $status,
            'result' => $result
        ];

        return $data;
    }

    public function create($request)
    {
        $result = $this->repository->create($request);

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

    public function update($request, $id)
    {
        $result = $this->repository->getById($id);

        if (!$result) {
            $newResult = null;
            $status = 404;
        } else {
            $newResult = $this->repository->update($request, $result);
            $status = 200;
        }

        $data = [
            'status' => $status,
            'result' => $newResult
        ];
        return $data;
    }

    public function delete($id)
    {
        $result = $this->repository->getById($id);

        $status = 404;
        $message = "User not found";
        if ($result) {
            $this->repository->delete($result);
            $status = 200;
            $message = "Delete success!";
        }

        $data = [
            'status' => $status,
            'message' => $message
        ];
        return $data;
    }


}
