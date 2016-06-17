<?php

namespace App\Http\Repositories;

use App\Http\Models\Model;
use App\Exceptions\DbErrorException;

class Procedure
{
    protected $model;

    protected $procedure;

    protected $iparams;

    protected $oparams;

    protected $repository;

    protected $pdo;

    protected $resultSets;

    protected $oparamsResults;

    protected $procedureSql;

    protected $oparamsSelect;

    protected $start;

    protected $setParamsSql = '';

    public function __construct(Repository $repository, Model $model, $procedure, $iparams = [], $oparams = [])
    {
        $this->repository = $repository;
        $this->model      = $model;
        $this->procedure  = $procedure;
        $this->iparams    = $this->normalize($iparams);
        $this->oparams    = $this->normalize($oparams);
        $this->rawIparams = $iparams;

        $this->pdo = $this->repository->db()->getPdo();
    }

    public function run()
    {
        $this->start = microtime(true);

        $this->runSetIparamsQuery();

        $this->runCallProcedure();

        $this->runSelectOparams();

        $this->model->setProcedureOparams($this->oparamsResults);

        $this->logProcedure();

        $this->checkErrors();

        return $this->resultSets;
    }

    protected function runSetIparamsQuery()
    {
        foreach ($this->rawIparams as $iparam) {
            $value = $this->getModelProperty($iparam);
            $normalizedIparam = $this->normalizeIparam($iparam);
            $this->pdo->query("set {$normalizedIparam} = {$value};");
            $this->setParamsSql .= "set {$normalizedIparam} = {$value};" . PHP_EOL;
        }
    }

    protected function runCallProcedure()
    {
        $this->procedureSql = $this->generateProcedureSql();
        $stmt = $this->pdo->query($this->procedureSql);

        $resultSets = [];
        do {
            $rows = $stmt->fetchAll();
            $resultSets[] = $rows;
        } while ($stmt->nextRowset());

        $this->resultSets = $resultSets;
    }

    protected function runSelectOparams()
    {
        $this->oparamsSelect = $this->generateOparamsSelect();
        $stmt = $this->pdo->query($this->oparamsSelect);

        $oparamsResults = [];
        do {
            $rows = $stmt->fetchAll();
            if ($rows) {
                $oparamsResults = array_merge($oparamsResults, $rows);
            }
        } while ($stmt->nextRowset());

        if (isset($oparamsResults[0])) {
            $oparamsResults = $oparamsResults[0];
        }

        $this->oparamsResults = $oparamsResults;
    }

    protected function checkErrors()
    {
        if (!isset($this->oparamsResults['@oparam_err_flag'])) {
            return;
        }

        if ($this->oparamsResults['@oparam_err_flag'] != null) {
            throw new DbErrorException($this->oparamsResults['@oparam_err_msg']);
        }
    }

    protected function logProcedure()
    {
        $query = $this->setParamsSql . "\n\n" . $this->procedureSql . "\n\n" . $this->oparamsSelect . ';';

        foreach ($this->oparamsResults as $oparam => $value) {
            if (!is_numeric($oparam)) {
                $query .= "\n\n" . $oparam . ' = ' . $value;
            }
        }

        $time = $this->getElapsedTime($this->start);
        $bindings = [];

        $this->repository->db()->logQuery($query, $bindings, $time);
    }

    /**
     * Iparams are converted to a type:
     * ':' are converted to int
     * '+' are converted to floats
     * '-' are escaped string values
     */
    protected function getModelProperty($iparam)
    {
        $modelProperty = substr($iparam, 8);
        $value = $this->model->{$modelProperty};

        // send null to sproc if value is null
        if ($value === null) {
            return 'null';
        }

        // if the parameters is from a selectbox, convert 'none' value to null
        if ($this->model->isSelectNoneOption($modelProperty)) {
            return 'null';
        }

        // if the type is integer convert it to integer
        if ($this->isTypeInteger($iparam)) {
            return intval($value);
        }

        // if the type is float convert it to float
        if ($this->isTypeFloat($iparam)) {
            return floatval($value);
        }

        // remove extra spaces
        if (is_string($value)) {
            $value = trim($value);
        }

        // convert empty strings to spaces
        if ($value === '') {
            return 'null';
        }

        return $this->pdo->quote($value);
    }

    public function isTypeInteger($iparam)
    {
        return ':' === substr($iparam, 0, 1);
    }

    public function isTypeFloat($iparam)
    {
        return '+' === substr($iparam, 0, 1);
    }

    protected function generateOparamsSelect()
    {
        return 'SELECT ' . implode(', ', $this->oparams);
    }

    protected function generateProcedureSql()
    {
        $params = array_merge($this->iparams, $this->oparams);

        $params = implode(', ', $params);

        return "call {$this->procedure} ({$params});";
    }

    protected function normalize($params)
    {
        return array_map(function($param) {
            return '@' . substr($param, 1);
        }, $params);
    }

    public function normalizeIparam($iparam)
    {
        return '@' . substr($iparam, 1);
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
