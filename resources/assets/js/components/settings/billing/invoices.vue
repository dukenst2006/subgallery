<template>
    <div class="panel panel-default">
        <div class="panel-heading">Your Payment History <i v-if="load" class="fa fa-spinner fa-pulse fa-fw"></i></div>

        <table class="table table-hover">
            <thead>
                <tr>
                    <td>Date</td>
                    <td>Total</td>
                    <td><i class="fa fa-cloud-download" aria-hidden="true"></i></td>
                </tr>
            </thead>
            <tbody>
                <tr v-for="invoice in invoices">
                    <td>{{ invoice.date }}</td>
                    <td>${{ invoice.total }}</td>
                    <td><a :href="invoice.download">Download</a></td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        props: ['user_id'],
        data() {
            return {
                invoices: [],
                load: false
            };
        },
        created() {
            this.getInvoices();
        },
        methods: {
            getInvoices() {
                let vm = this;
                vm.load = true;
                axios.get('/api/settings/billing/invoices/get', {
                    params: {
                        id: vm.user_id
                    }
                }).then((response) => {
                    vm.load = false;
                    vm.invoices = response.data.invoices;
                }).catch((error) => {
                    vm.load = false;
                    swal(
                        'Oops',
                        'There was an error loading your invoices, please notify the admin',
                        'error'
                    )
                })
            }
        }
    }
</script>