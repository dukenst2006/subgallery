@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            @include('home.particals.sidemenu')
        </div>
        <div class="col-md-9">
            <index-users></index-users>
        </div>
    </div>
</div>
@endsection
