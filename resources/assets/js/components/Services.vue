<template>
    <div class="container">

            <div class="col-lg-12 justify-content-end pb-2 mt-10">
                <button type="button" @click="ajouterBtn()" class="btn btn-success" data-toggle="modal" data-target="#create-item" >
                    Ajouter service <i class="fa fa-plus" aria-hidden="true"></i>
                </button>
            </div>



            <div v-for="service in services" class="col-lg-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <h4 class="card-title">{{service.nom}}</h4>
                        <p class="card-text">  {{service.description}} </p>

                        <button type="button" class="btn btn-warning" @click.prevent="editService(service)" ><i class="fa fa-pencil" aria-hidden="true"></i></button>
                        <button type="button" class="btn btn-danger" @click.prevent="deleteService(service)"><i class="fa fa-trash" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>

            <!-- Create Service Modal -->
            <div class="modal fade" id="create-item" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="post" enctype="multipart/form-data" @submit.prevent="createService">
                            <div class="modal-body">


                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Nom: </label> <span class="required">*</span>
                                        <input name= "nom" type="text" v-validate= "'required'" :class="{'input': true, 'is-danger': errors.has('nom') }" class="form-control" v-model="newItem.nom">
                                        <i v-show="errors.has('nom')" class="fa fa-warning"></i>
                                        <span v-show="errors.has('nom')" class="" style="color: red">{{ errors.first('nom') }}</span>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Description: </label>
                                        <textarea  type="text" class="form-control" v-model="newItem.description"> </textarea>
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

            <!-- Edit Service Modal -->
            <div class="modal fade" id="edit-item" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="post" enctype="multipart/form-data" @submit.prevent="updateService(fillItem.id)">
                            <input type="hidden" name="_method" value="PUT">
                            <div class="modal-body">

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
                                        <label>Description: </label>
                                        <textarea  type="text" class="form-control" v-model="fillItem.description"> </textarea>
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

    export default {

        data(){

            return {

                newItem: { 'nom': '', 'description': ''},
                fillItem: { 'nom': '', 'description': '', 'id': ''},
                services: [],

            }
        },


        mounted() {
            this.getServices();
        },

        methods: {
            getServices() {
                axios.get('vue-services').then( response => {

                    this.services = response.data;
                    console.log(this.services);
                })
            },
            createService() {
                let input = this.newItem;

                axios.post('vue-services', input).then( (response) => {

                    this.services.push(response.data);
                    this.newItem = { 'nom': '', 'description': ''};
                    $('#create-item').modal('hide');
                    this.getServices();

                }).catch( (error) => {
                    //console.log( error.response.data )
                })
            },
            editService(service) {
                let edit = this.fillItem;

                edit.id = service.id;
                edit.nom = service.nom;
                edit.description = service.description;

                $("#edit-item").modal('show');
            },
            updateService(id){
                let input = this.fillItem;

                axios.put('vue-services/' + id, input).then( (response)=> {

                    this.getServices();
                    this.fillItem = { 'nom': '', 'description': '', 'id': ''};
                    $('#edit-item').modal('hide');

                }).catch( (error)=> {
                    console.log( error.response.data )
                })
            },

            ajouterBtn(){
                this.newItem = { 'nom': '', 'description': ''};
            },
            deleteService(service) {
                let conf = confirm("Do you ready want to delete this service?");
                if (conf === true) {
                    axios.delete('vue-services/' +service.id).then((response) => {
                        this.getServices();
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
</style>