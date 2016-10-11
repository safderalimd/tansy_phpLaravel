<?php

namespace App\Http\Modules\loaddata\School\Repositories;

use App\Http\Repositories\Repository;
use App\Http\Models\Model;

class StudentDataRepository extends Repository
{
    public function getColumnMapping()
    {
        $model = new Model;
        $model->setAttribute('table_name', 'sch_admission');

        $procedure = 'sproc_sys_external_load_column_mapping';

        $iparams = [
            '-iparam_table_name',
        ];

        $oparams = [];

        $data = $this->procedure($model, $procedure, $iparams, $oparams);
        return first_resultset($data);
    }

    public function uploadComplete($model)
    {
        $procedure = 'sproc_sch_sync_admission_drop_down_data';

        $iparams = [
            ':iparam_session_id',
            ':iparam_user_id',
            ':iparam_screen_id',
            ':iparam_debug_sproc',
            ':iparam_audit_screen_visit',
        ];

        $oparams = [
            '@oparam_err_flag',
            '@oparam_err_step',
            '@oparam_err_msg',
        ];

        return $this->procedure($model, $procedure, $iparams, $oparams);
    }

    public function insert($row)
    {
        $start = microtime(true);

        $pdo = $this->db()->getPdo();

        // get the table columns
        $keys = array_keys($row);
        $columns = implode(', ', $keys);

        // get the table column bindings
        $bindings = array_map(function($value) {
            return ':' . $value;
        }, $keys);
        $bindings = implode(', ', $bindings);

        // create the sql
        $sql = "INSERT INTO sch_admission ({$columns}) VALUES ({$bindings})";

        // insert row
        $stmt = $pdo->prepare($sql);
        foreach ($row as $key => $value) {
            $param = (string) $value;
            $stmt->bindValue(':' . $key, $param);
        }

        $stmt->execute();

        $time = $this->getElapsedTime($start);
        $this->db()->logQuery($sql, $row, $time);
    }


    /**
     * Get the elapsed time since a given starting point.
     *
     * @param  int    $start
     * @return float
     */
    protected function getElapsedTime($start)
    {
        return round((microtime(true) - $start) * 1000, 2);
    }
}
