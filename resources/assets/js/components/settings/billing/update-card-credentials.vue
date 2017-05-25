<template>
    <div class="panel panel-default">
        <div class="panel-heading">Card</div>
        <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST">
                <input type="hidden" name="stripeToken" v-model="stripeToken">
                <input type="hidden" name="stripeEmail" v-model="stripeEmail">

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" @click.prevent="updateCardCredentials" class="btn btn-primary" :disabled="errors.any()">
                            Click here to update your card details
                        </button>
                    </div>
                </div>
                <div class="form-group" v-if="errors.has('status')">
                    <div class="col-md-6 col-md-offset-4">
                        <div class="alert alert-danger">
                            <p v-text="errors.get('status')"></p>
                            <!--<p>Please <a href="/login">Login</a> and update your card details to activate your account.</p>-->
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import Errors from '../../../classes/Errors';
    export default {
        props: ['user_id'],
        data() {
            return {
                stripeEmail: '',
                stripeToken: '',
                errors: new Errors()
            };
        },
        created() {
            this.stripe = StripeCheckout.configure({
                key: SubGallery.stripeKey,
                image: "https://stripe.com/img/documentation/checkout/marketplace.png",
                locale: "auto",
                panelLabel: "Update Card Details",
                token: (token) => {
                    $.LoadingOverlay("show");
                    this.stripeToken = token.id;
                    this.stripeEmail = token.email;

                    axios.post('/api/settings/billing/update/card', {
                        stripeEmail: this.stripeEmail,
                        stripeToken: this.stripeToken,
                        id: this.user_id
                    }).then((response) => {
                            window.location.href = '/settings/billing/card';
                        }).catch((error) => {
                            $.LoadingOverlay('hide');
                            this.errors.record(error.response.data)
                        })
                }
            });
        },
        methods: {
            updateCardCredentials() {
                this.stripe.open({
                    name: 'SubGallery',
                    description: 'Update your card details',
                    locale: "auto",
                    zipCode: true
                })
            }
        }
    }
</script>
