<template>
    <div class="container">

        <div class="row mt-5">
           <div class="col-md-12">
              <div class="card">
                 <div class="card-header">
                    <h3 class="card-title">Users Table</h3>

                    <div class="card-tools">
                        <button class="btn btn-success" data-toggle="modal" data-target="#addNew">
                            Add New
                            <i class="fas fa-user-plus fa-fw"></i>
                        </button>
                    </div>
                    
                 </div>
                 <!-- /.card-header -->
                 <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Type</th>
                                <th>Register At</th>
                                <th>Modify</th>
                            </tr>
                        </thead>
                    <tbody>
                    
                    <tr v-for="(user, index) in users" :key="user.id">
                        <td>{{ user.id }}</td>
                        <td>{{ user.name }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.type | upText }}</td>
                        <td>{{ user.created_at | myDate }}</td>
                        <td>
                            <a href="#"><i class="fa fa-edit blue"></i></a>
                            /
                            <a href="#"><i class="fa fa-trash red"></i></a>
                        </td>
                    </tr>

                    </tbody>
                    </table>
                 </div>
                 <!-- /.card-body -->
              </div>
              <!-- /.card -->
           </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
           <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                 <div class="modal-header">
                    <h5 class="modal-title" id="addNewLabel">Add New</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                 </div>

                 <form @submit.prevent="createUser">
                     <div class="modal-body">

                        <!-- Name -->
                        <div class="form-group">
                            <input 
                                v-model="form.name" 
                                type="text" 
                                name="name"
                                class="form-control" 
                                :class="{ 'is-invalid': form.errors.has('name') }"
                                placeholder="Name" 
                            >
                            <has-error :form="form" field="name"></has-error>
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <input 
                                v-model="form.email" 
                                type="text" 
                                name="email"
                                class="form-control" 
                                :class="{ 'is-invalid': form.errors.has('email') }"
                                placeholder="Email" 
                            >
                            <has-error :form="form" field="email"></has-error>
                        </div>

                        <!-- Bio -->
                        <div class="form-group">
                            <textarea
                                v-model="form.bio" 
                                name="bio"
                                class="form-control" 
                                :class="{ 'is-invalid': form.errors.has('bio') }"
                                placeholder="Short bio for user (Optional)" 
                            >
                            </textarea> 
                            <has-error :form="form" field="bio"></has-error>
                        </div>

                        <!-- Type -->
                        <div class="form-group">
                            <select
                                v-model="form.type" 
                                name="type"
                                class="form-control" 
                                :class="{ 'is-invalid': form.errors.has('type') }"
                            >
                                <option value="admin">Admin</option>
                                <option value="user">Standard User</option>
                                <option value="admin">Author</option>
                            </select> 
                            <has-error :form="form" field="type"></has-error>
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <input 
                                v-model="form.password" 
                                type="password" 
                                name="password"
                                class="form-control" 
                                :class="{ 'is-invalid': form.errors.has('password') }"
                                placeholder="Password" 
                            >
                            <has-error :form="form" field="password"></has-error>
                        </div>


                     </div>

                     <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create</button>
                     </div>
                 </form>
              </div>
           </div>
        </div>



    </div>
</template>

<script>
    export default {

        data() {

            return {
                users: {},

                form: new Form({

                    name: '',
                    email: '',
                    password: '',
                    type: 'admin',
                    bio: '',
                    photo: '',
                }),
            }

        }, 

        methods: {

            loadUsers(){
                const self = this;
                axios.get('/api/user')
                .then(function (response) {
                    //console.log(response.data);
                    //console.log(response.data.data);
                    self.users = response.data.data
                })
                .catch(function (error) {
                });
            },

            createUser(){

                this.form.post('/api/user');
                this.loadUsers();
                    
            },

        },

        created() {
            this.loadUsers();
        }
    }
</script>
