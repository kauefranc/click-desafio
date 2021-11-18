<template>

<span>
  <div v-if="img && img != '#'" class="card-image">
    <a v-if="link && link != '#'" :href="link" target="_blank">
      <img  :src="img">
      <span class="card-title black-text">{{titulo || ''}}</span>
    </a>
    <span v-if="!link || link == '#'">
      <img  :src="img">
      <span class="card-title black-text">{{titulo || ''}}</span>
    </span>
  </div>

  <div class="card-content">
    <span v-if="!img || img == '#'">
      <span class="card-title black-text">{{titulo || ''}}</span>
    </span>
    <p class="black-text">{{txt}}</p>
    <p v-if="link && link != '#'"><a :href="link" target="_blank">Confira mais aqui...</a></p>
  </div>
</span>


</template>

<script>


export default {
  name: 'CardDetalheVue',
  props:['img','titulo','txt','link'],
  data () {
    return {

    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
