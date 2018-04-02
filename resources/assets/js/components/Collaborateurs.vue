<template>
    <div class="container">

        <div class="row pt-5">

            <div class="col-lg-12 d-flex justify-content-end pb-2">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#create-item">
                    Ajouter collaborateur <i class="fa fa-plus" aria-hidden="true"></i>
                </button>
            </div>



            <div v-for="collaborateur in collaborateurs" class="col-lg-4">
                <div class="card mb-3">
                    <img class="card-img-top" :src="'http://localhost:8000/'+collaborateur.image" alt="Card image cap">
                    <div class="card-body">
                        <h4 class="card-title">{{ collaborateur.nom }}</h4>
                        <p class="card-text">{{ collaborateur.prenom }}</p>
                        <p class="card-text">{{ collaborateur.email }}</p>
                        <p class="card-text">{{ collaborateur.telephone }}</p>
                        <p class="card-text">{{ collaborateur.post }}</p>
                        <p class="card-text">{{ collaborateur.adresse }}</p>
                        <p class="card-text">{{ collaborateur.date_naissance }}</p>


                        <button type="button" class="btn btn-primary" @click.prevent="editCollaborateur( collaborateur )" ><i class="fa fa-pencil" aria-hidden="true"></i></button>
                        <button type="button" class="btn btn-danger" @click.prevent="deleteCollaborateur( collaborateur )"><i class="fa fa-trash" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>

            <!-- Create Collab Modal -->
            <div class="modal fade" id="create-item" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                        <label>Image</label>
                                        <input type="file" @change="imageChangedOnCreate" :src="'http://localhost:8000/'+newItem.image"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Nom</label>
                                        <input type="text" class="form-control" v-model="newItem.nom">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Prenom</label>
                                        <input type="text" class="form-control" v-model="newItem.prenom">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Adresse</label>
                                        <input type="text" class="form-control" v-model="newItem.adresse">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Post</label>
                                        <input type="text" class="form-control" v-model="newItem.post">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="text" class="form-control" v-model="newItem.email">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Telephone</label>
                                        <input type="text" class="form-control" v-model="newItem.telephone">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Date de naissance</label>
                                        <input type="text" class="form-control" v-model="newItem.date_naissance">
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
            <div class="modal fade" id="edit-item" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                        <label>Image</label>
                                        <input type="file" @change="imageChangedOnUpdate" :src="'http://localhost:8000/'+fillItem.image"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Nom</label>
                                        <input type="text" class="form-control" v-model="fillItem.nom">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Prenom</label>
                                        <input type="text" class="form-control" v-model="fillItem.prenom">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Adresse</label>
                                        <input type="text" class="form-control" v-model="fillItem.adresse">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Post</label>
                                        <input type="text" class="form-control" v-model="fillItem.post">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="text" class="form-control" v-model="fillItem.email">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Telephone</label>
                                        <input type="text" class="form-control" v-model="fillItem.telephone">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Date de naissance</label>
                                        <input type="text" class="form-control" v-model="fillItem.date_naissance">
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

    export default {

        data(){

            return {

                newItem: { 'nom': '', 'prenom': '', 'image': '', 'post': '', 'date_naissance': '', 'email':'', 'telephone': '', 'adresse': '', 'image': '' },
                 fillItem: { 'nom': '', 'prenom': '', 'image': '', 'post': '', 'date_naissance': '', 'email':'', 'telephone': '', 'adresse': '' , 'image': '','id': ''},
                collaborateurs: []

            }
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

                }).catch( (error) => {
                    //console.log( error.response.data )
                })
            },
            editCollaborateur( collaborateur ) {
                let edit = this.fillItem;

                edit.nom = collaborateur.nom;
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

                axios.put('vue-collaborateurs/'+id, input).then( (response)=> {

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

            deleteCollaborateur( collaborateur ) {
                axios.delete('vue-collaborateurs/' + collaborateur.id).then( (response) => {
                    this.getCollaborateurs();
                });
            }
        }
    }
</script>