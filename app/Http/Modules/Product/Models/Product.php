<?php

namespace App\Http\Modules\Product\Models;

use DB;
use Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Product
{

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

    public function logTHIS($message) {
        return;
        \Log::info('---'.strtoupper($message).'---');

        $data = [
            'product' => $this->product,
            'unitRate' => $this->unitRate,
            'productTypeEntityId' => $this->productTypeEntityId,
            'productType' => $this->productType,
            'productEntityId' => $this->productEntityId,
            'facilityID' => $this->facilityID,
            'activeRow' => $this->activeRow,
            'screenID' => $this->screenID,
            'debugSproc' => $this->debugSproc,
            'auditScreenVisit' => $this->auditScreenVisit,
            'sessionID' => $this->sessionID,
            'userID' => $this->userID,
            'errors' => $this->errors,
        ];

        \Log::info($data);
    }

    public function __construct(array $config = null)
    {
        if ($config !== null) {
            $this->init($config);
        }

        $this->userID = Session::get('user.userID');
        $this->sessionID = Session::get('user.sessionID');
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

        $this->logTHIS('insert');

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

    // ----------------------------------------


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

        // $data = [
        //     ':iparam_product_entity_id' => $this->productEntityId,
        //     ':iparam_product_name' => $this->product,
        //     ':iparam_product_type_entity_id' => $this->productTypeEntityId,
        //     ':iparam_unit_rate' => floatval($this->unitRate),
        //     ':iparam_active' => intval($this->activeRow),
        //     ':iparam_facility_ids' => $this->facilityID,
        //     ':iparam_session_id' => $this->sessionID,
        //     ':iparam_user_id' => $this->userID,
        //     ':iparam_screen_id' => $this->screenID,
        //     ':iparam_debug_sproc' => $this->debugSproc,
        //     ':iparam_audit_screen_visit' => $this->auditScreenVisit,
        // ];

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

       $this->logTHIS('update');

        // $updateCall->execute($data);
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

        $this->logTHIS('delete');

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

    /**
     * @param int $id
     * @return SchoolClass
     */
    public static function getByID($id)
    {
        $configArray = DB::connection('secondDB')
            ->select('SELECT product, product_type, unit_rate, product_type_entity_id, product_entity_id, active
             FROM view_prd_lkp_product
             WHERE product_entity_id = :productEntityId
             LIMIT 1;', ['productEntityId' => $id]
        );

        return new Product((array)$configArray[0]);
    }

    public static function findOrFail($id) {
        $model = Product::getByID($id);

        if ($model === null || $model->getID() === null) {
            throw new NotFoundHttpException('Not found entity object');
        }

        return $model;
    }

}
