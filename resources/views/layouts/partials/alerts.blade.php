@if ($message = Session::get('success'))
    <div class="alert alert-success" role="alert">
        <p> {{ $message }} </p>
    </div>
@elseif ($message = Session::get('danger'))
    <div class="alert alert-danger" role="alert">
        <p> {{ $message }} </p>
    </div>
@endif
