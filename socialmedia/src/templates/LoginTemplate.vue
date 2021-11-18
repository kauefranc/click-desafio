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
      <div class="container">
        <div class="row">

          <grid-vue tamanho="8">
            <card-menu-vue>
              <slot name="menuesquerdo" />
            </card-menu-vue>
          </grid-vue>
          <grid-vue tamanho="4">
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
  name: 'LoginTemplate',
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
      this.$router.push('/');
    }
  }
}
</script>

<style>

</style>
