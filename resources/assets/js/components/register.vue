<template>
    <div class="panel panel-default">
        <div class="panel-heading">Register</div>
        <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST" action="/register">
                <input type="hidden" name="stripeToken" v-model="stripeToken">
                <input type="hidden" name="stripeEmail" v-model="stripeEmail">
                <div class="form-group">
                    <label for="username" class="col-md-4 control-label">Username</label>

                    <div class="col-md-6">
                        <input id="username" type="text" class="form-control" name="username" v-model="username" required autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control" name="email" v-model="email" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="col-md-4 control-label">Password</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control" name="password" v-model="password" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" v-model="password_confirmation" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="plan" class="col-md-4 control-label">Membership Plan</label>

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
                        <button type="submit" @click.prevent="register" class="btn btn-primary">
                            Register
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
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
                plan: 1
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
                            window.location.href = '/';
                        }).catch((error) => {

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
                    zipCode: true,
                    amount: plan.price
                })
            },

            findPlanById(id) {
                return this.plans.find(plan => plan.id === id);
            }
        }
    }
</script>
