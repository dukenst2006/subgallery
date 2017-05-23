<template>
    <div class="panel panel-default">
        <div class="panel-heading">Subscription Plan</div>
        <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST">
                <div class="form-group">
                    <label for="plan" class="col-md-4 control-label">Membership Plans</label>

                    <div class="col-md-6">
                        <select name="plan" id="plan" v-model="plan">
                            <option disabled value="">Please select one</option>
                            <option v-for="plan in plans" :value="plan.id">
                                {{ plan.name }}
                            </option>
                        </select>
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
        props: ['user_id', 'sub_plans'],
        data() {
            return {
                plan: 1,
                plans: this.sub_plans,
                load: false,
                errors: new Errors()
            };
        },
        methods: {
            updatePlan() {
                let vm = this;
                vm.load = true;
                axios.post('/api/settings/subscription/update/plan', {
                    plan: vm.plan,
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
                    vm.errors.record(error.response.data)
                })
            }
        }
    }
</script>
