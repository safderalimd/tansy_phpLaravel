@extends('layout.cabinet')

@section('title', 'Close Cash Counter')

@section('content')

<?php

    $allRows = $cash->cashCounterRows();
    if (!is_array($allRows)) {
        $allRows = [];
    }

    $totalAmount = 0;
    foreach ($allRows as $row) {
        $totalAmount += $row['collection_amount'];
    }

?>

<div class="panel-group sch_class">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-th-list"></i>
            <h3>Close Cash Counter</h3>
        </div>
        <div class="panel-body">

            @include('commons.errors')

            <div class="form-group">
                <div class="col-md-3 col-md-offset-8">
                    <h4 class="text-right">Total Selected Amount:</h4>
                </div>
                <div class="col-md-1">
                    <h4 class="text-left">&#x20b9; <span id="selected-total-amount">{{amount($totalAmount)}}</span></h4>
                </div>
            </div>

            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Date <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>Collection Amount <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th class="text-center"><input type="checkbox" checked="checked" id="toggle-subjects" name="toggle-checkbox" value=""></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($allRows as $row)
                        <tr>
                            <td>{{style_date($row['calendar_date'])}}</td>
                            <td>&#x20b9; {{amount($row['collection_amount'])}}</td>
                            <td class="text-center">
                                <input type="checkbox" checked="checked" class="cache-row-id" name="cache_row_id" value="{{$row['collection_amount']}}" data-dateid="{{$row['date_id']}}">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <nav class="nav-footer navbar navbar-default">
                <div class="container-fluid">
                    <form class="navbar-form navbar-right" id="close-cash-counter-form" action="{{form_action_full()}}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="collection_ids" id="collection_ids" value="">

                        <button id="close-cash-counter" type="submit" class="btn btn-primary">Close Cash Counter</button>
                    </form>
                </div>
            </nav>

            @include('commons.modal')
        </div>
    </div>
</div>

@endsection


@section('scripts')
<script type="text/javascript">

    $('#toggle-subjects').change(function() {
        if($(this).is(":checked")) {
            $('.cache-row-id').prop('checked', true);
        } else {
            $('.cache-row-id').prop('checked', false);
        }
        updateTotalAmount();
    });

    $('.cache-row-id').change(function() {
        updateTotalAmount();
    });

    function updateTotalAmount() {
        var totalAmount = 0;

        $('.cache-row-id:checked').each(function () {
            totalAmount += parseFloat(this.value);
        });

        $('#selected-total-amount').text(addCommas(totalAmount));
    }

    // format numbers
    function addCommas(nStr) {
        nStr += '';
        var x = nStr.split('.');
        var x1 = x[0];
        var x2 = x.length > 1 ? '.' + x[1] : '.00';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }

    $('#close-cash-counter-form').submit(function() {

        var collectionIds = $('.cache-row-id:checked').map(function() {
            return $(this).attr('data-dateid') + '-' + this.value;
        }).get();

        if (collectionIds.length == 0) {
            alert("No rows are selected.");
            return false;
        }

        $('#collection_ids').val(collectionIds.join(','));

        return true;
    });

</script>
@endsection
