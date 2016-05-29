<?php

    if (!is_null($currentModule)
        && !is_null($sidebar->{$currentModule})
        && is_string($sidebar->{$currentModule}->id))
    {
        $sidebarItems = $sidebar->whereParent($sidebar->{$currentModule}->id);
    } else {
        $sidebarItems = $sidebar->roots();
    }
?>
<div id="sidebarMenu">
    <div class="list-group panel">
        @include('include.sidebar-menuItem', ['items' => $sidebarItems])
    </div>
</div>
