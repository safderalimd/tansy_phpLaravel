<?php

namespace App\Http\Modules\Organization\Models;

use App\Http\Models\Model;

class QuickUpdate extends Model
{
    protected $screenId = '/cabinet/account---quick-update';

    protected $repositoryNamespace = 'App\Http\Modules\Organization\Repositories\QuickUpdateRepository';

    public $organizationFields;

    public $fieldType;

    public $uiLabel;

    protected $columns = [];

    public $rows = [];

    public $dataType;

    public $dropDownSql;

    public $dropdownOptions;

    public function setFiAttribute($value)
    {
        $this->setAttribute('field_id', $value);
        return $value;
    }

    public function setSiAttribute($value)
    {
        $this->setAttribute('student_filter_entity_id', $value);
        return $value;
    }

    public function setFilters()
    {
        $this->organizationFields = $this->organizationFields();
        $this->setFieldType();
        if ($this->fieldType != 'Student') {
            $this->student_filter_entity_id = null;
        }
    }

    public function loadData()
    {
        $this->setFilters();
        $this->setRows();
        $this->setColumns();
    }

    public function setRows()
    {
        if (is_null($this->field_id)) {
            return;
        }

        $data = $this->repository->grid($this);
        $this->rows = first_resultset($data);
    }

    public function setColumns()
    {
        if (!isset($this->rows[0])) {
            return;
        }

        $columns = [];
        foreach ($this->rows[0] as $key => $value) {
            if (!is_numeric($key) && $key != 'account_entity_id' && $key != 'Field Value') {
                $columns[] = $key;
            }
        }

        $this->columns = $columns;
    }

    public function columns()
    {
        return $this->columns;
    }

    public function setFieldType()
    {
        if (is_null($this->field_id)) {
            return;
        }

        $fields = $this->organizationFields;
        foreach ($fields as $field) {
            if ($field['field_id'] == $this->field_id) {
                $this->fieldType = $field['entity_type'];
                $this->uiLabel = $field['ui_label'];
                $this->dataType = $field['data_type'];
                $this->dropDownSql = $field['drop_down_sql'];
                return;
            }
        }
    }

    public function getDropdownOptions()
    {
        if (!is_null($this->dropdownOptions)) {
            return $this->dropdownOptions;
        }

        $this->dropdownOptions = $this->repository->dropdownOptions($this->dropDownSql);
        return $this->dropdownOptions;
    }
}
