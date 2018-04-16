<template>
    <div class="container ">

        <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#create-item" >

            Ajouter collaborateur <i class="fa fa-plus" aria-hidden="true"></i></button>

            <div class="alert alert-success collapse alert-dismissible" id="managerAdd">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                Manager ajouté avec succès!
            </div>

        <div class="alert alert-success collapse alert-dismissible" id="userAdd">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            Utilisateur ajouté avec succès!
        </div>


        <div class="alert alert-success collapse alert-dismissible" id="userEdit">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            Collaborateur modifié avec succès!
        </div>

        <div class="alert alert-success collapse alert-dismissible" id="userDelete">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            Collaborateur supprimé avec succès!
        </div>

          <table class="table table-stripped table-bordered">
            <thead>
            <tr>
                <th scope="col">Photo</th>
                <th scope="col">Nom et Prénom</th>
                <th scope="col">Date de naissance</th>
                <th scope="col">Email</th>
                <th scope="col">Téléphone</th>
                <th scope="col">Adresse</th>
                <th scope="col">Post</th>
                <th scope="col">Service</th>
                <th scope="col">Manager</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="collaborateur in collaborateurs">
                <td><img style="display:block;" width="80" height="80"  :src="collaborateur.image"/></td>
                <td>{{collaborateur.fullName}}</td>
                <td>{{collaborateur.date_naissance}}</td>
                <td>{{collaborateur.email}}</td>
                <td>{{collaborateur.telephone}}</td>
                <td>{{collaborateur.adresse}}</td>
                <td>{{collaborateur.post}}</td>
                <td>{{ collaborateur.service.nom }}</td>
                <td>{{ collaborateur.manager == null ? '': collaborateur.manager.nom +" "+collaborateur.manager.prenom }}</td>


                <td style='white-space: nowrap'>
                    <button type="button" class="btn btn-warning" @click.prevent="editCollaborateur( collaborateur, collaborateur.service, collaborateur.manager )" ><i class="fa fa-pencil" aria-hidden="true"></i></button>
                    <button type="button" class="btn btn-danger" @click.prevent="deleteCollaborateur( collaborateur )"><i class="fa fa-trash" aria-hidden="true"></i></button>
                </td>
            </tr>
            </tbody>
          </table>







        <!--   <div v-for="collaborateur in collaborateurs" class="col-lg-4">

               <div class="card mb-3">
                   <img class="card-img-top" :src="'http://localhost:8000/'+collaborateur.image" alt="Card image cap">
                   <div class="card-body">
                       <h4 class="card-title">{{ collaborateur.nom }} {{collaborateur.prenom}}</h4>
                       <p class="card-text"> <strong> Email </strong> : {{ collaborateur.email }}</p>
                       <p class="card-text"> <strong> Tel </strong>: {{ collaborateur.telephone }}</p>
                       <p class="card-text"> <strong> Post </strong> : {{ collaborateur.post }}</p>
                       <p class="card-text"> <strong> Adresse </strong>: {{ collaborateur.adresse }}</p>
                       <p class="card-text"> <strong> Date de naissance </strong>: {{ collaborateur.date_naissance }}</p>
                       <p class="card-text"> <strong> Service  </strong>: {{ collaborateur.service.id }}</p>
                       <p class="card-text"> <strong> service </strong>: {{ collaborateur.service.nom }}</p>


                       <button type="button" class="btn btn-primary" @click.prevent="editCollaborateur( collaborateur )" ><i class="fa fa-pencil" aria-hidden="true"></i></button>
                       <button type="button" class="btn btn-danger" @click.prevent="deleteCollaborateur( collaborateur )"><i class="fa fa-trash" aria-hidden="true"></i></button>
                   </div>

               </div>
           </div> -->



            <!-- Create Collab Modal -->
            <div class="modal fade" id="create-item" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"> Ajouter collaborateur </h5>
                            <button type="button" @click="ajouterBtn" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                        <form id= "myForm" method="post" enctype="multipart/form-data" @submit.prevent="createCollaborateur">

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Image: </label><span class="required">*</span>
                                        <div class="image-preview" v-if="newItem.image.length > 0">
                                            <img id="preview" class="preview" :src="newItem.image">
                                        </div>
                                        <input required type="file" @change="imageChangedOnCreate"  class="form-control">
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Nom: </label> <span class="required">*</span>
                                        <input name= "nom" type="text" v-validate= "'required|alpha_spaces'" :class="{'input': true, 'is-danger': errors.has('nom') }" class="form-control" v-model="newItem.nom">
                                        <i v-show="errors.has('nom')" class="fa fa-warning"></i>
                                        <span v-show="errors.has('nom')" class="" style="color: red">{{ errors.first('nom') }}</span>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Prenom: </label> <span class="required">*</span>
                                        <input name= "prenom" type="text" v-validate= "'required|alpha_spaces'" :class="{'input': true, 'is-danger': errors.has('prenom') }" class="form-control" v-model="newItem.prenom">
                                        <i v-show="errors.has('prenom')" class="fa fa-warning"></i>
                                        <span v-show="errors.has('prenom')" class="" style="color: red">{{ errors.first('prenom') }}</span>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Adresse: </label> <span class="required">*</span>
                                        <input name= "adresse" type="text" v-validate= "'required'" :class="{'input': true, 'is-danger': errors.has('adresse') }" class="form-control" v-model="newItem.adresse">
                                        <i v-show="errors.has('adresse')" class="fa fa-warning"></i>
                                        <span v-show="errors.has('adresse')" class="" style="color: red">{{ errors.first('adresse') }}</span>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                            <label>Post: </label> <span class="required">*</span>
                                            <input name= "post" type="text" v-validate= "'required|alpha_spaces'" :class="{'input': true, 'is-danger': errors.has('post') }" class="form-control" v-model="newItem.post">
                                            <i v-show="errors.has('post')" class="fa fa-warning"></i>
                                            <span v-show="errors.has('post')" class="" style="color: red">{{ errors.first('post') }}</span>
                                        </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label >Email: <span class="required">*</span> </label>
                                       <input name= "email" v-model="newItem.email" required  v-validate="'required|email'" :class="{'input': true, 'is-danger': errors.has('email') }" class="form-control" >
                                        <span v-show="errors.has('email')" style="color: red" class="text-danger">{{ errors.first('email') }}</span>

                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Telephone: <span class="required">*</span> </label>
                                        <input name="telephone" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('telephone') }" type="text" class="form-control" v-model="newItem.telephone">
                                        <i v-show="errors.has('telephone')" class="fa fa-warning"></i>
                                        <span v-show="errors.has('telephone')" class="" style="color: red">{{ errors.first('telephone') }}</span>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Date de naissance: <span class="required">*</span> </label>
                                        <input name= "date" type="date"  :class="{'input': true, 'is-danger': errors.has('date') }" v-validate="'required|date_format:YYYY-MM-DD'" placeholder="Choisissez une date"  class="form-control" v-model="newItem.date_naissance">
                                        <i v-show="errors.has('date')" class="fa fa-warning"></i>
                                        <span v-show="errors.has('date')" class="" style="color: red">{{ errors.first('date') }}</span>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <label>Service: </label> <span class="required">*</span>
                                    <select class="form-control" v-model="newItem.service">
                                    <option v-for="service in services"
                                            :value="service">
                                        {{service.nom}} </option>
                                </select>

                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">

                                        <span> Etes-vous un manager?</span>
                                        <input type="radio" name="radio" v-model="newItem.is_manager"  value="1">
                                        <label> Oui </label>
                                        <input type="radio" name="radio" v-model="newItem.is_manager" @click="showManagerDefault()" value="0">
                                        <label> Non </label>
                                        <br>
                                    </div>
                                    <div class="col-lg-12" v-if="newItem.is_manager == '0'">
                                        <label>Choisissez votre manager: </label>
                                        <select class="form-control" v-model="newItem.manager">
                                            <option selected="selected" disabled="true"> --Please Select -- </option>
                                            <option v-for="manager in managers" :value="manager">
                                                {{manager.fullName}} </option>
                                        </select>

                                    </div>

                                </div>
                         <!-- thisone-->

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>

            <!-- Edit Collab Modal -->
            <div class="modal fade" id="edit-item" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"> Modifier collaborateur </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="post" enctype="multipart/form-data" @submit.prevent="updateCollaborateur(fillItem.id)">
                            <input type="hidden" name="_method" value="PUT">
                            <div class="modal-body">

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Image: </label><span class="required">*</span>
                                        <div class="image-preview" v-if="fillItem.image.length > 0">
                                            <img class="preview" :src="fillItem.image">
                                        </div>
                                        <input type="file" @change="imageChangedOnUpdate"  class="form-control">
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Nom: </label> <span class="required">*</span>
                                        <input name= "nom" type="text" v-validate= "'required|alpha_spaces'" :class="{'input': true, 'is-danger': errors.has('nom') }" class="form-control" v-model="fillItem.nom">
                                        <i v-show="errors.has('nom')" class="fa fa-warning"></i>
                                        <span v-show="errors.has('nom')" class="" style="color: red">{{ errors.first('nom') }}</span>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Prenom: </label> <span class="required">*</span>
                                        <input name= "prenom" type="text" v-validate= "'required|alpha_spaces'" :class="{'input': true, 'is-danger': errors.has('prenom') }" class="form-control" v-model="fillItem.prenom">
                                        <i v-show="errors.has('prenom')" class="fa fa-warning"></i>
                                        <span v-show="errors.has('prenom')" class="" style="color: red">{{ errors.first('prenom') }}</span>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Adresse: </label> <span class="required">*</span>
                                        <input name= "adresse" type="text" v-validate= "'required'" :class="{'input': true, 'is-danger': errors.has('adresse') }" class="form-control" v-model="fillItem.adresse">
                                        <i v-show="errors.has('adresse')" class="fa fa-warning"></i>
                                        <span v-show="errors.has('adresse')" class="" style="color: red">{{ errors.first('adresse') }}</span>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Post: </label> <span class="required">*</span>
                                        <input name= "post" type="text" v-validate= "'required|alpha_spaces'" :class="{'input': true, 'is-danger': errors.has('post') }" class="form-control" v-model="fillItem.post">
                                        <i v-show="errors.has('post')" class="fa fa-warning"></i>
                                        <span v-show="errors.has('post')" class="" style="color: red">{{ errors.first('post') }}</span>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label >Email: <span class="required">*</span> </label>
                                        <input name= "email" v-model="fillItem.email" required  v-validate="'required|email'" :class="{'input': true, 'is-danger': errors.has('email') }" class="form-control" >
                                        <span v-show="errors.has('email')" style="color: red" class="text-danger">{{ errors.first('email') }}</span>

                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Telephone: <span class="required">*</span> </label>
                                        <input name="telephone" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('telephone') }" type="text" class="form-control" v-model="fillItem.telephone">
                                        <i v-show="errors.has('telephone')" class="fa fa-warning"></i>
                                        <span v-show="errors.has('telephone')" class="" style="color: red">{{ errors.first('telephone') }}</span>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Date de naissance: <span class="required">*</span> </label>
                                        <input type="date"  :class="{'input': true, 'is-danger': errors.has('date') }" v-validate="'required|date_format:YYYY-MM-DD'" placeholder="Choisissez une date"  class="form-control" v-model="fillItem.date_naissance">
                                        <i v-show="errors.has('date')" class="fa fa-warning"></i>
                                        <span v-show="errors.has('date')" class="" style="color: red">{{ errors.first('date') }}</span>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <label>Service: </label> <span class="required">*</span>
                                    <select class="form-control" v-model="fillItem.service">
                                        <option v-for="service in services" :value="service" >
                                            {{service.nom}} </option>
                                    </select>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <span> Etes-vous un manager?</span>
                                        <input type="radio" name="radio" v-model="fillItem.is_manager" value="1">
                                        <label> Oui </label>
                                        <input type="radio" name="radio" v-model="fillItem.is_manager" value="0">
                                        <label> Non </label>
                                        <br>
                                    </div>
                                    <div class="col-lg-12" v-if="fillItem.is_manager == '0'">
                                        <label>Choisissez votre manager: </label>
                                        <select class="form-control" v-model="fillItem.manager">
                                            <option v-for="manager in managers" :value="manager">
                                                {{manager.nom}} {{manager.prenom}} </option>
                                        </select>
                                    </div>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

