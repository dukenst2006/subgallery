@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-2">
            @include('settings.particals.sidemenu')
        </div>
        <div class="col-md-10">
            <update-username></update-username>
        </div>
    </div>
</div>
@endsection
