<?php

namespace App\Http\Modules\loaddata\School\Repositories;

use App\Http\Repositories\Repository;

class StudentDataRepository extends Repository
{
    public function getColumnMapping()
    {
        return $this->select(
            'SELECT
                table_name,
                table_column_name,
                file_column_name
            FROM view_sys_external_load_column_mapping
            WHERE table_name = "sch_admission";'
        );
    }

    // public function insert($model)
    // {
    //     $procedure = 'sproc_prd_product_dml_ins';

    //     $iparams = [
    //         ':iparam_product_name',
    //         ':iparam_product_type_entity_id',
    //         ':iparam_unit_rate',
    //         ':iparam_facility_ids',
    //         ':iparam_session_id',
    //         ':iparam_user_id',
    //         ':iparam_screen_id',
    //         ':iparam_debug_sproc',
    //         ':iparam_audit_screen_visit',
    //     ];

    //     $oparams = [
    //         '@oparam_product_entity_id',
    //         '@oparam_err_flag',
    //         '@oparam_err_step',
    //         '@oparam_err_msg'
    //     ];

    //     return $this->runProcedure($model, $procedure, $iparams, $oparams);
    // }

    // public function update($model)
    // {
    //     $procedure = 'sproc_prd_product_dml_upd';

    //     $iparams = [
    //         ':iparam_product_entity_id',
    //         ':iparam_product_name',
    //         ':iparam_product_type_entity_id',
    //         ':iparam_unit_rate',
    //         ':iparam_active',
    //         ':iparam_facility_ids',
    //         ':iparam_session_id',
    //         ':iparam_user_id',
    //         ':iparam_screen_id',
    //         ':iparam_debug_sproc',
    //         ':iparam_audit_screen_visit',
    //     ];

    //     $oparams = [
    //         '@oparam_err_flag',
    //         '@oparam_err_step',
    //         '@oparam_err_msg'
    //     ];

    //     return $this->runProcedure($model, $procedure, $iparams, $oparams);
    // }

    // public function delete($model)
    // {
    //     $procedure = 'sproc_prd_product_dml_del';

    //     $iparams = [
    //         ':iparam_product_entity_id',
    //         ':iparam_session_id',
    //         ':iparam_user_id',
    //         ':iparam_screen_id',
    //         ':iparam_debug_sproc',
    //         ':iparam_audit_screen_visit',
    //     ];

    //     $oparams = [
    //         '@oparam_err_flag',
    //         '@oparam_err_step',
    //         '@oparam_err_msg'
    //     ];

    //     return $this->runProcedure($model, $procedure, $iparams, $oparams);
    // }
}
