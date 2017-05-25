<template>
    <div class="panel panel-default">
        <div class="panel-heading">Your Payment History</div>

        <!--<div class="panel-body">-->
            <!--This is where your payment history will go-->
        <!--</div>-->

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
                    <td><a :href="'/settings/billing/invoice/' + invoice.id">Download</a></td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        props: ['invoices'],
        data() {
            return {
                hello: 'world'
            };
        }
    }
</script>