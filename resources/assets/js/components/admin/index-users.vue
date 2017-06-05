<template>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading">Users <i v-if="load" class="fa fa-spinner fa-pulse fa-fw"></i></div>

            <table class="table table-hover">
                <thead>
                <tr>
                    <td>Username</td>
                    <td>Email</td>
                    <td>Date/Time Added</td>
                    <td>User Roles</td>
                    <td></td>
                </tr>
                </thead>
                <tbody>
                <tr v-for="user in users">
                    <td>{{ user.username }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ moment(user.created_at) }}</td>
                    <td>{{ user.roles[0].name }}</td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-info btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Actions <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="#" @click.prevent="select(user)">View User</a></li>
                                <li><a href="#">Login as User</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="#">Warn User</a></li>
                                <li><a href="#">Cancel Subscription</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <view-user-modal :user="selected"></view-user-modal>
    </div>
</template>

<script>
    import ViewUser from './view-user.vue';
    export default {
        data() {
            return {
                users: [],
                selected: {},
                load: false
            };
        },
        components: {
            'view-user-modal': ViewUser
        },
        created() {
            bus.$on('update_user_index', this.getUsers);
            this.getUsers();
        },
        methods: {
            getUsers() {
                let vm = this;
                vm.load = true;
                axios.get('/api/home/admin/users/get').then((response) => {
                    vm.users = response.data.users;
                    vm.load = false;
                }).catch((error) => {
                    swal(
                        'Oops',
                        'Couldn\'t load a list of users',
                        'error'
                    );
                    vm.load = false;
                })
            },
            select(user) {
                $('#viewUserModal').modal( 'show' );
                this.selected = user
            },
            moment(date) {
                return moment(date).format('Do MMM YYYY, HH:mm');
            }
        }
    }
</script>