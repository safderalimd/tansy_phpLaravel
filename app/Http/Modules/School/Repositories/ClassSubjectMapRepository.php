<?php

namespace App\Http\Modules\School\Repositories;

use App\Http\Repositories\Repository;

class ClassSubjectMapRepository extends Repository
{
    public function getModelById($id)
    {
        return $this->db()->select(
            'SELECT class_name, subject, mapped, class_entity_id, subject_entity_id
             FROM view_sch_class2subject_grid
             WHERE subject_entity_id = :id
             LIMIT 1;', ['id' => $id]
        );
    }

    public function map($model)
    {
        return $this->mapOrDelete($model, 1);
    }

    public function delete($model)
    {
        return $this->mapOrDelete($model, 0);
    }

    public function mapOrDelete($model, $mappingFlag)
    {
        $db = $this->db()->getPdo();

        $call = $db->prepare('
            call sproc_sch_class2subject_dml (
                :iparam_class_entity_id,
                :iparam_subject_entity_id,
                :iparam_mapping_flag,
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

        $call->bindValue(':iparam_class_entity_id', $model->class_entity_id);
        $call->bindValue(':iparam_subject_entity_id', $model->subject_entity_id);
        $call->bindValue(':iparam_mapping_flag', $mappingFlag);
        $call->bindValue(':iparam_session_id', $model->session_id);
        $call->bindValue(':iparam_user_id', $model->user_id);
        $call->bindValue(':iparam_screen_id', $model->screen_id);
        $call->bindValue(':iparam_debug_sproc', $model->debug_sproc);
        $call->bindValue(':iparam_audit_screen_visit', $model->audit_screen_visit);

        $call->execute();

        $response = $db
            ->query('SELECT @oparam_err_flag, @oparam_err_step, @oparam_err_msg')
            ->fetch(\PDO::FETCH_ASSOC);

        if ($response['@oparam_err_flag'] == null) {
            return true;
        }

        $model->errors = $response['@oparam_err_msg'];
        return false;
    }
}
