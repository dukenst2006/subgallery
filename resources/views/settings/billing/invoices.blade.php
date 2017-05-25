@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            @include('settings.particals.sidemenu')
        </div>
        <div class="col-md-9">
            <invoices :user_id="{{ auth()->id() }}"></invoices>
        </div>
    </div>
</div>
@endsection
