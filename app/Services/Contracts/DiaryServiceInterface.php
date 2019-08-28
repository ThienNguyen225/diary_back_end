<?php


namespace App\Services\Contracts;


interface DiaryServiceInterface extends ServiceInterface
{
    public function getDiaryOfUser();

    public function createDiaryOfUser($data);

    public function updateDiaryOfUser($data, $object);
}
