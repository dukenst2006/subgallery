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
                        <a href="" class="btn btn-primary btn-xs">Display</a>
                        <div class="btn-group">
                            <button type="button" class="btn btn-info btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Actions <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="#">Login as User</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="#">Cancel Subscription</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                users: [],
                load: false
            };
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
            moment(date) {
                return moment(date).format('Do MMM YYYY, HH:mm');
            }
        }
    }
</script>