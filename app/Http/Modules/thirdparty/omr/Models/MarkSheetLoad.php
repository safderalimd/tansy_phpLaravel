<?php

namespace App\Http\Modules\thirdparty\omr\Models;

use App\Http\Models\Model;

class MarkSheetLoad extends Model
{
    protected $screenId = '/cabinet/mark-sheet---load';

    protected $repositoryNamespace = 'App\Http\Modules\thirdparty\omr\Repositories\MarkSheetLoadRepository';
}
