@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            @include('settings.particals.sidemenu')
        </div>
        <div class="col-md-9">
            <update-subscription-plan :user_id="{{ auth()->id() }}" :sub_plans="{{ $plans }}" :user_plan="{{ $user_plan }}"></update-subscription-plan>
        </div>
    </div>
</div>
@endsection
