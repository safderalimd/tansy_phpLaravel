<?php

namespace App\Http\Models;

use App\Http\Models\Model;
use App\Http\Grid\Header;
use App\Http\Grid\Filter;
use App\Http\Grid\Settings;
use App\Http\Grid\Params;

class Grid extends Model
{
    protected $screenId = null;

    protected $repositoryNamespace = 'App\Http\Repositories\GridRepository';

    protected $header;

    protected $rows;

    protected $params;

    public $screenName;

    public $filters;

    public $settings;

    public $schoolName = '-';

    public $schoolWorkPhone = '-';

    public function __construct($screenId)
    {
        $this->screenId = $screenId;
        parent::__construct();
    }

    public function loadData()
    {
        $this->loadFilters();

        $returnRows = true;

        // set the filters to load grid data
        foreach ($this->filters as $filter) {
            $filterId = 'f' . $filter->id();
            if (isset($this->{$filterId}) && !is_null($this->{$filterId})) {
                $this->setAttribute('data_type_filter' . $filter->id(), $filter->get('data_type'));
                $this->setAttribute('db_column_filter' . $filter->id(), $filter->get('db_column'));
                $this->setAttribute('input_value_filter' . $filter->id(), $this->{$filterId});
                $this->setAttribute('sql_operator_filter' . $filter->id(), $filter->get('sql_operator'));
                $this->setAttribute('drop_down_pk_filter' . $filter->id(), $filter->get('drop_down_pk'));
                $this->setAttribute('drop_down_parent_filter' . $filter->id(), $filter->get('drop_down_parent'));
            } else {
                // only return rows if all filters are set; allow default_facility_id filter to not be set
                if ($filter->get('db_column') != 'iparam_default_facility_id') {
                    $returnRows = false;
                }
            }
        }

        $gridData = $this->repository->dynamicGrid($this->params, $this);
        $this->header = new Header(first_resultset($gridData));
        $this->settings = new Settings(second_resultset($gridData));
        if ($returnRows) {
            $this->rows = third_resultset($gridData);
        } else {
            $this->rows = [];
        }

        $this->screenName = $this->getScreenName();
    }

    public function setSchoolNameAndPhone()
    {
        $name = $this->repository->getSchoolName();
        if (isset($name[0]) && isset($name[0]['organization_name'])) {
            $this->schoolName = $name[0]['organization_name'];
        }
        if (isset($name[0]) && isset($name[0]['work_phone'])) {
            $this->schoolWorkPhone = $name[0]['work_phone'];
        }
    }

    public function columns()
    {
        return $this->header->columns();
    }

    public function buttons()
    {
        return $this->header->buttons();
    }

    public function rows()
    {
        return $this->rows;
    }

    public function emptyRows()
    {
        $this->rows = [];
    }

    public function getScreenName()
    {
        $name = screen_name($this->screenId);
        if ($this->settings->showPdf()) {
            $name = str_replace('PDF - ', '', $name);
        }
        return $name;
    }

    public function loadFilters()
    {
        $data = $this->repository->gridFilters($this);
        $this->filters = Filter::make(first_resultset($data));

        $this->params = new Params(second_resultset($data));
    }
}
