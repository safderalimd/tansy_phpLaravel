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
    private $productTypeEntityId;
    private $productType;
    private $productEntityId;
    private $facilityID;

    public $activeRow = true;

    //unused property
    private $screenID = 3007;
    private $debugSproc = 1;
    private $auditScreenVisit = 1;

    private $sessionID;
    private $userID;

    private $errors = null;

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
    private function init(array $config)
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

    /**
     * Save the model in DB
     *
     * @return mixed
     */
    public function save()
    {
        return $this->isNewRecord() ? $this->insert() : $this->update();
    }

    /**
     * @return mixed
     */
    private function insert()
    {
        $dbConnection = DB::connection('secondDB')->getPdo();

        $insertCall = $dbConnection->prepare('
            call sproc_prd_product_dml_ins (
                :iparam_product_name,
                :iparam_product_type_entity_id,
                :iparam_unit_rate,
                :iparam_facility_ids,
                :iparam_session_id,
                :iparam_user_id,
                :iparam_screen_id,
                :iparam_debug_sproc,
                :iparam_audit_screen_visit,
                @oparam_product_entity_id,
                @oparam_err_flag,
                @oparam_err_step,
                @oparam_err_msg
            );
        ');

        $insertCall->bindValue(':iparam_product_name', $this->product);
        $insertCall->bindValue(':iparam_product_type_entity_id', $this->productTypeEntityId);
        $insertCall->bindValue(':iparam_unit_rate', $this->unitRate);
        $insertCall->bindValue(':iparam_facility_ids', $this->facilityID);
        $insertCall->bindValue(':iparam_session_id', $this->sessionID);
        $insertCall->bindValue(':iparam_user_id', $this->userID);
        $insertCall->bindValue(':iparam_screen_id', $this->screenID);
        $insertCall->bindValue(':iparam_debug_sproc', $this->debugSproc);
        $insertCall->bindValue(':iparam_audit_screen_visit', $this->auditScreenVisit);

        $insertCall->execute();

        $response = $dbConnection
            ->query('SELECT @oparam_product_entity_id, @oparam_err_flag, @oparam_err_step, @oparam_err_msg')
            ->fetch(\PDO::FETCH_ASSOC);

        if ($response['@oparam_err_flag'] == null) {
            $this->productEntityId = $response['@oparam_product_entity_id'];
            return true;
        }

        $this->errors = $response['@oparam_err_msg'];
        return false;
    }

    /**
     * @return mixed
     */
    private function update()
    {
        $dbConnection = DB::connection('secondDB')->getPdo();

        $updateCall = $dbConnection->prepare('
            call sproc_prd_product_dml_upd (
                :iparam_product_entity_id,
                :iparam_product_name,
                :iparam_product_type_entity_id,
                :iparam_unit_rate,
                :iparam_active,
                :iparam_facility_ids,
                :iparam_session_id,
                :iparam_user_id,
                :iparam_screen_id,
                :iparam_debug_sproc,
                :iparam_audit_screen_visit,
                @oparam_err_flag,
                @oparam_err_step,
                @oparam_err_msg
            );
        ');

        $updateCall->bindValue(':iparam_product_entity_id', $this->productEntityId);
        $updateCall->bindValue(':iparam_product_name', $this->product);
        $updateCall->bindValue(':iparam_product_type_entity_id', $this->productTypeEntityId);
        $updateCall->bindValue(':iparam_unit_rate', floatval($this->unitRate));
        $updateCall->bindValue(':iparam_active', intval($this->activeRow));
        $updateCall->bindValue(':iparam_facility_ids', $this->facilityID);
        $updateCall->bindValue(':iparam_session_id', $this->sessionID);
        $updateCall->bindValue(':iparam_user_id', $this->userID);
        $updateCall->bindValue(':iparam_screen_id', $this->screenID);
        $updateCall->bindValue(':iparam_debug_sproc', $this->debugSproc);
        $updateCall->bindValue(':iparam_audit_screen_visit', $this->auditScreenVisit);

        $updateCall->execute();

        $response = $dbConnection->query('SELECT @oparam_err_flag, @oparam_err_step, @oparam_err_msg')->fetch(\PDO::FETCH_ASSOC);

        if ($response['@oparam_err_flag'] == null) {
            return true;
        }

        $this->errors = $response['@oparam_err_msg'];
        return false;
    }

    /**
     * @return mixed
     */
    public function delete()
    {
        $dbConnection = DB::connection('secondDB')->getPdo();

        $deleteCall = $dbConnection->prepare(
            'call sproc_prd_product_dml_del(
                :iparam_product_entity_id,
                :iparam_session_id,
                :iparam_user_id,
                :iparam_screen_id,
                :iparam_debug_sproc,
                :iparam_audit_screen_visit,
                @oparam_err_flag,
                @oparam_err_step,
                @oparam_err_msg
            );
        ');

        $data = [
            ':iparam_product_entity_id' => $this->productEntityId,
            ':iparam_session_id' => $this->sessionID,
            ':iparam_user_id' => $this->userID,
            ':iparam_screen_id' => $this->screenID,
            ':iparam_debug_sproc' => $this->debugSproc,
            ':iparam_audit_screen_visit' => $this->auditScreenVisit,
        ];

        $deleteCall->execute($data);

        $response = $dbConnection->query('SELECT @oparam_err_flag, @oparam_err_step, @oparam_err_msg')->fetch(\PDO::FETCH_ASSOC);

        if ($response['@oparam_err_flag'] == null) {
            return true;
        }

        $this->errors = $response['@oparam_err_msg'];
        return false;
    }

    public function getErrors()
    {
        return $this->errors;
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
