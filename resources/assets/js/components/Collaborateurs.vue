<template>
    <div class="container">

        <div class="row pt-5">

            <div class="col-lg-12 d-flex justify-content-end pb-2">
                <button type="button" @click="ajouterBtn()" class="btn btn-success" data-toggle="modal" data-target="#create-item" >
                    Ajouter collaborateur <i class="fa fa-plus" aria-hidden="true"></i>
                </button>
            </div>



            <div v-for="collaborateur in collaborateurs" class="col-lg-4">
                <div class="card mb-3">
                    <img class="card-img-top" :src="'http://localhost:8000/'+collaborateur.image" alt="Card image cap">
                    <div class="card-body">
                        <h4 class="card-title">{{ collaborateur.nom }} {{collaborateur.prenom}}</h4>
                        <p class="card-text"> <strong> Email </strong> : {{ collaborateur.email }}</p>
                        <p class="card-text"> <strong> Tel </strong>: {{ collaborateur.telephone }}</p>
                        <p class="card-text"> <strong> Post </strong> : {{ collaborateur.post }}</p>
                        <p class="card-text"> <strong> Adresse </strong>: {{ collaborateur.adresse }}</p>
                        <p class="card-text"> <strong> Date de naissance </strong>: {{ collaborateur.date_naissance }}</p>


                        <button type="button" class="btn btn-primary" @click.prevent="editCollaborateur( collaborateur )" ><i class="fa fa-pencil" aria-hidden="true"></i></button>
                        <button type="button" class="btn btn-danger" @click.prevent="deleteCollaborateur( collaborateur )"><i class="fa fa-trash" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>

            <!-- Create Collab Modal -->
            <div class="modal fade" id="create-item" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="post" enctype="multipart/form-data" @submit.prevent="createCollaborateur">
                            <div class="modal-body">


                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Image: </label><span class="required">*</span>
                                        <input required type="file" data-preview="#preview" @change="imageChangedOnCreate" :src="'http://localhost:8000/'+newItem.image"  class="form-control">
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Nom: </label> <span class="required">*</span>
                                        <input name= "nom" type="text" v-validate= "'required|alpha'" :class="{'input': true, 'is-danger': errors.has('nom') }" class="form-control" v-model="newItem.nom">
                                        <i v-show="errors.has('nom')" class="fa fa-warning"></i>
                                        <span v-show="errors.has('nom')" class="" style="color: red">{{ errors.first('nom') }}</span>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Prenom: </label> <span class="required">*</span>
                                        <input name= "prenom" type="text" v-validate= "'required|alpha'" :class="{'input': true, 'is-danger': errors.has('prenom') }" class="form-control" v-model="newItem.prenom">
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
                                            <input name= "post" type="text" v-validate= "'required|alpha'" :class="{'input': true, 'is-danger': errors.has('post') }" class="form-control" v-model="newItem.post">
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
                                        <flat-pickr name="date"  :class="{'input': true, 'is-danger': errors.has('date') }" v-validate="'required|date_format:YYYY-MM-DD'" :config="config" placeholder="Choisissez une date"  class="form-control" v-model="newItem.date_naissance"> </flat-pickr>
                                        <i v-show="errors.has('date')" class="fa fa-warning"></i>
                                        <span v-show="errors.has('date')" class="" style="color: red">{{ errors.first('date') }}</span>
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

            <!-- Edit Collab Modal -->
            <div class="modal fade" id="edit-item" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">

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
                                        <input required type="file" data-preview="#preview" @change="imageChangedOnUpdate" :src="'http://localhost:8000/'+fillItem.image"  class="form-control">
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Nom: </label> <span class="required">*</span>
                                        <input name= "nom" type="text" v-validate= "'required|alpha'" :class="{'input': true, 'is-danger': errors.has('nom') }" class="form-control" v-model="fillItem.nom">
                                        <i v-show="errors.has('nom')" class="fa fa-warning"></i>
                                        <span v-show="errors.has('nom')" class="" style="color: red">{{ errors.first('nom') }}</span>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Prenom: </label> <span class="required">*</span>
                                        <input name= "prenom" type="text" v-validate= "'required|alpha'" :class="{'input': true, 'is-danger': errors.has('prenom') }" class="form-control" v-model="fillItem.prenom">
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
                                        <input name= "post" type="text" v-validate= "'required|alpha'" :class="{'input': true, 'is-danger': errors.has('post') }" class="form-control" v-model="fillItem.post">
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
                                        <flat-pickr name="date"  :class="{'input': true, 'is-danger': errors.has('date') }" v-validate="'required|date_format:YYYY-MM-DD'" :config="config" placeholder="Choisissez une date"  class="form-control" v-model="fillItem.date_naissance"> </flat-pickr>
                                        <i v-show="errors.has('date')" class="fa fa-warning"></i>
                                        <span v-show="errors.has('date')" class="" style="color: red">{{ errors.first('date') }}</span>
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
    </div>
