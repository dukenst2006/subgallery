@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            @include('admin.particals.sidemenu')
        </div>
        <div class="col-md-9">
            <index-permissions></index-permissions>
        </div>
    </div>
</div>
@endsection
