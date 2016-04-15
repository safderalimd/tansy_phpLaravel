<?php

namespace App\Http\Modules\School\Models;

use DB;
use Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SchoolClass
{
    /** @var integer Primary key */
    private $classEntityID;
    /** @var integer */
    public $activeRow = true;
    /** @var string */
    public $SchoolClassName;
    /** @var array int */
    private $ClassGroupIDs;
    /** @var array int */
    private $ClassCategoryIDs;
    /** @var integer */
    public $ReportingOrder;   
    /** @var array int */
    private $facilityIDs;

    /** @var integer */
    private $sessionID;
    /** @var integer */
    private $userID;

    //unused property
    private $screenID = 3007;
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
        if (isset($config['ClassEntityID'])) {
            $this->classEntityID = $config['ClassEntityID'];
        } elseif(isset($config['class_entity_id'])) {
            $this->classEntityID = $config['class_entity_id'];
        }

        if (isset($config['activeRow'])) {
            $this->activeRow = true;
        } elseif(isset($config['active'])) {
            $this->activeRow = $config['active'];
        } else {
            $this->activeRow = false;
        }

        if (isset($config['SchoolClassName'])) {
            $this->SchoolClassName = $config['SchoolClassName'];
        } elseif(isset($config['class_name'])) {
            $this->SchoolClassName = $config['class_name'];
        }

        if (!$this->isNewRecord()) {
        	$this->loadClassGroup();
        }
        if (isset($config['ClassGroup'])) {
            $this->setClassGroup($config['ClassGroup']);
        }
        if (isset($config['class_group_entity_id'])) {
        	$this->setClassGroup($config['class_group_entity_id']);
        }        
 
        if (!$this->isNewRecord()) {
//        	$this->loadClassCategory();
        }
        if (isset($config['ClassCategory'])) {
            $this->setClassCategory($config['ClassCategory']);
        }
        if (isset($config['class_category_entity_id'])) {
        	$this->setClassCategory($config['class_category_entity_id']);
        }
        elseif(isset($config['class_name'])) {
            $this->setClassCategory($config['class_category_entity_id']);
        }
        
        
        if (isset($config['ReportingOrder'])) {
            $this->ReportingOrder = $config['ReportingOrder'];
        } elseif(isset($config['reporting_order'])) {
            $this->ReportingOrder = $config['reporting_order'];
        }

        if (!$this->isNewRecord()) {
            $this->loadFacility();
        }
        if (isset($config['facilityID'])) {
            $this->setFacility($config['facilityID']);
        }
        if (isset($config['facility_entity_id'])) {
            $this->setFacility($config['facility_entity_id']);
        }
    }

    /**
     * @return int ID
     */
    public function getID()
    {
        return $this->classEntityID;
    }

    /**
     * @param int $id
     * @return SchoolClass
     */
    public static function getByID($id)
    {
        $configArray = DB::connection('secondDB')
            ->select('SELECT class_entity_id, class_name, reporting_order, class_category_entity_id, class_group_entity_id, facility_entity_id, active
             FROM view_sch_class_detail
             WHERE class_entity_id = :classEntityID
             LIMIT 1;', ['classEntityID' => $id]
            );

        $model = new SchoolClass((array)$configArray[0]);

        if ($model->getID() === null) {
            throw new NotFoundHttpException('Not found entity object');
        }

        return $model;
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
        else if (is_string($facilities)) {
            $array = [];

            foreach (explode(',', $facilities) as $item) {
                $array[] = trim($item);
            }

            $this->facilityIDs = $array;
        }
        else {
            $this->facilityIDs[] = $facilities;
        }
    }

    /**
     * @return string
     */
    private function getFacilityAsString()
    {
        if (is_array($this->facilityIDs)) {
//            return implode(',', $this->facilityIDs);
            $t = $this->facilityIDs[0];
            return $t;
        }

        return false;
    }

    

    /**
     * @return array
     */
    public function getClassGroups()
    {
    	return $this->ClassGroupIDs;
    }
    
    /**
     * @param $ClassGroupes array|string
     */
    public function setClassGroup($ClassGroupes)
    {
    	if (is_array($ClassGroupes)) {
    		$this->ClassGroupIDs = $ClassGroupes;
    	}
    	else if (is_string($ClassGroupes)) {
    		$array = [];

    		foreach (explode(',', $ClassGroupes) as $item) {
    			$array[] = trim($item);
    		}

    		$this->ClassGroupIDs = $array;
    	}
        else {
            $this->ClassGroupIDs[] = $ClassGroupes;
        }
    }
    
    /**
     * @return string
     */
    private function getClassGroupAsString()
    {
    	if (is_array($this->ClassGroupIDs)) {
    		return implode(',', $this->ClassGroupIDs);
    	}
    
    	return false;
    }
    
    
    
    
    
    
    
    /**
     * @return array
     */
    public function getClassCategorys()
    {
    	return $this->ClassCategoryIDs;
    }
    
    /**
     * @param $ClassCategoryes array|string
     */
    public function setClassCategory($ClassCategoryes)
    {
    	if (is_array($ClassCategoryes)) {
    		$this->ClassCategoryIDs = $ClassCategoryes;
    	}
    	else if (is_string($ClassCategoryes)) {
    		$array = [];

    		foreach (explode(',', $ClassCategoryes) as $item) {
    			$array[] = trim($item);
    		}

    		$this->ClassCategoryIDs = $array;
    	}
        else {
            $this->ClassCategoryIDs[] = $ClassCategoryes;
        }
    }
    
    /**
     * @return string
     */
    private function getClassCategoryAsString()
    {
    	if (is_array($this->ClassCategoryIDs)) {
    		return implode(',', $this->ClassCategoryIDs);
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
        return $this->classEntityID === null;
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
            'CALL sproc_sch_class_dml_ins (:iparam_class_name, :iparam_class_group_entity_id, :iparam_class_category_entity_id,
            :iparam_reporting_order, :iparam_facility_ids, :iparam_session_id, :iparam_user_id, :iparam_screen_id,
            :iparam_debug_sproc, :iparam_audit_screen_visit,
            @oparam_class_entity_id, @oparam_err_flag, @oparam_err_step, @oparam_err_msg);'
        );

        $insertCall->bindValue(':iparam_class_name', $this->SchoolClassName);
        $insertCall->bindValue(':iparam_class_group_entity_id', $this->getClassGroupAsString());
        $insertCall->bindValue(':iparam_class_category_entity_id', $this->getClassCategoryAsString());
        $insertCall->bindValue(':iparam_reporting_order', $this->ReportingOrder);

        $insertCall->bindValue(':iparam_facility_ids', $this->getFacilityAsString());
        $insertCall->bindValue(':iparam_session_id', $this->sessionID);
        $insertCall->bindValue(':iparam_user_id', $this->userID);
        $insertCall->bindValue(':iparam_screen_id', $this->screenID);
        $insertCall->bindValue(':iparam_debug_sproc', $this->debugSproc);
        $insertCall->bindValue(':iparam_audit_screen_visit', $this->auditScreenVisit);

        $insertCall->execute();

        $response = $dbConnection
            ->query('SELECT @oparam_class_entity_id, @oparam_err_flag, @oparam_err_step, @oparam_err_msg')
            ->fetch(\PDO::FETCH_ASSOC);

        if ($response['@oparam_err_flag'] == null) {
            $this->classEntityID = $response['@oparam_class_entity_id'];
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
            'CALL sproc_sch_class_dml_upd(:iparam_class_entity_id ,:iparam_class_name, :iparam_class_group_entity_id,
                :iparam_class_category_entity_id,:iparam_reporting_order,:iparam_facility_id, :iparam_active,:iparam_session_id, :iparam_user_id,
                :iparam_screen_id,:iparam_debug_sproc, :iparam_audit_screen_visit, @oparam_err_flag, @oparam_err_step, @oparam_err_msg);'
        );

        $updateCall->execute([
            ':iparam_class_entity_id' => $this->classEntityID,
            ':iparam_class_name' => $this->SchoolClassName,
            ':iparam_class_group_entity_id' => $this->getClassGroupAsString(),
        	':iparam_class_category_entity_id' => $this->getClassCategoryAsString(),
            ':iparam_reporting_order' => $this->ReportingOrder,
        	':iparam_active' => $this->activeRow,
            ':iparam_facility_id' => $this->getFacilityAsString(),
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
            'CALL sproc_sch_class_dml_del(:iparam_class_entity_id, :iparam_session_id,
            :iparam_user_id, :iparam_screen_id, :iparam_debug_sproc, :iparam_audit_screen_visit,
            @oparam_err_flag, @oparam_err_step, @oparam_err_msg);'
        );

        $deleteCall->execute([
            ':iparam_class_entity_id' => $this->classEntityID,
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
            ['fiscal_year_entity_id' => $this->classEntityID]
        );

        $this->setFacility(array_column($response, 'facility_entity_id'));

        return $response;
    }
    
    private function loadClassGroup()
    {
    	$response = DB::connection('secondDB')->select(
    			'SELECT
               class_group_entity_id,
               class_group
             FROM view_sch_lkp_class_group
    		WHERE class_group_entity_id = :class_group_entity_id
             ORDER BY class_group;',
    			['class_group_entity_id' => $this->classEntityID]
    			);
    
    	$this->setClassGroup(array_column($response, 'class_group_entity_id'));
    
    	return $response;
    }
    
    private function loadClassCategory()
    {
    	$response = DB::connection('secondDB')->select(
    			'SELECT
               class_category_entity_id,
               class_category
             FROM view_sch_lkp_class_category
    		WHERE class_category_entity_id = :class_category_entity_id
             ORDER BY class_category;',
    			['class_category_entity_id' => $this->classEntityID]
    			);
    
    	$this->setClassGroup(array_column($response, 'class_category_entity_id'));
    
    	return $response;
    }    
    
}