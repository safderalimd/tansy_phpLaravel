<?php

namespace App\Http\Modules\System\Models;

use App\Http\Models\Model;

class CustomFields extends Model
{
    protected $screenId = '/cabinet/custom-fields';

    protected $repositoryNamespace = 'App\Http\Modules\System\Repositories\CustomFieldsRepository';

    public function setGsiAttribute($value)
    {
        $this->setAttribute('custom_field_id', $value);
        return $value;
    }

    public function setActiveAttribute($value)
    {
        return $this->checkbox($value);
    }

    public function setMandatoryInputAttribute($value)
    {
        return $this->checkbox($value);
    }

    public function setVisibleInGridAttribute($value)
    {
        return $this->checkbox($value);
    }

    public function setExistingAttribute($value)
    {
        return $this->checkbox($value);
    }

    public function checkbox($value)
    {
        $value = (string)$value;
        if (!empty($value) || $value == 'on') {
            return 1;
        }

        return 0;
    }

    public function rows()
    {
        if (is_null($this->custom_field_id)) {
            return [];
        }

        return $this->repository->getGrid($this->custom_field_id);
    }

    public function saveField()
    {
        $this->setAttributes();
        return $this->repository->insert($this);
    }

    public function updateField()
    {
        $this->setAttributes();
        return $this->repository->update($this);
    }

    public function setAttributes()
    {
        if ($this->existing == 1) {
            $this->setAttribute('custom_field_list', null);
            if ($this->row_type == 'system') {
                $this->setAttribute('map_to_existing_lookup_id', $this->primary_key_id);
            } else {
                $this->setAttribute('map_to_existing_custom_lookup_id', $this->primary_key_id);
            }
        }
    }
}
