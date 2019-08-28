<?php


namespace App\Repositories\Contracts;


interface DiaryInterface extends RepositoryInterface
{
    public function getDiaryOfUser();

    public function createDiaryOfUser($data);

    public function updateDiaryOfUser($data, $object);
}
