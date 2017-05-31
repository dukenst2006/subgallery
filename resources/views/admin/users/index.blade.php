@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            @include('admin.particals.sidemenu')
        </div>
        <div class="col-md-9">
            <index-users></index-users>
            <create-user :roles_index="{{ $roles }}"></create-user>
        </div>
    </div>
</div>
@endsection
