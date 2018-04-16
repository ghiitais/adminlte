<template>
    <div>
        <router-link to="/" class="mb-5"> <i class="fa fa-arrow-left"></i> <strong>  Retour à actualités </strong></router-link>

        <h3> <strong>{{ article.titre }} </strong> </h3>
        <br>
        <div>
            <img :src="'http://localhost:8000/'+article.image" style="display:block;" width="70%" height="70%" class="img"/>

        </div>
        <div class="mt-5">
            <froalaView v-model="article.contenu"></froalaView>
        </div>
        <br/>
        <span></span>

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

