<template>
  <span>
    <header>
      <nav-bar logo="Social" url="/" cor="grey darken-4">
        <li v-if="!usuario"><router-link to="/login">Entrar</router-link></li>
        <li v-if="!usuario"><router-link to="/cadastro">Cadastre-se</router-link></li>
        <li v-if="usuario"><router-link to="/perfil">{{usuario.name}}</router-link></li>
        <li v-if="usuario"><a v-on:click="sair()">Sair</a></li>
      </nav-bar>
    </header>

    <main>
      <div class="grey darken-4 container">
        <div class="row">
          <grid-vue tamanho="4">
            <card-menu-vue>
              <slot name="menuesquerdo" />
            </card-menu-vue>
            <card-menu-vue>
              <h4>Amigos</h4>
              <li>Murilo</li>
              <li>Gustavo</li>
            </card-menu-vue>
          </grid-vue>
          <grid-vue tamanho="8">
            <slot name="principal" />
          </grid-vue>

        </div>



      </div>
    </main>

  </span>
</template>

<script>
import NavBar from '@/components/layouts/NavBar'
import GridVue from '@/components/layouts/GridVue'
import CardMenuVue from '@/components/layouts/CardMenuVue'

export default {
  name: 'SiteTemplate',
  data(){
    return {
      usuario: false
    }
  },
  components:{
    NavBar,
    GridVue,
    CardMenuVue
  },
  created(){
    console.log('created()');
    let usuarioAux = this.$store.getters.getUsuario;
    if(usuarioAux){
      this.usuario = this.$store.getters.getUsuario;
    }else{
      this.$router.push('/login');
    }
  },
  methods:{
    sair(){
      this.$store.commit('setUsuario',null);
      sessionStorage.clear();
      this.usuario = false;
      this.$router.push('/login');
    }
  }
}
</script>

<style>

</style>
