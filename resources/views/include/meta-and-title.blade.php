<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title><?php
    $title = $__env->yieldContent('title');
    if (!empty($title)) {
        echo $title . ' | ';
    }
    echo Session::get('user.companyName');
?></title>
