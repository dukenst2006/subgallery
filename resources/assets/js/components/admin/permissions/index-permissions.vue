<template>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading">
                Permissions <i v-if="load" class="fa fa-spinner fa-pulse fa-fw"></i>
                <button class="btn btn-success btn-xs pull-right" @click="create"><i class="fa fa-plus" aria-hidden="true"></i></button>
            </div>

            <table class="table table-hover">
                <thead>
                <tr>
                    <td>Name</td>
                    <td></td>
                </tr>
                </thead>
                <tbody>
                <tr v-for="permission in permissions">
                    <td>{{ permission.name }}</td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-info btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Actions <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="#" @click.prevent="select(permission)">Edit</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="#" @click.prevent="destroy(permission.id)">Delete</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <create-permission-modal :roles="roles"></create-permission-modal>
        <edit-permission-modal :permission="selected"></edit-permission-modal>
    </div>
</template>

<script>
    import CreatePermission from './create-permission.vue';
    import EditPermission from './edit-permission.vue';
    export default {
        data() {
            return {
                permissions: [],
                roles: [],
                selected: {},
                load: false
            };
        },
        components: {
            'create-permission-modal': CreatePermission,
            'edit-permission-modal': EditPermission
        },
        created() {
            bus.$on('refresh_permission_index', this.getPermissions);
            this.getPermissions();
        },
        methods: {
            getPermissions() {
                this.load = true;
                axios.get('/api/home/admin/permissions/get').then((response) => {
                    this.permissions = response.data.permissions;
                    this.roles = response.data.roles;
                    this.load = false;
                }).catch((error) => {
                    swal(
                        'Oops',
                        'Couldn\'t load the list of permissions',
                        'error'
                    );
                    this.load = false;
                })
            },
            select(permission) {
                $('#editPermissionModal').modal( 'show' );
                this.selected = permission
            },
            create() {
                $('#createPermissionModal').modal( 'show' );
            },
            destroy(id) {
                swal({
                    title: 'Are you sure you want to delete?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then(() => {
                    this.load = true;
                    this.getPermissions();
                    axios.delete('/api/home/admin/permissions/delete/' + id).then(() => {
                        swal(
                            'Deleted!',
                            'Your permission has been deleted.',
                            'success'
                        );
                        this.load = false;
                    }).catch((error) => {
                        swal(
                            'Oops',
                            'Couldn\'t delete Permission',
                            'error'
                        );
                        this.load = false;
                    });
                })
            }
        }
    }
</script>