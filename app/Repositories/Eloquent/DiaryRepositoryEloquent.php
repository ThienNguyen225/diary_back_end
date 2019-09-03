<?php


namespace App\Repositories\Eloquent;


use App\Diary;
use App\Repositories\Contracts\DiaryInterface;
use Illuminate\Support\Facades\Auth;

class DiaryRepositoryEloquent extends RepositoryEloquent implements DiaryInterface
{
    public function getModel()
    {
        return Diary::class;
    }

    public function getIdUser()
    {
        return Auth::user()->id;
    }

    public function getDiaryOfUser()
    {
        return $this->model->where('id_user', $this->getIdUser())->orderBy('updated_at', 'DESC')->get();
    }

    public function createDiaryOfUser($data)
    {
        $data['id_user'] = $this->getIdUser();
        $object = $this->model->create($data);
        return $object;
    }

    public function updateDiaryOfUser($data, $object)
    {
        $data['id_user'] = $this->getIdUser();
        $object->update($data);
        return $object;
    }

}
