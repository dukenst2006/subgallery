<div class="hidden-md hidden-lg horizontal-scroll">
    <nav class="vertical-align">
        <a href="{{ url('settings/account') }}" class="nav-item {{ set_active('settings/account') }}">Account</a>
        <a href="{{ url('settings/subscription/plan') }}" class="nav-item {{ set_active('settings/subscription/plan') }}">Plan</a>
        @if(auth()->user()->subscriptions[0]['ends_at'] === null)
            <a href="{{ url('settings/subscription/cancel') }}" class="nav-item {{ set_active('settings/subscription/cancel') }}">Cancel</a>
        @else
            <a href="{{ url('settings/subscription/resume') }}" class="nav-item {{ set_active('settings/subscription/resume') }}">Resume</a>
        @endif
        <a href="{{ url('settings/billing/invoices') }}" class="nav-item {{ set_active('settings/billing/invoices') }}">Invoices</a>
        <a href="{{ url('settings/billing/card') }}" class="nav-item {{ set_active('settings/billing/card') }}">Card</a>
    </nav>
</div>

<div class="hidden-sm hidden-xs">
    <div class="panel panel-default">
        <div class="list-group">
            <a href="{{ url('settings/account') }}" class="list-group-item {{ set_active('settings/account') }}">Account</a>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            Subscription
        </div>
        <div class="list-group">
            <a href="{{ url('settings/subscription/plan') }}" class="list-group-item {{ set_active('settings/subscription/plan') }}">Plan</a>
            @if(auth()->user()->subscriptions[0]['ends_at'] === null)
                <a href="{{ url('settings/subscription/cancel') }}" class="list-group-item {{ set_active('settings/subscription/cancel') }}">Cancel</a>
            @else
                <a href="{{ url('settings/subscription/resume') }}" class="list-group-item {{ set_active('settings/subscription/resume') }}">Resume</a>
            @endif
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            Billing
        </div>
        <div class="list-group">
            <a href="{{ url('settings/billing/invoices') }}" class="list-group-item {{ set_active('settings/billing/invoices') }}">Invoices</a>
            <a href="{{ url('settings/billing/card') }}" class="list-group-item {{ set_active('settings/billing/card') }}">Card</a>
        </div>
    </div>
</div>