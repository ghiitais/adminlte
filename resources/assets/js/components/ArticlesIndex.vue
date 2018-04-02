
<template>
    <div>
        <div class="form-group">
            <router-link :to="{name: 'createArticle'}" class="btn btn-success">Ajouter article</router-link>
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
                        <td>{{ article.titre }}</td>
                        <td> <div v-html="article.contenu.slice(0,20)+'...'"></div> </td>
                        <td><img style="display:block;" width="40" height="40"  :src="'http://localhost:8000/'+article.image" class="img"/></td>
                        <td>{{article.created_at}}</td>
                        <td>{{article.updated_at}}</td>
                        <td>
                            <router-link :to="{name: 'editArticle', params: {id: article.id}}" class="btn btn-xs btn-warning">
                                Edit
                            </router-link>
                            <a href="#"
                               class="btn btn-xs btn-danger"
                               v-on:click="deleteEntry(article.id, index)">
                                Delete
                            </a>
                            <router-link :to="{name: 'showArticle', params: {id: article.id}}" class="btn btn-xs btn-info">
                                Show
                            </router-link>
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
                if (confirm("Do you really want to delete it?")) {
                    var app = this;
                    axios.delete('/articles/'+id)
                        .then(function (resp) {
                            app.articles.splice(index, 1);
                        })
                        .catch(function (resp) {
                            alert("Could not delete article");
                        });
                }
            }
        }
    }
</script>
