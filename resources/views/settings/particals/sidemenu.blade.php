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
        <a href="{{ url('settings/subscription/plan') }}" class="list-group-item {{ set_active('settings/subscription/plan') }}">Subscription</a>
        <a href="{{ url('settings/subscription/cancel') }}" class="list-group-item {{ set_active('settings/subscription/cancel') }}">Cancel</a>
        <a href="{{ url('settings/subscription/resume') }}" class="list-group-item {{ set_active('settings/subscription/resume') }}">Resume</a>
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