@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            @include('settings.particals.sidemenu')
        </div>
        <div class="col-md-9">
            <cancel-subscription :user_id="{{ auth()->id() }}"></cancel-subscription>
        </div>
    </div>
</div>
@endsection
