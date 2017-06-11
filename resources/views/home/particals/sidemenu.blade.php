<div class="hidden-md hidden-lg horizontal-scroll">
    <nav class="vertical-align">
        <a href="{{ url('home') }}" class="nav-item {{ set_active('home') }}">Home</a>
        @role('admin')
        <a href="{{ url('home/admin/users') }}" class="nav-item {{ set_active('home/admin/users') }}">Users</a>
        <a href="{{ url('home/admin/roles') }}" class="nav-item {{ set_active('home/admin/roles') }}">Roles</a>
        <a href="{{ url('home/admin/permissions') }}" class="nav-item {{ set_active('home/admin/permissions') }}">Permissions</a>
        @endrole
        <a href="{{ url('home/content/galleries') }}" class="nav-item {{ set_active('home/content/galleries') }}">Galleries</a>
        <a href="{{ url('home/content/videos') }}" class="nav-item {{ set_active('home/content/videos') }}">Videos</a>
    </nav>
</div>

<div class="hidden-sm hidden-xs">
    <div class="panel panel-default">
        <div class="list-group">
            <a href="{{ url('home') }}" class="list-group-item {{ set_active('home') }}">Home</a>
        </div>
    </div>

    @role('super-admin')
    <div class="panel panel-default">
        <div class="panel-heading">
            Admin
        </div>
        <div class="list-group">
            <a href="{{ url('home/admin/users') }}" class="list-group-item {{ set_active('home/admin/users') }}">Users</a>
            <a href="{{ url('home/admin/roles') }}" class="list-group-item {{ set_active('home/admin/roles') }}">Roles</a>
            <a href="{{ url('home/admin/permissions') }}" class="list-group-item {{ set_active('home/admin/permissions') }}">Permissions</a>
        </div>
    </div>
    @endrole

    @hasanyrole($roles)
    <div class="panel panel-default">
        <div class="panel-heading">
            Content
        </div>
        <div class="list-group">
            <a href="{{ url('home/content/galleries') }}" class="list-group-item {{ set_active('home/content/galleries') }}">Galleries</a>
            <a href="{{ url('home/content/videos') }}" class="list-group-item {{ set_active('home/content/videos') }}">Videos</a>
        </div>
    </div>
    @endhasanyrole
</div>