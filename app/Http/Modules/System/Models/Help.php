<?php

namespace App\Http\Modules\System\Models;

use App\Http\Models\Model;

class Help extends Model
{
    protected $screenId = '/cabinet/help';

    protected $repositoryNamespace = 'App\Http\Modules\System\Repositories\HelpRepository';

    protected $text;

    protected $images;

    protected $videos;

    public function loadData()
    {
        $this->setAttribute('filter_type' , 'All screens');
        $this->setAttribute('filter_id' , 0);
        $data = $this->repository->helpText($this);
        $this->text = first_resultset($data);
        $this->images = second_resultset($data);
        $this->videos = third_resultset($data);

        foreach ($this->text as &$row) {
            $row['images'] = [];
            $row['videos'] = [];

            foreach ($this->images as $image) {
                if ($row['screen_id'] == $image['screen_id']) {
                    $row['images'][] = $image;
                }
            }
            foreach ($this->videos as $video) {
                if ($row['screen_id'] == $video['screen_id']) {
                    $row['videos'][] = $video;
                }
            }
        }
        unset($row);
    }

    public function text()
    {
        return $this->text;
    }

    public function screenName($name)
    {
        $poz = strpos($name, '(');
        $screen = substr($name, 0, $poz);
        $module = substr($name, $poz);
        return '<h3 class="help-screen-name">' . $screen . '</h3> ' . $module;
    }
}
