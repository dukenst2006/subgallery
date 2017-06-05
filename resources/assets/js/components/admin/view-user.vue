<template>
    <div class="modal fade" id="viewUserModal" tabindex="-1" role="dialog" aria-labelledby="viewUserModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i></button>
                    <h4 class="modal-title" id="myModalLabel">View User <i v-if="load" class="fa fa-spinner fa-pulse fa-fw"></i></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form class="form-horizontal" role="form" method="POST">
                            <div class="form-group" :class="{ 'has-error': errors.has('username') }">
                                <label for="username" class="col-md-4 control-label">Username</label>

                                <div class="col-md-6">
                                    <input id="username" type="text" class="form-control" name="username" v-model="viewUser.username" @keydown="errors.clear('username')">
                                </div>

                                <span class="help-block" v-if="errors.has('username')">
                                    <strong v-text="errors.get('username')"></strong>
                                </span>
                            </div>

                            <div class="form-group" :class="{ 'has-error': errors.has('email') }">
                                <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" v-model="viewUser.email" @keydown="errors.clear('email')">
                                </div>

                                <span class="help-block" v-if="errors.has('email')">
                                    <strong v-text="errors.get('email')"></strong>
                                </span>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" @click.prevent="update" class="btn btn-primary" :disabled="errors.any()">
                                        Update User
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Likes</h3>
                                </div>
                                <div class="panel-body">
                                    Panel content
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Comments</h3>
                                </div>
                                <div class="panel-body">
                                    Panel content
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Total Tips</h3>
                                </div>
                                <div class="panel-body">
                                    Panel content
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Errors from '../../classes/Errors';
    export default {
        props: ['user'],
        data() {
            return {
                load: false,
                errors: new Errors()
            };
        },
        computed: {
            viewUser() {
                let viewUser = this.user;
                viewUser.date = moment(this.user.date).format('YYYY-MM-DDThh:mm');
                return viewUser
            }
        },
        methods: {
            update() {
                this.load = true;
                axios.post('/api/home/admin/users/update', {
                    id: this.viewUser.id,
                    username: this.viewUser.username,
                    email: this.viewUser.email,
                    roles: this.viewUser.roles[0].id
                }).then(() => {
                    this.load = false;
                    $('#viewUserModal').modal( 'hide' );
                    eventBus.$emit('refresh_user_index');
                }).catch((error) => {
                    this.load = false;
                    this.errors.record(error.response.data);
                    swal(
                        'Approval Error',
                        'Couldn\'t approve that request',
                        'error'
                    );
                })
            }
        }
    }
</script>