<template>
    <div>
        <h3>{{ article.titre }}</h3>
        <div>
            <froalaView v-model="article.contenu"></froalaView>
        </div>
        <div>
            <img :src="'http://localhost:8000/'+article.image" style="display:block;" width="80%" height="80%" class="img"/>

        </div>
        <br/>
        <span class="glyphicon glyphicon-arrow-left"></span>
        <router-link to="/"> Back to actualités </router-link>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {article: {titre: '', contenu: '',image:''}}
        },
        created: function(){
            axios.get('/articles/'+this.$route.params.id).then((response) => {
                this.article = response.data;
            });
        }
    }
    </script>

