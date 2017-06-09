<template>
    <div class="panel panel-default">
        <div class="panel-heading">Password <i v-if="load" class="fa fa-spinner fa-pulse fa-fw"></i></div>

        <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST">
                <div class="form-group" :class="{ 'has-error': errors.has('old_password') }">
                    <label for="old_password" class="col-md-4 control-label">Old Password</label>

                    <div class="col-md-6">
                        <input id="old_password" type="password" class="form-control" name="old_password" v-model="old_password" required autofocus @keydown="errors.clear('old_password')">

                        <span class="help-block" v-if="errors.has('old_password')">
                            <strong v-text="errors.get('old_password')"></strong>
                        </span>
                    </div>
                </div>

                <div class="form-group" :class="{ 'has-error': errors.has('password') }">
                    <label for="password" class="col-md-4 control-label">New Password</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control" name="password" v-model="password" required autofocus @keydown="errors.clear('password')">

                        <span class="help-block" v-if="errors.has('password')">
                            <strong v-text="errors.get('password')"></strong>
                        </span>
                    </div>
                </div>

                <div class="form-group" :class="{ 'has-error': errors.has('password_confirmation') }">
                    <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" v-model="password_confirmation" required @keydown="errors.clear('password_confirmation')">

                        <span class="help-block" v-if="errors.has('password_confirmation')">
                            <strong v-text="errors.get('password_confirmation')"></strong>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" @click.prevent="updateEmail" class="btn btn-primary" :disabled="errors.any()">
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
                old_password: '',
                password: '',
                password_confirmation: '',
                load: false,
                errors: new Errors()
            };
        },
        methods: {
            updateEmail() {
                let vm = this;
                vm.load = true;
                axios.post('/api/settings/account/update/password', {
                    old_password: vm.old_password,
                    password: vm.password,
                    password_confirmation: vm.password_confirmation,
                    id: vm.user_id
                }).then(() => {
                    vm.load = false;
                    vm.old_password = '';
                    vm.password = '';
                    vm.password_confirmation = '';
                    swal(
                        'Updated!',
                        'Your password has successfully been updated',
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