@if (count($grid->rows()))
    <?php
        $paymentTypes = [];
        foreach ($grid->rows() as $row) {
            if (isset($row['payment_type']) && !in_array($row['payment_type'], $paymentTypes)) {
                $paymentTypes[] = $row['payment_type'];
            }
        }
    ?>
    @if (count($paymentTypes))

        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Payment Type</th>
                    @foreach ($paymentTypes as $paymentType)
                        <td>{{$paymentType}}</td>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>Total Selected Amount</th>
                    @foreach ($paymentTypes as $paymentType)
                        <td class="payment-type" data-paymentType="{{$paymentType}}"></td>
                    @endforeach
                </tr>
            </tbody>
        </table>

    @endif
@endif

<nav class="nav-footer navbar navbar-default">
    <div class="container-fluid">
        <form class="navbar-form navbar-right" id="close-cash-counter-form" action="{{form_action_full()}}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="collection_ids" id="collection_ids" value="">

            <button id="close-cash-counter" type="submit" class="btn btn-primary">Close Cash Counter</button>
        </form>
    </div>
</nav>
