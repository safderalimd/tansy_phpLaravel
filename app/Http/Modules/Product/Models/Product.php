<?php

namespace App\Http\Modules\Product\Models;

use DB;
use Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\Eloquent\MassAssignmentException;
use App\Http\Modules\Product\ProductRepository;
use App\Http\Models\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_entity_id',
        'product_name',
        'product_type_entity_id',
        'unit_rate',
        'facility_ids',
        'active',
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $defaults = [
        'session_id',
        'user_id',
        'screen_id',
        'debug_sproc',
        'audit_screen_visit',
    ];

    // guarded items are needed for all requests; don't need both guarded and fillable; use it instead to set default values

    // has all fields as the same as in db views; same type;
    // name is like in db views but camel case
    // properties are hydrated automatically (either from db or from form inputs)
    // use this as a substitution for eloquent models
    // maybe create a fillable property with all the available fields

    // todo: add rules so 'product' is converted to 'product_name' on edit route; actually use 'SELECT column AS name' where view column names differ from procedure names to select it as the procedure name (to be cosistent); and name form names as procedure names too
    // add mutators (would work great for things lie active checkbox)

    public $userID;
    public $sessionID;
    public $debugSproc;
    public $auditScreenVisit;

    //unused property
    public $screenID = 3007;

    public $errors = null;

    private $repository;

    public function __construct(array $attributes = [])
    {
        // todo: add mutators for this
        if (isset($attributes['active']) && $attributes['active'] == 'on') {
            $attributes['active'] = 1;
        }

        $this->fill($attributes);

        $this->userID = Session::get('user.userID');
        $this->sessionID = Session::get('user.sessionID');
        $this->debugSproc = Session::get('user.debugSproc');
        $this->auditScreenVisit = Session::get('user.auditScreenVisit');

        $this->repository = new ProductRepository;
    }

    public function isNewRecord()
    {
        return $this->product_entity_id === null;
    }

    public function getId()
    {
        return $this->product_entity_id;
    }

    public function hasType($type)
    {
        if ($this->isNewRecord()) {
            return false;
        }

        if ($type['product_type_entity_id'] == $this->product_type_entity_id) {
            return true;
        }

        return false;
    }

    public function hasFacility($facility)
    {
        if ($this->isNewRecord()) {
            return false;
        }

        if ($facility['facility_entity_id'] == $this->facility_ids) {
            return true;
        }

        return false;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Save the model in DB
     *
     * @return mixed
     */
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

        $data = $instance->repository->getProductById($id);
        $model = new Product((array)$data[0]);

        static::reguard();

        if ($model === null || $model->getId() === null) {
            throw new NotFoundHttpException('Not found entity object');
        }

        return $model;
    }

    public static function all()
    {
        $instance = new static;

        return $instance->repository->getAllProducts();
    }

    public function types()
    {
        return $this->repository->getProductTypes();
    }

    public function facilities()
    {
        return $this->repository->getProductFacilities();
    }

}
