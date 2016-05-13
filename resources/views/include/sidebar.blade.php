<?php
    $tab = session('cabinet.tab');
    try {
        $sItems = $sidebar->whereParent($sidebar->$tab->id);
    } catch (Exception $e) {
        $sItems = $sidebar->whereParent($sidebar->first()->id);
    }
?>
<div id="sidebarMenu">
    <div class="list-group panel">
        @include('include.sidebar-menuItem', array('items' => $sItems))
    </div>
</div>
