<?php

namespace App\Http\Modules\School\Models;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Http\Modules\School\Repositories\AdmissionRepository;
use App\Http\Models\Model;

class Admission extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_full_name',
        'admission_number',
        'admission_date',
        'admitted_to',
        'admission_status',
        'admission_id',
        'admission_status_id',
    ];

    public $screen_id = 3004;

    private $repository;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->repository = new AdmissionRepository;
    }

    public function getId()
    {
        // return $this->product_entity_id;
    }

    public function isNewRecord()
    {
        // return $this->product_entity_id === null;
    }

    public function save()
    {
        return $this->isNewRecord() ? $this->insert() : $this->update();
    }

    public function insert()
    {
        return $this->repository->insert($this);
    }

    public function update()
    {
       return $this->repository->update($this);
    }

    public function delete()
    {
      return $this->repository->delete($this);
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

    public static function all()
    {
        $instance = new static;
        return $instance->repository->getAll();
    }

    public function fiscalYears()
    {
        return $this->repository->getFiscalYears();
    }

    public function classes()
    {
        return $this->repository->getClasses();
    }

    public function facilities()
    {
        return $this->repository->getFacilities();
    }

    public function classGroups()
    {
        return $this->repository->getClassGroups();
    }

    public function cities()
    {
        return $this->repository->getCities();
    }

    public function cityAreas()
    {
        return $this->repository->getCityAreas();
    }

    public function castes()
    {
        return $this->repository->getCastes();
    }

    public function religions()
    {
        return $this->repository->getReligions();
    }

    public function languages()
    {
        return $this->repository->getLanguages();
    }

    public function relationships()
    {
        return $this->repository->getRelationships();
    }

    public function designations()
    {
        return $this->repository->getDesignations();
    }
}
