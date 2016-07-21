
<?php

    $totalAmount = 0;
    // $allRows = $cash->cashCounterRows();
    // if (!is_array($allRows)) {
    //     $allRows = [];
    // }

    // $totalAmount = 0;
    // foreach ($allRows as $row) {
    //     $totalAmount += $row['collection_amount'];
    // }

?>

<div class="form-group">
    <div class="col-md-3 col-md-offset-8">
        <h4 class="text-right">Total Selected Amount:</h4>
    </div>
    <div class="col-md-1">
        <h4 class="text-left">&#x20b9; <span id="selected-total-amount">{{amount($totalAmount)}}</span></h4>
    </div>
</div>
