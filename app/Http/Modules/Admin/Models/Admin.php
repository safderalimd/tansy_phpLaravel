<?php

namespace App\Http\Modules\Admin\Models;

use App\Http\Models\Model;

class Admin extends Model
{
    protected $screenId = '/cabinet/home';

    protected $repositoryNamespace = 'App\Http\Modules\Admin\Repositories\AdminRepository';

    protected $homeData;

    public $boxes;

    public function loadData()
    {
        $this->homeData = $this->repository->homeDisplay($this);

        $this->boxes = $this->resultset(1);
        $this->sortBoxes();

        $this->displayType = $this->getDisplayType();

        foreach ($this->boxes as &$box) {
            if ($box['value'] == 'N/A') {
                $box['display_value'] = $this->valueFromResultset($box['value_from_result_set']);
            } else {
                $box['display_value'] = $box['value'];
            }
        }
        // clear reference
        unset($box);
    }

    public function boxLabel($nr)
    {
        if (isset($this->boxes[$nr]['label'])) {
            return $this->boxes[$nr]['label'];
        }
        return '-';
    }

    public function symbol($nr)
    {
        if (!isset($this->boxes[$nr]['value_data_type'])) {
            return '';
        }

        if ($this->boxes[$nr]['value_data_type'] == 'MONEY') {
            return '<i class="fa fa-inr"></i>';
        }

        return '';
    }

    public function boxRawValue($nr)
    {
        if (isset($this->boxes[$nr]['display_value'])) {
            return $this->boxes[$nr]['display_value'];
        }
        return '-';
    }

    public function boxLink($nr)
    {
        if (isset($this->boxes[$nr]['display_value'])) {
            $value = $this->boxes[$nr]['display_value'];
            $value = ltrim($value);
            $value = ltrim($value, '/\\');
            return '/' . $value;
        }
        return '/';
    }

    public function boxValue($nr)
    {
        if (isset($this->boxes[$nr]['display_value'])) {
            $value = $this->boxes[$nr]['display_value'];
            $format = $this->boxes[$nr]['value_data_type'];
            if ($format == 'INT') {
                return nr($value);
            } elseif ($format == 'MONEY') {
                return amount($value);
            } elseif ($format == 'DATE') {
                return style_date($value);
            } else {
                return $value;
            }
        }
        return '-';
    }

    public function valueFromResultset($nr)
    {
        $nr = intval($nr);
        $set = $this->resultset($nr);
        if (isset($set[0][0])) {
            return $set[0][0];
        }
        return '';
    }

    public function getDisplayType()
    {
        if (isset($this->boxes[0]['display_type'])) {
            $type = $this->boxes[0]['display_type'];
            $type = trim($type);
            $type = strtoupper($type);
            return $type;
        }
        return null;
    }

    public function sortBoxes()
    {
        usort($this->boxes, function($a, $b) {
            return $a['position'] > $b['position'];
        });
    }

    public function resultset($nr)
    {
        $nr = intval($nr);

        // 0 index based
        $nr = $nr - 1;

        if (isset($this->homeData[$nr])) {
            return $this->homeData[$nr];
        }
        return [];
    }
}
