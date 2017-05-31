<template>
    <div class="panel panel-default">
        <div class="panel-heading">Create User <i v-if="load" class="fa fa-spinner fa-pulse fa-fw"></i></div>

        <table class="table">
            <tr>
                <td><input type="text" class="form-control" placeholder="Username" v-model="username"></td>
                <td><input type="email" class="form-control" placeholder="Email" v-model="email"></td>
                <td></td>
                <td><select name="role" id="role" v-model="roles">
                    <option disabled value="">Please select one</option>
                    <option v-for="role in roles_index" :value="role.id">{{ role.name }}</option>
                </select></td>
                <td>
                    <button type="button" class="btn btn-success btn-xs" @click="createUser">Create</button>
                </td>
            </tr>
        </table>
    </div>
</template>

<script>
    export default {
        props: ['roles_index'],
        data() {
            return {
                username: '',
                email: '',
                roles: [],
                load: false
            };
        },
        methods: {
            createUser() {
                this.load = true;
                axios.post('/api/home/admin/users/create', {
                    username: this.username,
                    email: this.email,
                    roles: this.roles
                }).then(() => {
                    this.username = '';
                    this.email = '';
                    this.roles = [];
                    bus.$emit('update_user_index');
                    this.load = false;
                }).catch((error) => {
                    console.log(error);
                    swal(
                        'Oops',
                        'Couldn\'t create new user',
                        'error'
                    );
                    this.load = false;
                })
            }
        }
    }
</script>