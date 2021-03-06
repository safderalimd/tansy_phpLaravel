<?php

namespace App\Http\Grid;

class Settings
{
    protected $settings;

    protected $hasInsertButton = false;

    protected $showSearchBox = false;

    protected $showPdf = false;

    protected $showPdfRowNumbers = false;

    public function __construct($settings)
    {
        $this->settings = $settings;
        foreach ($this->settings as $option) {
            if (!isset($option['ui_label']) || !isset($option['user_visible']) || $option['user_visible'] == 0) {
                continue;
            }

            if ($option['ui_label'] == 'add_new_button') {
                $this->hasInsertButton = true;
            }

            if ($option['ui_label'] == 'show_search_box') {
                $this->showSearchBox = true;
            }

            if ($option['ui_label'] == 'show_pdf') {
                $this->showPdf = true;
            }

            if ($option['ui_label'] == 'pdf_row_number') {
                $this->showPdfRowNumbers = true;
            }
        }
    }

    public function showSearchBox()
    {
        return $this->showSearchBox;
    }

    public function hasInsertButton()
    {
        return $this->hasInsertButton;
    }

    public function showPdf()
    {
        return $this->showPdf;
    }

    public function showPdfRowNumbers()
    {
        return $this->showPdfRowNumbers;
    }
}
