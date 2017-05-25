<template>
    <div class="panel panel-default">
        <div class="panel-heading">Email <i v-if="load" class="fa fa-spinner fa-pulse fa-fw"></i></div>

        <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST">
                <div class="form-group" :class="{ 'has-error': errors.has('email') }">
                    <label for="email" class="col-md-4 control-label">Email</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control" name="email" v-model="email" required autofocus @keydown="errors.clear('email')">
                    </div>

                    <span class="help-block" v-if="errors.has('email')">
                        <strong v-text="errors.get('email')"></strong>
                    </span>
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
                email: '',
                load: false,
                errors: new Errors()
            };
        },
        methods: {
            updateEmail() {
                let vm = this;
                vm.load = true;
                axios.post('/api/settings/account/update/email', {
                    email: vm.email,
                    id: vm.user_id
                }).then(() => {
                    vm.load = false;
                    vm.email = '';
                    swal(
                        'Updated!',
                        'Your email address has successfully been updated',
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