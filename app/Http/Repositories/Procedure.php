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
        foreach ($this->iparams as $iparam) {
            $value = $this->getModelProperty($iparam);
            $this->pdo->query("set {$iparam} = {$value};");
            $this->setParamsSql .= "set {$iparam} = {$value};" . PHP_EOL;
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

    protected function getModelProperty($iparam)
    {
        $modelProperty = substr($iparam, 8);

        if ($this->model->{$modelProperty} === null) {
            return 'null';
        }

        return $this->pdo->quote($this->model->{$modelProperty});
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
