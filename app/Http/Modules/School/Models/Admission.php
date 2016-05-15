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
        // header
        'facility_entity_id',

        // student
        'first_name',
        'middle_name',
        'last_name',
        'date_of_birth',
        'gender',

        // contact
        'email',
        'home_phone',
        'mobile_phone',

        // adress
        'adress1',
        'adress2',
        'city_id',
        'city_area',
        'postal_code',

        // student inf,
        'admission_number',
        'admission_date',
        'class_entity_id',
        'class_group_entity_id',
        'roll_number',
        'identification1',
        'identification2',
        'caste_id',
        'religion_id',
        'language_id',

        // parent
        'relationship_type_id',
        'parent_gender',
        'parent_first_name',
        'parent_middle_name',
        'parent_last_name',
        'designation_id',
    ];

    public $screen_id = 3004;

    private $repository;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->repository = new AdmissionRepository;
    }

    public function save()
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
        // static::unguard();
        // $instance = new static;

        // $data = $instance->repository->getById($id);
        // $model = new static((array)$data[0]);

        // static::reguard();

        // if ($model === null || $model->getId() === null) {
            throw new NotFoundHttpException('Not found entity object');
        // }

        // return $model;
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
