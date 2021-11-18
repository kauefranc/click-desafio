<template>

  <site-template>
    <span class="grey darken-4" slot="menuesquerdo">
      <div class=" grey darken-3 row valign-wrapper">
        <grid-vue tamanho="4">
          <img :src="usuario.imagem" :alt="usuario.name" class="circle responsive-img"> <!-- notice the "circle" class -->
        </grid-vue>
        <grid-vue tamanho="8">
          <span class="black-text">
            <h5>{{usuario.name}}</h5>

          </span>
        </grid-vue>
      </div>
    </span>

    <span slot="principal">
      <publicar-conteudo-vue />


      <card-conteudo-vue v-for="item in listaConteudos" :key="item.id"
        :id="item.id"
        :totalcurtidas="item.total_curtidas"
        :comentarios="item.comentarios"
        :curtiuconteudo="item.curtiu_conteudo"
        :perfil="item.user.imagem"
        :nome="item.user.name"
        :data="item.data">
          <card-detalhe-vue
            :img="item.imagem"
            :titulo="item.titulo"
            :txt="item.texto"
            :link="item.link"  />
      </card-conteudo-vue>
      <div v-scroll="handleScroll">

      </div>
    </span>



  </site-template>



</template>

<script>
import SiteTemplate from '@/templates/SiteTemplate'
import CardConteudoVue from '@/components/social/CardConteudoVue'
import CardDetalheVue from '@/components/social/CardDetalheVue'
import PublicarConteudoVue from '@/components/social/PublicarConteudoVue'
import GridVue from '@/components/layouts/GridVue'


export default {
  name: 'Home',
  data () {
    return {
      usuario:false,
      urlProximaPagina:null,
      pararScroll:false

    }
  },
  created(){
    let usuarioAux = this.$store.getters.getUsuario;
    if(usuarioAux){
      this.usuario = this.$store.getters.getUsuario;
      this.$http.get(this.$urlAPI+`conteudo/lista`, {"headers":{"authorization":"Bearer "+this.$store.getters.getToken}})
      .then(response => {
        //console.log(response);
        if(response.data.status){
          this.$store.commit('setConteudosLinhaTempo',response.data.conteudos.data);
          this.urlProximaPagina = response.data.conteudos.next_page_url;
        }

      })
      .catch(e => {
        console.log(e)
        alert("Erro! Tente novamente mais tarde!");
      })

    }
  },
  components:{
    SiteTemplate,
    CardConteudoVue,
    CardDetalheVue,
    PublicarConteudoVue,
    GridVue
  },
  methods:{

    handleScroll() {
      //console.log(window.scrollY);
      //console.log(document.body.clientHeight);
      if(this.pararScroll){
        return;
      }
      if(window.scrollY >= document.body.clientHeight - 949){
        this.pararScroll = true;
        this.carregaPaginacao();
      }
    },
    carregaPaginacao(){
      if(!this.urlProximaPagina){
        return;
      }
      this.$http.get(this.urlProximaPagina, {"headers":{"authorization":"Bearer "+this.$store.getters.getToken}})
      .then(response => {
        //console.log(response);
        if(response.data.status){
          this.$store.commit('setPaginacaoConteudosLinhaTempo',response.data.conteudos.data);
          this.urlProximaPagina = response.data.conteudos.next_page_url;
          this.pararScroll = false;
        }

      })
      .catch(e => {
        console.log(e)
        alert("Erro! Tente novamente mais tarde!");
      })
    }
  },
  computed:{
    listaConteudos(){
      return this.$store.getters.getConteudosLinhaTempo;
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
