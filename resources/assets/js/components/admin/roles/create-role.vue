<template>
    <div class="modal fade" id="createRoleModal" tabindex="-1" role="dialog" aria-labelledby="createRoleModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i></button>
                    <h4 class="modal-title" id="myModalLabel">Create Role <i v-if="load" class="fa fa-spinner fa-pulse fa-fw"></i></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form class="form-horizontal" role="form" method="POST">
                            <div class="form-group" :class="{ 'has-error': errors.has('name') }">
                                <label for="name" class="col-md-4 control-label">Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" v-model="name" @keydown="errors.clear('name')">

                                    <span class="help-block" v-if="errors.has('name')">
                                        <strong v-text="errors.get('name')"></strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="role" class="col-md-4 control-label">Select Role</label>

                                <div class="col-md-6">
                                    <div class="checkbox" v-for="permission in permissions">
                                        <input type="checkbox" :id="permission.name" :value="permission.id" v-model="checkedArray">
                                        <label :for="permission.name">{{ permission.name }}</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" @click.prevent="create" class="btn btn-primary" :disabled="errors.any()">
                                        Create Role
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
        props: ['permissions'],
        data() {
            return {
                name: '',
                checkedArray: [],
                load: false,
                errors: new Errors()
            };
        },
        methods: {
            create() {
                this.load = true;
                axios.post('/api/home/admin/roles/create', {
                    name: this.name,
                    permissions: this.checkedArray
                }).then(() => {
                    this.load = false;
                    $('#createRoleModal').modal( 'hide' );
                    bus.$emit('refresh_role_index');
                }).catch((error) => {
                    this.load = false;
                    this.errors.record(error.response.data);
                    swal(
                        'Error',
                        'Couldn\'t create a new Role',
                        'error'
                    );
                })
            }
        }
    }
</script>