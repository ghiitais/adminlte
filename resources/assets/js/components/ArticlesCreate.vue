<template>


<section class="content">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"> Nouvel article</h3>

          <div class="box-tools pull-right">
            <router-link to="/" class="btn btn-default"> <i class="fa fa-arrow-left"></i> <strong>  Retour </strong></router-link>
          </div>
        </div>
        <div class="box-body">
            <form v-on:submit="saveForm()">
                    <div class="row">
                        <div class="col-lg-12 form-group">
                            <label class="control-label">Titre</label>
                            <input type="text" v-model="article.titre" class="form-control">
                        </div>
                    </div>
                   <!-- <div class="row">
                        <div class="col-lg-12 form-group">
                            <label class="control-label">Contenu</label>
                            <froala :tag="'textarea'"  v-model="article.contenu"></froala>
                        </div>
                    </div> -->
                    <div class="row">
                        <div class="col-lg-12 form-group">
                            <label>Contenu</label>
                            <froala :tag="'textarea'"  v-model="article.contenu"></froala>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Image</label>
                        <div class="image-preview" v-if="article.image.length > 0">
                            <img id="preview" class="preview" :src="article.image">
                        </div>
                        <input type="file" @change="imageChanged" :src="article.image"  class="form-control">
                    </div>

                    <div class="row">
                        <div class="col-lg-12 form-group">
                            <button class="btn btn-primary">Ajouter article</button>
                        </div>
                    </div>

                </form>
        </div>
        
      </div>
    </section>

</template>

<script>
    export default {
        data: function () {
            return {
                article: {
                    titre: '',
                    contenu: '',
                    image:''

                },
                editorOption: {
                    // some quill options
                }
            }
        },

        methods: {
            saveForm() {
                event.preventDefault();
                var app = this;
                var newArticle = app.article;
                axios.post('/articles', newArticle)
                    .then(function (resp) {
                        app.$router.push({path: '/'});
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Could not create your article");
                    });
            },
            imageChanged(e){
                console.log(e.target.files[0])
                var fileReader=new FileReader()
                fileReader.readAsDataURL(e.target.files[0])
                fileReader.onload=(e)=>{
                    this.article.image=e.target.result
                }
            }

        }
    }
</script>
<style scoped>
    img.preview {
        width: 400px;
        background-color: white;
        padding: 5px;
        display: block;

    }

</style>