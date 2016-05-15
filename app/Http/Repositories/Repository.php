<?php

namespace App\Http\Repositories;

use DB;

class Repository
{

    public function db()
    {
        return DB::connection('secondDB');
    }

    public function runProcedure($model, $procedure, $iparams, $oparams)
    {
        // generate the sql for the procedure call
        $procedureSql = $this->generateProcedureSql($procedure, $iparams, $oparams);

        // prepare the procedure
        $pdo = $this->db()->getPdo();
        $dbCall = $pdo->prepare($procedureSql);

        // bind the input parameters
        foreach ($iparams as $parameter) {
            $property = substr($parameter, 8);
            $dbCall->bindValue($parameter, $model->{$property});
        }

        // execute procedure
        $dbCall->execute();

        // generate sql for output params and execute it
        $outputSql = $this->generateOutputSql($oparams);
        $response = $pdo->query($outputSql)->fetch(\PDO::FETCH_ASSOC);

        // set output params on the model
        foreach ($oparams as $oparam) {
            if (isset($response[$oparam])) {
                $property = substr($oparam, 8);
                $model->setAttribute($property, $response[$oparam]);
            }
        }

        if ($response['@oparam_err_flag'] == null) {
            return true;
        }

        $model->errors = $response['@oparam_err_msg'];
        return false;
    }

    /**
     * Generate sql to select procedure output parameters.
     *
     * @param  array $oparams
     * @return string
     */
    public function generateOutputSql($oparams)
    {
        return 'SELECT ' . implode(', ', $oparams);
    }

    /**
     * Generate sql for procedure with input parameters.
     *
     * @param  array $oparams
     * @return string
     */
    public function generateProcedureSql($procedure, $iparams, $oparams)
    {
        $sql = 'call ' . $procedure . '(';
        $sql .= implode(', ', $iparams);
        $sql .= ', ';
        $sql .= implode(', ', $oparams);
        $sql .= ');';
        return $sql;
    }

    public function getAdmissionGrid()
    {
        return $this->db()->select(
            'SELECT student_full_name, admission_number, admission_date, admitted_to, admission_status, admission_id, admission_status_id
             FROM view_sch_admission_grid
             ORDER BY student_full_name DESC;'
        );
    }

    public function getFiscalYears()
    {
        return $this->db()->select(
            'SELECT fiscal_year_entity_id, fiscal_year
             FROM view_org_lkp_fiscal_year
             ORDER BY fiscal_year DESC;'
        );
    }

    public function getClasses()
    {
        return $this->db()->select(
            'SELECT class_entity_id, class_name, class_group, class_category, class_group_entity_id, class_category_entity_id
             FROM view_sch_lkp_class
             ORDER BY class_name DESC;'
        );
    }

    public function getFacilities()
    {
        return $this->db()->select(
            'SELECT facility_entity_id, facility_name
             FROM view_org_lkp_facility
             ORDER BY facility_name DESC;'
        );
    }

    public function getClassGroups()
    {
        return $this->db()->select(
            'SELECT class_group_entity_id, class_group
             FROM view_sch_lkp_class_group
             ORDER BY class_group DESC;'
        );
    }

    public function getCities()
    {
        return $this->db()->select(
            'SELECT city_id, city_name, district, state, country
             FROM view_org_lkp_city
             ORDER BY city_name DESC;'
        );
    }

    public function getCityAreas()
    {
        return $this->db()->select(
            'SELECT city_area
             FROM view_org_lkp_city_area
             ORDER BY city_area DESC;'
        );
    }

    public function getCastes()
    {
        return $this->db()->select(
            'SELECT caste_id, caste_name
             FROM view_org_lkp_caste
             ORDER BY caste_name DESC;'
        );
    }

    public function getReligions()
    {
        return $this->db()->select(
            'SELECT religion_id, religion_name
             FROM view_org_lkp_religion
             ORDER BY religion_name DESC;'
        );
    }

    public function getLanguages()
    {
        return $this->db()->select(
            'SELECT language_id, language_name
             FROM view_org_lkp_language
             ORDER BY language_name DESC;'
        );
    }

    public function getRelationships()
    {
        return $this->db()->select(
            'SELECT relationship_type_id, relationship_name
             FROM view_org_lkp_relationship
             ORDER BY relationship_name DESC;'
        );
    }

    public function getDesignations()
    {
        return $this->db()->select(
            'SELECT designation_id, designation_name
             FROM view_org_lkp_designation
             ORDER BY designation_name DESC;'
        );
    }

    public function getProducts()
    {
        return $this->db()->select(
            'SELECT product, product_type, unit_rate, product_type_entity_id, product_entity_id, active
             FROM view_prd_lkp_product
             ORDER BY product DESC;'
        );
    }

    public function getProductTypes()
    {
        return $this->db()->select(
            'SELECT product_type_entity_id, product_type
             FROM view_prd_lkp_product_type
             ORDER BY product_type;'
        );
    }

    public function getClassSubjectsGrid()
    {
        return $this->db()->select(
            'SELECT class_name, subject, mapped, class_entity_id, subject_entity_id
             FROM view_sch_class2subject_grid
             ORDER BY class_name DESC;'
        );
    }

}
