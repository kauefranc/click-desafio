<template>

  <site-template>

    <span slot="menuesquerdo">
      <img src="../../assets/guest.png" class="responsive-img">
    </span>

    <span slot="principal">

      <h2>Perfil</h2>

      <input type="text" placeholder="Nome" v-model="name" class="white-text">
      <input type="text" placeholder="E-mail" v-model="email" class="white-text">

      <input type="password" placeholder="Senha" v-model="password" class="white-text">
      <input type="password" placeholder="Confirme sua Senha" v-model="password_confirmation" class="white-text">
      <button class="btn" v-on:click="perfil()">Atualizar</button>

    </span>
  </site-template>



</template>

<script>
import SiteTemplate from '@/templates/SiteTemplate'


export default {
  name: 'Perfil',
  data () {
    return {
      usuario:false,
      name:'',
      email:'',
      password:'',
      password_confirmation:'',
      imagem:''
    }
  },
  created(){
    let usuarioAux = this.$store.getters.getUsuario;
    if(usuarioAux){
      this.usuario = this.$store.getters.getUsuario;
      this.name = this.usuario.name;
      this.email = this.usuario.email;
      console.log(this.usuario.imagem)
    }
  },
  components:{
    SiteTemplate
  },
  methods:{
    salvaImagem(e){
      let arquivo = e.target.files || e.dataTransfer.files;
      if(!arquivo.length){
        return;
      }

      let reader = new FileReader();
      reader.onloadend = (e) => {
        this.imagem = e.target.result;
      };
      reader.readAsDataURL(arquivo[0]);
      console.log(this.imagem)
    },
    perfil(){

      this.$http.put(this.$urlAPI+`perfil`, {
        name: this.name,
        email: this.email,
        imagem: this.imagem,
        password:this.password,
        password_confirmation:this.password_confirmation
      },{"headers":{"authorization":"Bearer "+this.usuario.token}})
      .then(response => {
        //console.log(response)
        if(response.data.status){

          this.usuario = response.data.usuario;
          this.$store.commit('setUsuario',response.data.usuario);
          sessionStorage.setItem('usuario',JSON.stringify(this.usuario));
          alert('Perfil atualizado!');

        }else if(response.data.status == false && response.data.validacao){

          let erros = '';
          for(let erro of Object.values(response.data.erros)){
            erros += erro +" ";
          }
          alert(erros);
        }
      })
      .catch(e => {
        console.log(e)
        alert("Erro! Tente novamente mais tarde!");
      })
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
