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

    public function insert($row)
    {
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
    }
}
