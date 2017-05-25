<template>
    <div class="panel panel-default">
        <div class="panel-heading">Subscription Plan</div>
        <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST">
                <div class="form-group">
                    <label for="plan" class="col-md-4 control-label">Membership Plans <i v-if="load" class="fa fa-spinner fa-pulse fa-fw"></i></label>

                    <div class="col-md-6">
                        <select name="plan" id="plan" v-model="plan">
                            <option disabled value="">Please select one</option>
                            <option v-for="plan in plans" :value="plan.name">
                                {{ plan.name }}
                            </option>
                        </select>
                    </div>
                </div>

                <div class="form-group" v-if="errors.has('status')">
                    <div class="col-md-6 col-md-offset-4">
                        <div class="alert alert-danger">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close" @click="errors.clear('status')"><i class="fa fa-close"></i></a>
                            <p v-text="errors.get('status')"></p>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" @click.prevent="updatePlan" class="btn btn-primary" :disabled="errors.any()">
                            Update you subscription plan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import Errors from '../../../classes/Errors';
    export default {
        props: ['user_id', 'sub_plans', 'user_plan'],
        data() {
            return {
                plan: this.user_plan.stripe_plan,
                plans: this.sub_plans,
                load: false,
                errors: new Errors()
            };
        },
        methods: {
            updatePlan() {
                let vm = this;
                vm.load = true;
                axios.post('/api/settings/subscription/update', {
                    plan: vm.plan,
                    id: vm.user_id
                }).then(() => {
                    vm.load = false;
                    vm.email = '';
                    swal(
                        'Updated!',
                        'Your subscription plan has successfully been updated',
                        'success'
                    );
                }).catch((error) => {
                    vm.load = false;
                    vm.errors.record(error.response.data)
                })
            }
        }
    }
</script>
