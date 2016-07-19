<?php

namespace App\Http\Grid;

class Params
{
    protected $params;

    protected $procedure = '';

    protected $iparams = [];

    protected $oparams = [];

    protected $defaultIparams = [
        ':iparam_session_id',
        ':iparam_user_id',
        ':iparam_screen_id',
        ':iparam_debug_sproc',
        ':iparam_audit_screen_visit',
    ];

    protected $defaultOparams = [
        '@oparam_err_flag',
        '@oparam_err_step',
        '@oparam_err_msg',
    ];

    public function __construct($params)
    {
        $this->params = $params;

        foreach ($this->params as $param) {
            if (isset($param['sproc_name'])) {
                $this->procedure = $param['sproc_name'];
            }

            if (!isset($param['parameter_name']) || !isset($param['input_output_flag'])) {
                continue;
            }

            if ($param['input_output_flag'] == 'I') {
                $this->iparams[] = '-' . $param['parameter_name'];
            }

            if ($param['input_output_flag'] == 'O') {
                $this->oparams[] = '@' . $param['parameter_name'];
            }
        }

        $this->iparams = array_merge($this->iparams, $this->defaultIparams);
        $this->oparams = array_merge($this->oparams, $this->defaultOparams);
    }

    public function procedure()
    {
        return $this->procedure;
    }

    public function iparams()
    {
        return $this->iparams;
    }

    public function oparams()
    {
        return $this->oparams;
    }
}
