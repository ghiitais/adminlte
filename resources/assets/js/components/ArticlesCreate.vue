<template>
    <div class="container">
        <div class="form-group">
            <router-link to="/" class="btn btn-default btn-dark"> < Back</router-link>
        </div>

                <form v-on:submit="saveForm()">
                    <div class="row col-lg-12 form-group">
                            <label class="control-label">Titre</label>
                            <input type="text" v-model="article.titre" class="form-control">
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Contenu</label>
                            <froala :tag="'textarea'"  v-model="article.contenu"></froala>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" @change="imageChanged" :src="'http://localhost:8000/'+article.image"  class="form-control">
                    </div>

                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <button class="btn btn-success">Create</button>
                        </div>
                    </div>

                </form>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                article: {
                    titre: '',
                    contenu: '',
                    image:''

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

</style>