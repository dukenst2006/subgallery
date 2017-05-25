@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            @include('settings.particals.sidemenu')
        </div>
        <div class="col-md-9">
            <invoices invoices="{{ $invoices }}"></invoices>
        </div>
    </div>
</div>
@endsection
