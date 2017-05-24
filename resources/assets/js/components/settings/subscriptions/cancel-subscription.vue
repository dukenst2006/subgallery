<template>
    <div class="panel panel-default">
        <div class="panel-heading">Cancel Subscription <i v-if="load" class="fa fa-spinner fa-pulse fa-fw"></i></div>

        <div class="panel-body">
            <button type="button" class="btn btn-danger btn-lg" @click="cancel">Cancel your Subscription</button>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['user_id'],
        data() {
            return {
                load: false
            };
        },
        methods: {
            cancel() {
                let vm = this;
                vm.load = true;
                swal({
                    title: 'Are you sure you want to Cancel?',
                    text: "This will you can't access this site when your membership expires",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, cancel!',
                    cancelButtonText: 'No, what was I thinking!',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false
                }).then(function () {
                    axios.post('/api/settings/subscription/cancel', {
                        id: vm.user_id
                    }).then(() => {
                        vm.load = false;
                        swal(
                            'Cancelled!',
                            'Your subscription has been successfully cancelled.',
                            'success'
                        )
                    }).catch(() => {
                        swal(
                            'Oops!',
                            'Your subscription couldn\'t cancel, please contact Admin about this issue',
                            'error'
                        )
                    });
                }, function (dismiss) {
                    // dismiss can be 'cancel', 'overlay',
                    // 'close', and 'timer'
                    vm.load = false;
                    if (dismiss === 'cancel') {
                        swal(
                            'Phew!',
                            'You haven\'t cancelled your subscription, glad you\'re sticking around',
                            'error'
                        )
                    }
                })
            }
        }
    }
</script>