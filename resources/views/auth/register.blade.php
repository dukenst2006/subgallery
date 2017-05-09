@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <register></register>
        </div>
    </div>
</div>

<script src="https://checkout.stripe.com/checkout.js"></script>
@endsection
