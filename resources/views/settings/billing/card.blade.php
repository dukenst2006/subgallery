@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-2">
            @include('settings.particals.sidemenu')
        </div>
        <div class="col-md-10">
            <div class="panel panel-default">
                <div class="panel-heading">Your Card</div>

                <div class="panel-body">
                    This is where you need to update your card details
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
