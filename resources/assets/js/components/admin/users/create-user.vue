<template>
    <div class="modal fade" id="createUserModal" tabindex="-1" role="dialog" aria-labelledby="createUserModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i></button>
                    <h4 class="modal-title" id="myModalLabel">Create User <i v-if="load" class="fa fa-spinner fa-pulse fa-fw"></i></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form class="form-horizontal" role="form" method="POST">
                            <div class="form-group" :class="{ 'has-error': errors.has('username') }">
                                <label for="username" class="col-md-4 control-label">Username</label>

                                <div class="col-md-6">
                                    <input id="username" type="text" class="form-control" name="username" v-model="username" @keydown="errors.clear('username')" autofocus>

                                    <span class="help-block" v-if="errors.has('username')">
                                        <strong v-text="errors.get('username')"></strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group" :class="{ 'has-error': errors.has('email') }">
                                <label for="email" class="col-md-4 control-label">Email</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" v-model="email" @keydown="errors.clear('email')">

                                    <span class="help-block" v-if="errors.has('email')">
                                        <strong v-text="errors.get('email')"></strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group" :class="{ 'has-error': errors.has('roles') }">
                                <label for="role" class="col-md-4 control-label">Select Role</label>

                                <div class="col-md-6">
                                    <select name="role" id="role" v-model="roles" class="form-control">
                                        <option disabled value="">Please select one</option>
                                        <option v-for="role in roles_index" :value="role.id">
                                            {{ role.name }}
                                        </option>
                                    </select>

                                    <span class="help-block" v-if="errors.has('roles')">
                                        <strong v-text="errors.get('roles')"></strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" @click.prevent="createUser" class="btn btn-primary" :disabled="errors.any()">
                                        Create User
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Errors from '../../../classes/Errors';
    export default {
        props: ['roles_index'],
        data() {
            return {
                username: '',
                email: '',
                roles: [],
                load: false,
                errors: new Errors()
            };
        },
        methods: {
            createUser() {
                this.load = true;
                axios.post('/api/home/admin/users/create', {
                    username: this.username,
                    email: this.email,
                    roles: this.roles
                }).then(() => {
                    this.username = '';
                    this.email = '';
                    this.roles = [];
                    bus.$emit('update_user_index');
                    $('#createUserModal').modal( 'hide' );
                    this.load = false;
                }).catch((error) => {
                    this.load = false;
                    this.errors.record(error.response.data);
                    swal(
                        'Oops',
                        'Couldn\'t create new user',
                        'error'
                    );
                })
            }
        }
    }
</script>