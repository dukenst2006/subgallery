<template>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading">
                Role <i v-if="load" class="fa fa-spinner fa-pulse fa-fw"></i>
                <button class="btn btn-success btn-xs pull-right" @click="create"><i class="fa fa-plus" aria-hidden="true"></i></button>
            </div>

            <table class="table table-hover">
                <thead>
                <tr>
                    <td>Role</td>
                    <td>Permissions</td>
                    <td></td>
                </tr>
                </thead>
                <tbody>
                <tr v-for="role in roles">
                    <td>{{ role.name }}</td>
                    <td>
                        <span v-for="permission in role.permissions">{{ permission.name }}, </span>
                    </td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-info btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Actions <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="#" @click.prevent="select(role)">Edit</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="#" @click.prevent="destroy(role.id)">Delete</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <vue-pagination  :pagination="pagination"
                         @click.native="getUsers(pagination.current_page)"
                         :offset="4">
        </vue-pagination>

        <create-role-modal :permissions="permissions"></create-role-modal>
        <edit-role-modal :role="selected" :permissions="permissions"></edit-role-modal>
    </div>
</template>

<script>
    import CreateRole from './create-role.vue';
    import EditRole from './edit-role.vue';
    export default {
        data() {
            return {
                roles: [],
                permissions: [],
                selected: {},
                counter: 0,
                pagination: {
                    total: 0,
                    per_page: 2,
                    from: 1,
                    to: 0,
                    current_page: 1
                },
                offset: 4,
                load: false
            };
        },
        components: {
            'create-role-modal': CreateRole,
            'edit-role-modal': EditRole
        },
        created() {
            bus.$on('refresh_role_index', this.getRoles);
            this.getRoles();
        },
        methods: {
            getRoles() {
                this.load = true;
                axios.get('/api/home/admin/roles/get?page=' + this.pagination.current_page).then((response) => {
                    this.permissions = response.data.permissions;
                    this.roles = response.data.roles.data;
                    this.pagination = response.data.roles;
                    this.load = false;
                }).catch((error) => {
                    swal(
                        'Oops',
                        'Couldn\'t load the list of roles',
                        'error'
                    );
                    this.load = false;
                })
            },
            select(role) {
                this.selected = role;
                $('#editRoleModal').modal( 'show' );
            },
            create() {
                $('#createRoleModal').modal( 'show' );
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
                    axios.delete('/api/home/admin/roles/delete/' + id).then(() => {
                        swal(
                            'Deleted!',
                            'Your role has been deleted.',
                            'success'
                        );
                        bus.$emit('refresh_role_index');
                        this.load = false;
                    }).catch((error) => {
                        swal(
                            'Oops',
                            'Couldn\'t delete Role',
                            'error'
                        );
                        this.load = false;
                    });
                })
            }
        }
    }
</script>