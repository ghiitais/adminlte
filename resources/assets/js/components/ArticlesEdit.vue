<template>
    <div class="container">
        <div class="form-group">
            <router-link to="/" class="btn btn-default btn-dark"> < Back</router-link>
        </div>

        <form v-on:submit="updateForm()">
            <div class="row">
                <div class="col-lg-12 form-group">
                    <label class="control-label">Titre</label>
                    <input type="text" v-model="article.titre" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 form-group">
                    <label class="control-label">Contenu</label>
                    <froala :tag="'textarea'"  v-model="article.contenu"></froala>
                </div>
            </div>
            <div class="form-group">
                <label>Image</label>
                <input type="file" @change="imageChanged" :src="'http://localhost:8000/'+article.image"  class="form-control">
            </div>
            <div class="row">
                <div class="col-lg-12 form-group">
                    <button class="btn btn-success">Update</button>
                </div>
            </div>
        </form>
    </div>
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