@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            @include('settings.particals.sidemenu')
        </div>
        <div class="col-md-9">
            <update-username :user_id="{{ auth()->id() }}"></update-username>
            <update-email :user_id="{{ auth()->id() }}"></update-email>
            <update-password :user_id="{{ auth()->id() }}"></update-password>
        </div>
    </div>
</div>
@endsection
