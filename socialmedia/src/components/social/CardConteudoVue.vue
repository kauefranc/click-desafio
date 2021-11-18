<template>

<div class="row">
    <div class="card">
      <div class="card-content">
        <div class="row valign-wrapper">
          <grid-vue tamanho="1">
            <img :src="perfil" :alt="nome" class="circle responsive-img"> <!-- notice the "circle" class -->
          </grid-vue>
          <grid-vue tamanho="11">
            <span class="black-text">
              <strong>{{nome}}</strong> - <small>{{data}}</small>

            </span>
          </grid-vue>
        </div>

        <slot />

      </div>
      <div class="card-action">
        <p>
          <a style="cursor:pointer" @click="curtida(id)" ><i class="material-icons red-text">{{curtiu}}</i>{{totalCurtidas}}</a>
          <a style="cursor:pointer" @click="abreComentarios()"> <i class="material-icons">insert_comment</i>{{listaComentarios.length}}</a>
        </p>
        <p v-if="exibirComentario" class="right-align" >
          <input type="text" v-model="textoComentario" placeholder="Comentar">
          <button v-if="textoComentario" @click="comentar(id)" class="btn waves-effect waves-light orange"><i class="material-icons">send</i></button>
        </p>
        <p v-if="exibirComentario" class="black-text">
          <ul class="collection">
            <li class="collection-item avatar" v-for="item in comentarios" :key="item.id">
             <img :src="item.user.imagem" alt="" class="circle">
             <span class="title">{{item.user.name}} <small> - {{item.data}}</small></span>
             <p class="black-text">
                {{item.texto}}
             </p>
           </li>

          </ul>

        </p>
      </div>
    </div>

</div>

</template>

<script>
import GridVue from '@/components/layouts/GridVue'

export default {
  name: 'CardConteudoVue',
  props:['id','perfil','nome','data','totalcurtidas','curtiuconteudo','comentarios'],
  data () {
    return {
      curtiu: this.curtiuconteudo ? 'favorite' : 'favorite_border',
      totalCurtidas:this.totalcurtidas,
      exibirComentario:false,
      textoComentario:'',
      listaComentarios:this.comentarios || []

    }
  },
  components:{
    GridVue
  },
  methods:{
    curtida(id){
      this.$http.put(this.$urlAPI+`conteudo/curtir/`+id,{},
        {"headers":{"authorization":"Bearer "+this.$store.getters.getToken}})
        .then(response => {
          if(response.status){
            this.totalCurtidas = response.data.curtidas;
            this.$store.commit('setConteudosLinhaTempo',response.data.lista.conteudos.data);
            if(this.curtiu == 'favorite_border'){
              this.curtiu = 'favorite';
            }else{
              this.curtiu = 'favorite_border';
            }
          }else {
            alert(response.data.erro);
          }
        }).catch(e => {
          console.log(e)
          alert("Erro! Tente novamente mais tarde!");
        });
    },
    abreComentarios(){
      this.exibirComentario = !this.exibirComentario;
    },
    comentar(id){
      if(!this.textoComentario){
        return;
      }
      this.$http.put(this.$urlAPI+`conteudo/comentar/`+id,{texto:this.textoComentario},
        {"headers":{"authorization":"Bearer "+this.$store.getters.getToken}})
        .then(response => {
          if(response.status){
            this.textoComentario = "";
            this.$store.commit('setConteudosLinhaTempo',response.data.lista.conteudos.data);
          }else {
            alert(response.data.erro);
          }
        }).catch(e => {
          console.log(e)
          alert("Erro! Tente novamente mais tarde!");
        });
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
