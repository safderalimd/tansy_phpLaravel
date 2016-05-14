<?php

namespace App\Http\Modules\School\Models;

use App\Http\Modules\School\Repositories\ClassSubjectMapRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Http\Models\Model;

class ClassSubjectMap extends Model
{
    public $screen_id = 3002;

    private $repository;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->repository = new ClassSubjectMapRepository;
    }

    public function map()
    {
        return $this->repository->map($this);
    }

    public function delete()
    {
        return $this->repository->delete($this);
    }

    public static function all()
    {
        $instance = new static;
        return $instance->repository->getAll();
    }

    public static function findOrFail($id)
    {
        static::unguard();
        $instance = new static;

        $data = $instance->repository->getById($id);
        $model = new static((array)$data[0]);

        static::reguard();

        if ($model === null || $model->getId() === null) {
            throw new NotFoundHttpException('Not found entity object');
        }

        return $model;
    }

    public function getId()
    {
        return $this->subject_entity_id;
    }

}
