<?php

namespace App\Http\Modules\Product\Models;

use DB;
use Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\Eloquent\MassAssignmentException;
use App\Http\Modules\Product\Repositories\ProductRepository;
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

    public $screen_id = 3007;

    private $repository;

    public function __construct(array $attributes = [])
    {
        // todo: add mutators for this
        if (isset($attributes['active']) && $attributes['active'] == 'on') {
            $attributes['active'] = 1;
        }

        parent::__construct($attributes);

        $this->repository = new ProductRepository;
    }

    public function getId()
    {
        return $this->product_entity_id;
    }

    public function isNewRecord()
    {
        return $this->product_entity_id === null;
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
}
