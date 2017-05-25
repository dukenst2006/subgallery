@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            @include('settings.particals.sidemenu')
        </div>
        <div class="col-md-9">
            <update-card-credentials :user_id="{{ auth()->id() }}"></update-card-credentials>
        </div>
    </div>
</div>
@endsection
