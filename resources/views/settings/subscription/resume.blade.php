@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-2">
            @include('settings.particals.sidemenu')
        </div>
        <div class="col-md-10">
            <div class="panel panel-default">
                <div class="panel-heading">Resume your Subscription</div>

                <div class="panel-body">
                    This is where you resume your subscription, which shall only appear if you cancel but still have time left on your subscription.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
