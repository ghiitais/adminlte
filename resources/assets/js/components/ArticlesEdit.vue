<template>

<section class="content">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Modifier l'article</h3>

          <div class="box-tools pull-right">
            <router-link to="/" class="btn btn-default"> <i class="fa fa-arrow-left"></i> <strong>  Back </strong></router-link>
          </div>
        </div>
        <div class="box-body">
                    <div class="alert alert-success collapse alert-dismissible" id="managerAdd">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            Article modifié avec succès!
                    </div>

            <form v-on:submit="updateForm()">
            <div class="row">
                <div class="col-lg-12 form-group">
                    <label class="control-label"> <strong> Titre: </strong></label>
                    <input type="text" v-model="article.titre" class="form-control">
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 form-group">
                    <label class="control-label"> <strong> Contenu: </strong></label>
                    <froala :tag="'textarea'"  v-model="article.contenu"></froala>
                </div>
            </div>
            <div class="form-group">
                <label> <strong> Image: </strong></label>
                <input type="file" @change="imageChanged" :src="'http://localhost:8000/'+article.image"  class="form-control">
            </div>
            <div class="row">
                <div class="col-lg-12 form-group">
                    <button class="btn btn-primary">Modifier</button>
                </div>
            </div>
        </form>
        </div>
        
      </div>
</section>
</template>

<script>
    import VueFroala from 'vue-froala-wysiwyg';
    export default {
        mounted() {
            let app = this;
            let id = app.$route.params.id;
            app.articleId = id;
            axios.get('/articles/' + id)
                .then(function (resp) {
                    app.article = resp.data;
                })
                .catch(function () {
                    alert("Could not load your article")
                });
        },
        data: function () {
            return {

                model: 'Edit Your Content Here!',
                articleId: null,
                article: {
                    titre: '',
                    contenu: '',
                    image:''

                }
            }
        },
        methods: {
            updateForm() {
                event.preventDefault();
                var app = this;
                var newArticle = app.article;
                axios.patch('/articles/' + app.articleId, newArticle)
                    .then(function (resp) {
                        app.$router.replace('/');
                        $('#managerAdd').show();

                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Could not update article");
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

</style>