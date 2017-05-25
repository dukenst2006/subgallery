<template>
    <div class="panel panel-default">
        <div class="panel-heading">Resume Subscription <i v-if="load" class="fa fa-spinner fa-pulse fa-fw"></i></div>

        <div class="panel-body">
            <button type="button" class="btn btn-success btn-lg" @click="resume">Resume your Subscription</button>
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
            resume() {
                let vm = this;
                vm.load = true;
                swal({
                    title: 'Are you sure you want to Resume?',
                    text: "This doesn't change your current billing cycle",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, I want more!',
                    cancelButtonText: 'No, I\'m good',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false
                }).then(function () {
                    axios.post('/api/settings/subscription/resume', {
                        id: vm.user_id
                    }).then(() => {
                        vm.load = false;
                        swal(
                            'Great!',
                            'Your subscription has been successfully resumed.',
                            'success'
                        )
                    }).catch(() => {
                        swal(
                            'Oops!',
                            'Your subscription couldn\'t resume, please contact Admin about this issue',
                            'error'
                        )
                    });
                }, function (dismiss) {
                    // dismiss can be 'cancel', 'overlay',
                    // 'close', and 'timer'
                    vm.load = false;
                    if (dismiss === 'cancel') {
                        swal(
                            'Noooo',
                            'We\'d really much like you to stick around',
                            'error'
                        )
                    }
                })
            }
        }
    }
</script>