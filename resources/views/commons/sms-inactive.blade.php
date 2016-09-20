@if (! SMS::transactional()->isActive())
    <div class="alert alert-danger">
        <ul>
            <li>{{ SMS::transactional()->inactiveMessage() }}</li>
        </ul>
    </div>
@endif


