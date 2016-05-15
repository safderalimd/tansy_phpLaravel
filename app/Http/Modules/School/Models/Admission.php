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
        'student_first_name',
        'student_middle_name',
        'student_last_name',
        'student_date_of_birth',
        'student_gender',

        // contact
        'home_phone',
        'mobile_phone',
        'email',

        // adress
        'address1',
        'address2',
        'city_name',
        'city_area',
        'postal_code',

        // student inf,
        'admission_number',
        'admission_date',
        'admitted_to_class_group_entity_id',
        'admitted_to_class_entity_id',
        'student_roll_number',
        'identification1',
        'identification2',
        'caste_name',
        'religion_name',
        'mother_language_name',

        // parent
        'parent_relationship_type_id',
        'parent_gender',
        'parent_first_name',
        'parent_last_name',
        'parent_middle_name',
        'parent_designation_name',
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
