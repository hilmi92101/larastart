<template>
    <div class="container">

        <div class="row mt-5">
           <div class="col-md-12">
              <div class="card">
                 <div class="card-header">
                    <h3 class="card-title">Users Table</h3>

                    <div class="card-tools">
                        <button class="btn btn-success" @click="newModal">
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
                            <a href="#"><i class="fa fa-edit blue" @click="editModal(user)"></i></a>
                            /
                            <a href="#" @click="deleteUser(user)"><i class="fa fa-trash red"></i></a>
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
                    <h5 class="modal-title" id="addNewLabel">
                        {{ editmode ? 'Edit User' : 'Add New' }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                 </div>

                 <form @submit.prevent="editmode ? updateUser() : createUser()">
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
                                <option value="author">Author</option>
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
                        <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                        <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
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
                editmode: false,
                users: {},

                form: new Form({

                    id: '',
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
                    self.users = response.data.data;
                    self.$Progress.finish();
                })
                .catch(function (error) {
                    self.$Progress.fail();
                });
            },

            newModal(){
                this.editmode = false;
                this.form.reset(); // the vform way to reset form
                $('#addNew').modal('show');
            },

            editModal(user){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(user);
            },

            createUser(){
                const self = this;
                this.$Progress.start();
                this.form.post('/api/user')
                .then(function (response) {
                    Fire.$emit('AfterCreated');

                    //console.log(response.data);
                    self.users = response.data.data;
                    $('#addNew').modal('hide');
                    self.resetAddUserModal(self);
                    toast.fire({
                        icon: 'success',
                        title: 'User created successfully'
                    });
                    self.$Progress.finish();
                }).catch(function (error) {
                    self.$Progress.fail();
                });
                    
            },

            updateUser(){
                const self = this;
                this.$Progress.start();
                this.form.put('/api/user/'+ this.form.id)
                .then(function (response) {

                    console.log(response.data);
                    self.users = response.data.users.data;
                    $('#addNew').modal('hide');
                    self.resetAddUserModal(self);
                    toast.fire({
                        icon: 'success',
                        title: 'User updated successfully'
                    });
                    self.$Progress.finish();
                }).catch(function (error) {
                    self.$Progress.fail();
                });
                
            },

            deleteUser(user){

                const self = this;
                swal.fire({
                    title: 'Delete ' + user.name + '?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {

                        //console.log(result);
                        if(result.isConfirmed){
                            self.form.delete('/api/user/'+user.id)
                            .then(function (response) {
                                if(response.data.status){
                                    self.users = response.data.users.data;
                                    swal.fire(
                                        'Deleted!',
                                        'User has been deleted.',
                                        'success'
                                    );
                                }
                            }).catch(function (error) {
                            });
                        }
                });
            },

            resetAddUserModal(self) {
            
                self.form.name = '';
                self.form.email = '';
                self.form.password = '';
                self.form.type = 'admin';
                self.form.bio = '';
                self.form.photo = '';

            },

        },

        created() {
            this.loadUsers();
            Fire.$on('AfterCreated', () => {
                this.loadUsers();

                // REALLY DON'T LIKE DOING IT LIKE THIS. 2 DATABASE CALLS WERE MADE. IT'S BETTER AFTER CREATED USER, RETURN THE LIST OF USER, SO IT WILL BE ONLY ONE DATABASE CALL.

                // MAYBE LATER CAN FIGURE OUT HOW DOING VUE CUSTOM EVENT LIKE THIS IS MORE BENEFICIAL TO THE PROJECT. FOR NOW, DON'T KNOW WHERE TO APPLY THIS IN A MORE MEANINGFUL WAY.
            });
            //setInterval(() => this.loadUsers(), 5000);
        }
    }
</script>