</template>

<script>
    import flatPickr from 'vue-flatpickr-component';
    import 'flatpickr/dist/flatpickr.css';
    export default {

        data(){

            return {

                newItem: { 'nom': '', 'prenom': '', 'image': '', 'post': '', 'date_naissance': '', 'email':'', 'telephone': '', 'adresse': '', 'image': '' },
                fillItem: { 'nom': '', 'prenom': '', 'image': '', 'post': '', 'date_naissance': '', 'email':'', 'telephone': '', 'adresse': '' , 'image': '','id': ''},
                collaborateurs: [],
                date: new Date(),
                config: {
                    dateFormat: 'Y-m-d',

                },

            }
        },
        components: {
            flatPickr
        },

        mounted() {
            this.getCollaborateurs();
        },

        methods: {
            getCollaborateurs() {
                axios.get( 'vue-collaborateurs' ).then( response => {

                    this.collaborateurs = response.data;
                })
            },
            createCollaborateur() {
                let input = this.newItem;

                axios.post('vue-collaborateurs', input).then( (response) => {

                    this.collaborateurs.push(response.data);
                    this.newItem = { 'nom': '', 'prenom': '', 'image': '', 'post': '', 'date_naissance': '', 'email':'', 'telephone': '', 'adresse': '' };
                    $('#create-item').modal('hide');
                    this.getCollaborateurs();

                }).catch( (error) => {
                    //console.log( error.response.data )
                })
            },
            editCollaborateur(collaborateur) {
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

                $("#edit-item").modal('show');
            },
            updateCollaborateur(id){
                let input = this.fillItem;

                axios.put('vue-collaborateurs/' + id, input).then( (response)=> {

                    this.getCollaborateurs();
                    this.fillItem = { 'nom': '', 'prenom': '', 'image': '', 'post': '', 'date_naissance': '', 'email':'', 'telephone': '', 'adresse': '' , 'id': ''};
                    $('#edit-item').modal('hide');

                }).catch( (error)=> {
                    console.log( error.response.data )
                })
            },
            imageChangedOnCreate(e){
                console.log(e.target.files[0])
                var fileReader=new FileReader()
                fileReader.readAsDataURL(e.target.files[0])
                fileReader.onload=(e)=>{
                    this.newItem.image=e.target.result
                    //this.fillItem.image = e.target.result
                }
            },
            imageChangedOnUpdate(e){
                console.log(e.target.files[0])
                var fileReader=new FileReader()
                fileReader.readAsDataURL(e.target.files[0])
                fileReader.onload=(e)=>{
                    this.fillItem.image = e.target.result
                }
            },
            ajouterBtn(){
                this.newItem = { 'nom': '', 'prenom': '', 'image': '', 'post': '', 'date_naissance': '', 'email':'', 'telephone': '', 'adresse': '' };
            },
            deleteCollaborateur( collaborateur ) {
                let conf = confirm("Do you ready want to delete this collab?");
                if (conf === true) {
                    axios.delete('vue-collaborateurs/' + collaborateur.id).then((response) => {
                        this.getCollaborateurs();
                    });
                }
            }
        }
    }
</script>

<style>
    .card-img-top {
        width: 100%;
        height: 15vw;
        object-fit: cover;
    }
    .required {
        color: red;
    }
</style>