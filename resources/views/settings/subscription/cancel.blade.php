@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-2">
            @include('settings.particals.sidemenu')
        </div>
        <div class="col-md-10">
            <div class="panel panel-default">
                <div class="panel-heading">Cancel your Subscription</div>

                <div class="panel-body">
                    This is where you will cancel your subscription
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
