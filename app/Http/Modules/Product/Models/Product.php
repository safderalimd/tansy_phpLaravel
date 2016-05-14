<?php

namespace App\Http\Modules\Product\Models;

use DB;
use Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Http\Modules\Product\ProductRepository;

class Product
{
    // has all fields as the same as in db views; same type;
    // name is like in db views but camel case
    // properties are hydrated automatically (either from db or from form inputs)
    // use this as a substitution for eloquent models
    // maybe create a fillable property with all the available fields

    public $product;
    public $unitRate;
    public $productTypeEntityId;
    public $productType;
    public $productEntityId;
    public $facilityID;

    public $activeRow = true;

    //unused property
    public $screenID = 3007;
    public $debugSproc = 1;
    public $auditScreenVisit = 1;

    public $sessionID;
    public $userID;

    public $errors = null;

    private $repository;

    public function __construct(array $config = null)
    {
        if ($config !== null) {
            $this->init($config);
        }

        $this->userID = Session::get('user.userID');
        $this->sessionID = Session::get('user.sessionID');
        $this->repository = new ProductRepository;
    }

    /**
     * @param array $config
     */
    public function init(array $config)
    {
        if (isset($config['activeRow'])) {
            $this->activeRow = true;
        } elseif (isset($config['active'])) {
            $this->activeRow = true;
        } else {
            $this->activeRow = false;
        }

        if (isset($config['product'])) {
            $this->product = $config['product'];
        }

        if (isset($config['product_entity_id'])) {
            $this->productEntityId = $config['product_entity_id'];
        }

        if (isset($config['productType'])) {
            $this->productTypeEntityId = $config['productType'];
        } elseif (isset($config['product_type_entity_id'])) {
            $this->productTypeEntityId = $config['product_type_entity_id'];
        }

        if (isset($config['product_type'])) {
            $this->productType = $config['product_type'];
        }

        if (isset($config['unitRate'])) {
            $this->unitRate = $config['unitRate'];
        } elseif (isset($config['unit_rate'])) {
            $this->unitRate = $config['unit_rate'];
        }

        if (isset($config['facilityID'])) {
            $this->facilityID = $config['facilityID'];
        }
    }

    /**
     * Check if this new record
     *
     * @return bool
     */
    public function isNewRecord()
    {
        return $this->productEntityId === null;
    }

    /**
     * @return int ID
     */
    public function getID()
    {
        return $this->productEntityId;
    }

    public function hasType($type)
    {
        if ($this->isNewRecord()) {
            return false;
        }

        if ($type['product_type_entity_id'] == $this->productTypeEntityId) {
            return true;
        }

        return false;
    }

    public function hasFacility($facility)
    {
        if ($this->isNewRecord()) {
            return false;
        }

        if ($facility['facility_entity_id'] == $this->facilityID) {
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
        $instance = new static;

        $data = $instance->repository->getProductById($id);
        $model = new Product((array)$data[0]);

        if ($model === null || $model->getID() === null) {
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
