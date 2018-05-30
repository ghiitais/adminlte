<template>

<section class="content">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">{{ article.titre }}</h3>

          <div class="box-tools pull-right">
            <router-link to="/" class="btn btn-default"> <i class="fa fa-arrow-left"></i> <strong>  Retour à actualités </strong></router-link>
          </div>
        </div>
        <div class="box-body">
          <h6> Ecrit par <em> {{ article.author == null ? '': article.author.name}} </em></h6>
        <h6> Publié le <em> {{ article.created_at}} </em></h6>
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
        
      </div>
    </section>
</template>

<script>
    export default {
        data: function () {
            return {article: {}}
        },
        created: function(){
            axios.get('/articles/'+this.$route.params.id).then((response) => {
                this.article = response.data;
            });
        }
    }
    </script>

