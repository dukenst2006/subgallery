<template>
    <div class="panel panel-default">
        <div class="panel-heading">Username <i v-if="load" class="fa fa-spinner fa-pulse fa-fw"></i></div>

        <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST">
                <div class="form-group" :class="{ 'has-error': errors.has('username') }">
                    <label for="username" class="col-md-4 control-label">Username</label>

                    <div class="col-md-6">
                        <input id="username" type="text" class="form-control" name="username" v-model="username" required autofocus @keydown="errors.clear('username')">

                        <span class="help-block" v-if="errors.has('username')">
                            <strong v-text="errors.get('username')"></strong>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" @click.prevent="updateUsername" class="btn btn-primary" :disabled="errors.any()">
                            Update
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import Errors from '../../classes/Errors';
    export default {
        props: ['user_id'],
        data() {
            return {
                username: '',
                load: false,
                errors: new Errors()
            };
        },
        methods: {
            updateUsername() {
                let vm = this;
                vm.load = true;
                axios.post('/api/settings/account/update/username', {
                    username: vm.username,
                    id: vm.user_id
                }).then(() => {
                    vm.load = false;
                    vm.username = '';
                    swal(
                        'Updated!',
                        'Your username has successfully been updated',
                        'success'
                    );
                }).catch((error) => {
                    vm.load = false;
                    vm.errors.record(error.response.data);
                })
            }
        }
    }
</script>