</template>

<script>
    import VuePaginator from 'vuejs-paginator'

    export default {

        data(){

            return {

                newItem: { 'nom': '', 'prenom': '', 'image': '', 'post': '', 'date_naissance': '', 'email':'', 'telephone': '', 'adresse': '', 'image': '', 'service_id':'', 'is_manager':'', 'manager_id':'', 'service':{}, 'manager': {}},
                fillItem: { 'nom': '', 'prenom': '', 'image': '', 'post': '', 'date_naissance': '', 'email':'', 'telephone': '', 'adresse': '' , 'image': '', 'service_id': '', 'is_manager':'', 'manager_id':'', 'service':{}, 'manager':{},'id': ''},
                collaborateurs: [],
                resource_url: 'vue-collaborateurs',
                options: {
                    previous_button_text: "Précedent",
                    next_button_text: "Suivant"
                }

            }
        },
        components: {
            VPaginator: VuePaginator
        },
        props: ['services', 'managers'],

        mounted() {
            this.getCollaborateurs();
            this.newItem.service = this.services[0];
        },


        methods: {

            getCollaborateurs() {
                axios.get('vue-collaborateurs').then( response => {
                    this.collaborateurs = response.data;

                })
            },
            updateResource(data){
                this.collaborateurs = data
            },

            showManagerDefault(){
                if(this.newItem.is_manager == "0") {
                    console.log("hello");
                    newItem.manager = this.managers[0];
                } else {
                    this.newItem.manager = {};
                }


            },
            ajouterBtn() {
                $('#create-item').on('show.bs.modal', function(){
                    $(this).find('form')[0].reset();
                    console.log("ajouter btn click");
                });
            },

            createCollaborateur(){
                let input = this.newItem;

                input.service_id = input.service.id;
                input.manager_id = input.manager.id;


                axios.post( 'vue-collaborateurs', input ).then( response => {
                    if(input.is_manager == "1") {
                        this.managers.push(response.data);
                        $('#managerAdd').show();
                    }
                    this.collaborateurs.push(response.data);
                    //this.newItem = { 'nom': '', 'prenom': '', 'image': '', 'post': '', 'date_naissance': '', 'email':'', 'telephone': '', 'adresse': '', 'image': '', 'service_id':'', 'is_manager':'', 'manager_id':'', 'service':{}, 'manager': {}};
                    $('#create-item').modal('hide');

                    $('#create-item').on('hidden.bs.modal', function(){
                        $(this).find('form')[0].reset();
                    });
                    $('#preview').hide();

                    this.getCollaborateurs();
                    $('#userAdd').show();

                }).catch( (error) => {
                    console.log("helloError");
                    console.log(error);
                })

            },
            editCollaborateur(collaborateur, service, manager) {
                let edit = this.fillItem;


                edit.nom = collaborateur.nom;
                edit.id = collaborateur.id;
                edit.prenom = collaborateur.prenom;
                edit.adresse = collaborateur.adresse;
                edit.post = collaborateur.post;
                edit.image = collaborateur.image;
                edit.email = collaborateur.email;
                edit.telephone = collaborateur.telephone;
                edit.date_naissance = collaborateur.date_naissance;
                edit.service = service;
                edit.is_manager = collaborateur.is_manager;
                edit.manager = manager;




                $("#edit-item").modal('show');
            },
            updateCollaborateur(id){
                let input = this.fillItem;

                input.service_id = input.service.id;

                if(input.is_manager == "0") {//ie when the user isn't manager then we set the manager_id
                    if( input.manager != null) { //the collab can be not managed by anyone
                        input.manager_id = input.manager.id;
                    } else {
                        console.log("manager is not specified");

                    }
                }
                axios.put('vue-collaborateurs/' + id, input).then( (response)=> {

                    if(input.is_manager == "1") {
                        this.managers.push(response.data);
                        $('#managerAdd').show();
                    }
                    console.log('responseUpdate', response);

                    this.getCollaborateurs();

                    this.fillItem = { 'nom': '', 'prenom': '', 'image': '', 'post': '', 'date_naissance': '', 'email':'', 'telephone': '', 'adresse': '', 'image': '', 'service_id':'', 'is_manager':'', 'manager_id':'', 'service':{}, 'manager': {}, 'id':''};
                    $('#edit-item').modal('hide');
                    $('#userEdit').fadeIn();

                }).catch( (error)=> {
                    console.log( error.response.data )
                })
            },

            imageChangedOnCreate(event) {

                var input = event.target;
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = (e) => {
                        this.newItem.image = e.target.result;
                    }
                    reader.readAsDataURL(input.files[0]);
                }
           },

            imageChangedOnUpdate(event) {

                var input = event.target;
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = (e) => {
                        this.fillItem.image = e.target.result;
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            },
            deleteCollaborateur( collaborateur ) {
                let conf = confirm("Voulez-vous supprimer ce collaborateur?");
                if (conf === true) {
                    axios.delete('vue-collaborateurs/' + collaborateur.id).then((response) => {
                        this.getCollaborateurs();
                        $('#userDelete').show();
                    });
                }
            }
        }
    }
</script>

<style>

    .required {
        color: red;
    }
    img.preview {
        width: 150px;
        background-color: white;
        padding: 5px;
        display: block;
        margin-left: auto;
        margin-right: auto;
    }



</style>