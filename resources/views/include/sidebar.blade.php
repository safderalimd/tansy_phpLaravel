<?php
    $sidebarItems = $sidebar->whereParent($sidebar->{$currentModule}->id);
?>
<div id="sidebarMenu">
    <div class="list-group panel">
        @include('include.sidebar-menuItem', ['items' => $sidebarItems])
    </div>
</div>
