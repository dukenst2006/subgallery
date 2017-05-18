@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-2">
            @include('settings.particals.sidemenu')
        </div>
        <update-username></update-username>
    </div>
</div>
@endsection
