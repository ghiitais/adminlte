
<template>
<div class="container">
        <div class="form-group">
            <router-link :to="{name: 'createArticle'}" class="btn btn-success">Ajouter article <i class="fa fa-plus" aria-hidden="true"></i></router-link>
        </div>
                <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Contenu</th>
                        <th>Image</th>
                        <th>Crée le</th>
                        <th>Modifié le</th>
                        <th>Action</th>


                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="article, index in articles">
                        <td> <router-link :to="{name: 'showArticle', params: {id: article.id}}">  <strong> {{ article.titre }} </strong>  </router-link> </td>

                        <td> <div v-html="article.contenu.slice(0,70)+'...'"></div> </td>
                        <td><img style="display:block;" width="200" height="200"  :src="'http://localhost:8000/'+article.image" class="img"/></td>
                        <td> <span class="text_nowrap"> {{article.created_at}} </span></td>
                        <td> <span class="text_nowrap"> {{article.updated_at}} </span></td>
                        <td style='white-space: nowrap'>

                            <router-link :to="{name: 'editArticle', params: {id: article.id}}" class="btn btn-xs btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i></router-link>
                            <a href="#" class="btn btn-xs btn-danger" v-on:click="deleteEntry(article.id, index)"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            <router-link :to="{name: 'showArticle', params: {id: article.id}}" class="btn btn-xs btn-info"><i class="fa fa-eye"></i></router-link>

                        </td>

                    </tr>
                    </tbody>
                </table>
            </div>
</div>
</template>

<script>
    export default {
        data: function () {
            return {
                articles: []
            }
        },
        mounted() {
            var app = this;
            axios.get('/articles')
                .then(function (resp) {
                    app.articles = resp.data;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Could not load articles");
                });
        },
        methods: {
            deleteEntry(id, index) {
                if (confirm("Voulez-vous supprimer l'article?")) {
                    var app = this;
                    axios.delete('/articles/'+id)
                        .then(function (resp) {
                            app.articles.splice(index, 1);
                        })
                        .catch(function (resp) {
                            alert("Erreur de suppression");
                        });
                }
            }
        }
    }
</script>
<style>

</style>