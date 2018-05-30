
<template>
<section class="content">
      <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <div class="form-group">
                        <router-link :to="{name: 'createArticle'}" class="btn btn-success">Ajouter article <i class="fa fa-plus" aria-hidden="true"></i></router-link>
                    </div>
                    <table class="table table-bordered">
                        
                            <tr>
                                <th>Image</th>
                                <th>Titre</th>
                                <th>Contenu</th>
                                <th>Ecrit par</th>
                                <th>Crée le</th>
                                <th>Modifié le</th>
                                <th>Action</th>
                            </tr>
                        
                        
                            <tr v-for="article, index in articles">
                                <td><img style="display:block;" width="100" height="100"  :src="article.image" class="img"/></td>
                                <td> <router-link :to="{name: 'showArticle', params: {id: article.id}}">  <strong> {{ article.titre }} </strong>  </router-link> </td>
                                <td> <div v-html="article.contenu.slice(0,70)+'...'"></div> </td>
                                <td>{{ article.author == null ? '': article.author.name}}</td>
                                <td> <span class="text_nowrap"> {{article.created_at}} </span></td>
                                <td> <span class="text_nowrap"> {{article.updated_at}} </span></td>
                                <td style='white-space: nowrap'>
                                    <router-link :to="{name: 'editArticle', params: {id: article.id}}" class="btn btn-sm btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i></router-link>
                                    <a href="#" class="btn btn-sm btn-danger" v-on:click="deleteEntry(article.id, index)"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                    <router-link :to="{name: 'showArticle', params: {id: article.id}}" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></router-link>
                                </td>
                            </tr>
                        
                    </table>
                </div>
            </div>
        </div>
      </div>
</section>
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
                    app.articles = resp.data.posts;
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