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
                $model->setAttribute($oparam, $response[$oparam]);
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
}
