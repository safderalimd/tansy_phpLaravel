<?php

namespace App\Http\Modules\Organization\Models;

use DB;
use Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FiscalYear
{
    /** @var integer Primary key */
    private $entityID;

    /** @var string */
    public $startDate;
    /** @var string */
    public $endDate;
    /** @var string */
    public $name;
    /** @var integer */
    public $currentFiscalYear = false;
    /** @var array int */
    private $facilityIDs;

    /** @var integer */
    private $sessionID;
    /** @var integer */
    private $userID;

    //unused property
    private $screenID = 2001;
    private $debugSproc = 1;
    private $auditScreenVisit = 1;

    /** @var string */
    private $errors = null;

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
        if (isset($config['entityID'])) {
            $this->entityID = $config['entityID'];
        } elseif(isset($config['fiscal_year_entity_id'])) {
            $this->entityID = $config['fiscal_year_entity_id'];
        }

        if (isset($config['startDate'])) {
            $this->startDate = $config['startDate'];
        } elseif(isset($config['start_date'])) {
            $this->startDate = $config['start_date'];
        }

        if (isset($config['endDate'])) {
            $this->endDate = $config['endDate'];
        } elseif(isset($config['end_date'])) {
            $this->endDate = $config['end_date'];
        }

        if (isset($config['name'])) {
            $this->name = $config['name'];
        } elseif(isset($config['fiscal_year'])) {
            $this->name = $config['fiscal_year'];
        }

        if (isset($config['currentFiscalYear'])) {
            $this->currentFiscalYear = $config['currentFiscalYear'];
        } elseif(isset($config['current_fiscal_year'])) {
            $this->currentFiscalYear = $config['current_fiscal_year'];
        }

        if (!$this->isNewRecord()) {
            $this->loadFacility();
        }
        if (isset($config['facility'])) {
            $this->setFacility($config['facility']);
        }
    }

    /**
     * @return int ID
     */
    public function getID()
    {
        return $this->entityID;
    }

    /**
     * @return array
     */
    public function getFacilitates()
    {
        return $this->facilityIDs;
    }

    /**
     * @param $facilities array|string
     */
    public function setFacility($facilities)
    {
        if (is_array($facilities)) {
            $this->facilityIDs = $facilities;
        }

        if (is_string($facilities)) {
            $array = [];

            foreach (explode(',', $facilities) as $item) {
                $array[] = trim($item);
            }

            $this->facilityIDs = $array;
        }
    }

    /**
     * @return string
     */
    private function getFacilityAsString()
    {
        if (is_array($this->facilityIDs)) {
            return implode(',', $this->facilityIDs);
        }

        return false;
    }

    /**
     * Check if this new record
     *
     * @return bool
     */
    public function isNewRecord()
    {
        return $this->entityID === null;
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

        $insertCall = $dbConnection->prepare(
            'CALL sproc_org_fiscal_year_dml_ins (:iparam_start_date, :iparam_end_date, :iparam_name,
            :iparam_current_fiscal_year, :iparam_facility_ids, :iparam_session_id, :iparam_user_id, :iparam_screen_id,
            :iparam_debug_sproc, :iparam_audit_screen_visit,
            @oparam_fiscal_year_entity_id, @oparam_err_flag, @oparam_err_step, @oparam_err_msg);'
        );

        $insertCall->bindValue(':iparam_start_date', $this->startDate);
        $insertCall->bindValue(':iparam_end_date', $this->endDate);
        $insertCall->bindValue(':iparam_name', $this->name);
        $insertCall->bindValue(':iparam_current_fiscal_year', $this->currentFiscalYear);
        $insertCall->bindValue(':iparam_facility_ids', $this->getFacilityAsString());
        $insertCall->bindValue(':iparam_session_id', $this->sessionID);
        $insertCall->bindValue(':iparam_user_id', $this->userID);
        $insertCall->bindValue(':iparam_screen_id', $this->screenID);
        $insertCall->bindValue(':iparam_debug_sproc', $this->debugSproc);
        $insertCall->bindValue(':iparam_audit_screen_visit', $this->auditScreenVisit);

        $insertCall->execute();

        $response = $dbConnection
            ->query('SELECT @oparam_fiscal_year_entity_id, @oparam_err_flag, @oparam_err_step, @oparam_err_msg')
            ->fetch(\PDO::FETCH_ASSOC);

        if ($response['@oparam_err_flag'] == null) {
            $this->entityID = $response['@oparam_fiscal_year_entity_id'];
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

        $updateCall = $dbConnection->prepare(
            'CALL sproc_org_fiscal_year_dml_upd(:iparam_start_date ,:iparam_end_date, :iparam_name,
                :iparam_current_fiscal_year,:iparam_facility_ids,:iparam_fiscal_year_entity_id,:iparam_session_id, :iparam_user_id,
                :iparam_screen_id,:iparam_debug_sproc, :iparam_audit_screen_visit, @oparam_err_flag, @oparam_err_step, @oparam_err_msg);'
        );

        $updateCall->execute([
            ':iparam_fiscal_year_entity_id' => $this->entityID,
            ':iparam_start_date' => $this->startDate,
            ':iparam_end_date' => $this->endDate,
            ':iparam_name' => $this->name,
            ':iparam_current_fiscal_year' => $this->currentFiscalYear,
            ':iparam_facility_ids' => $this->getFacilityAsString(),
            ':iparam_session_id' => $this->sessionID,
            ':iparam_user_id' => $this->userID,
            ':iparam_screen_id' => $this->screenID,
            ':iparam_debug_sproc' => $this->debugSproc,
            ':iparam_audit_screen_visit' => $this->auditScreenVisit,
        ]);

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
            'CALL sproc_org_fiscal_year_dml_del(:iparam_fiscal_year_entity_id, :iparam_session_id,
            :iparam_user_id, :iparam_screen_id, :iparam_debug_sproc, :iparam_audit_screen_visit,
            @oparam_err_flag, @oparam_err_step, @oparam_err_msg);'
        );

        $deleteCall->execute([
            ':iparam_fiscal_year_entity_id' => $this->entityID,
            ':iparam_session_id' => $this->sessionID,
            ':iparam_user_id' => $this->userID,
            ':iparam_screen_id' => $this->screenID,
            ':iparam_debug_sproc' => $this->debugSproc,
            ':iparam_audit_screen_visit' => $this->auditScreenVisit,
        ]);

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

    private function loadFacility()
    {
        $response = DB::connection('secondDB')->select(
            'SELECT
               entity_id AS fiscal_year_entity_id,
               facility_entity_id
             FROM view_org_entity_scope
             WHERE entity_id = :fiscal_year_entity_id
             ORDER BY fiscal_year_entity_id, facility_entity_id;',
            ['fiscal_year_entity_id' => $this->entityID]
        );

        $this->setFacility(array_column($response, 'facility_entity_id'));

        return $response;
    }

    /**
     * @param int $id
     * @return FiscalYear
     */
    public static function getByID(int $id)
    {
        $configArray = DB::connection('secondDB')
            ->select('SELECT fiscal_year_entity_id, fiscal_year, start_date, end_date, current_fiscal_year
             FROM view_org_fiscal_year_detail
             WHERE fiscal_year_entity_id = :entityID
             LIMIT 1;', ['entityID' => $id]
            );

        return new FiscalYear((array)$configArray[0]);
    }

    /**
     * @param int $id
     * @return FiscalYear
     */
    public static function findOrFail($id)
    {
        $model = FiscalYear::getByID($id);

        if ($model === null || $model->getID() === null) {
            throw new NotFoundHttpException('Not found entity object');
        }

        return $model;
    }
}
