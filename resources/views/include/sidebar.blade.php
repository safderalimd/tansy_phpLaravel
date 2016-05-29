<?php
    if (isset($sidebar->{$currentModule}->id)) {
        $sidebarItems = $sidebar->whereParent($sidebar->{$currentModule}->id);
    } else {
        $sidebarItems = $sidebar->whereParent();
    }
?>
<div id="sidebarMenu">
    <div class="list-group panel">
        @include('include.sidebar-menuItem', ['items' => $sidebarItems])
    </div>
</div>
