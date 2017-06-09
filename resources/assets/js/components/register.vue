<template>
    <div class="panel panel-default">
        <div class="panel-heading">Register</div>
        <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST" action="/register">
                <input type="hidden" name="stripeToken" v-model="stripeToken">
                <input type="hidden" name="stripeEmail" v-model="stripeEmail">
                <div class="form-group" :class="{ 'has-error': errors.has('username') }">
                    <label for="username" class="col-md-4 control-label">Username</label>

                    <div class="col-md-6">
                        <input id="username" type="text" class="form-control" name="username" v-model="username" required autofocus @keydown="errors.clear('username')">

                        <span class="help-block" v-if="errors.has('username')">
                            <strong v-text="errors.get('username')"></strong>
                        </span>
                    </div>
                </div>

                <div class="form-group" :class="{ 'has-error': errors.has('email') }">
                    <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control" name="email" v-model="email" required @keydown="errors.clear('email')">

                        <span class="help-block" v-if="errors.has('email')">
                            <strong v-text="errors.get('email')"></strong>
                        </span>
                    </div>
                </div>

                <div class="form-group" :class="{ 'has-error': errors.has('password') }">
                    <label for="password" class="col-md-4 control-label">Password</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control" name="password" v-model="password" required @keydown="errors.clear('password')">

                        <span class="help-block" v-if="errors.has('password')">
                            <strong v-text="errors.get('password')"></strong>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" v-model="password_confirmation" required @keydown="errors.clear('password')">
                    </div>
                </div>

                <div class="form-group">
                    <label for="plan" class="col-md-4 control-label">Membership Plan</label>

                    <div class="col-md-6">
                        <select name="plan" id="plan" v-model="plan" class="form-control">
                            <option disabled value="">Please select one</option>
                            <option v-for="plan in plans" :value="plan.id">
                                {{ plan.name }}
                            </option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" @click.prevent="register" class="btn btn-primary" :disabled="errors.any()">
                            Register
                        </button>
                    </div>
                </div>
                <div class="form-group" v-if="errors.has('status')">
                    <div class="col-md-6 col-md-offset-4">
                        <div class="alert alert-danger">
                            <p v-text="errors.get('status')"></p>
                            <p>Please <a href="/login">Login</a> and update your card details to activate your account.</p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import Errors from '../classes/Errors';
    export default {
        props: ['plans'],
        data() {
            return {
                username: '',
                email: '',
                password: '',
                password_confirmation: '',
                stripeEmail: '',
                stripeToken: '',
                plan: 1,
                errors: new Errors()
            };
        },
        created() {
            this.stripe = StripeCheckout.configure({
                key: SubGallery.stripeKey,
                image: "https://stripe.com/img/documentation/checkout/marketplace.png",
                locale: "auto",
                panelLabel: "Subscribe For",
                token: (token) => {
                    $.LoadingOverlay("show");
                    this.stripeToken = token.id;
                    this.stripeEmail = token.email;

                    axios.post('/register', this.$data)
                        .then((response) => {
                            window.location.href = '/home';
                        }).catch((error) => {
                            $.LoadingOverlay('hide');
                            this.errors.record(error.response.data)
                        })
                }
            });
        },
        methods: {
            register() {
                let plan = this.findPlanById(this.plan);

                this.stripe.open({
                    name: plan.name,
                    description: plan.description,
                    locale: "auto",
                    zipCode: true,
                    amount: plan.price,
                    billingAddress: true
                })
            },

            findPlanById(id) {
                return this.plans.find(plan => plan.id === id);
            }
        }
    }
</script>
