<template>
    <div class="modal fade" id="editRoleModal" tabindex="-1" role="dialog" aria-labelledby="editRoleModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i></button>
                    <h4 class="modal-title" id="myModalLabel">Update Role <i v-if="load" class="fa fa-spinner fa-pulse fa-fw"></i></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form class="form-horizontal" role="form" method="POST">
                            <div class="form-group" :class="{ 'has-error': errors.has('name') }">
                                <label for="name" class="col-md-4 control-label">Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" v-model="role.name" @keydown="errors.clear('name')">

                                    <span class="help-block" v-if="errors.has('name')">
                                        <strong v-text="errors.get('name')"></strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group" :class="{ 'has-error': errors.has('permissions') }">
                                <label for="role" class="col-md-4 control-label">Select Permissions</label>

                                <div class="col-md-6">
                                    <div class="checkbox" v-for="permission in permissions">
                                        <label>
                                            <input type="checkbox" :id="permission.name" :value="permission.id" v-model="checkedArray" @click="errors.clear('permissions')"> {{ permission.name }}
                                        </label>
                                    </div>

                                    <span class="help-block" v-if="errors.has('permissions')">
                                        <strong v-text="errors.get('permissions')"></strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" @click.prevent="update" class="btn btn-primary" :disabled="errors.any()">
                                        Update Role
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
        props: ['role', 'permissions'],
        data() {
            return {
                checkedArray: [],
                load: false,
                errors: new Errors()
            };
        },
        watch: {
            role() {
                let permissions = this.role.permissions;
                this.checkedArray = [];
                permissions.forEach((permission) => {
                    this.checkedArray.push(permission.id);
                });
                this.$forceUpdate();
            }
        },
        methods: {
            update() {
                this.load = true;
                axios.post('/api/home/admin/roles/update', {
                    id: this.role.id,
                    name: this.role.name,
                    permissions: this.checkedArray
                }).then(() => {
                    this.load = false;
                    $('#editRoleModal').modal( 'hide' );
                    bus.$emit('refresh_role_index');
                }).catch((error) => {
                    this.load = false;
                    this.errors.record(error.response.data);
                    swal(
                        'Update Error',
                        'Couldn\'t update the Role',
                        'error'
                    );
                })
            }
        }
    }
</script>