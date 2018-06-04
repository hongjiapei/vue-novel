<template>
  <div id="app">
    <looping-rhombuses-spinner
      :animation-duration="1000"
      :color="'#ff1d5e'"
      v-show="this.$store.state.isLoading"
      :style="loadingStyle"
    />
    <router-view/>
  </div>
</template>

<script>
  import {AtomSpinner,LoopingRhombusesSpinner} from 'epic-spinners'
  export default {
    components: {
      AtomSpinner,
      LoopingRhombusesSpinner,
    },
    data () {
      return {
        loadingStyle: {
          position: 'fixed',
          left: '44%',
          top: '44%',
          zIndex: 999,
        }
      }
    }
  }
</script>

<style>
  html, body {
    width: 100%;
    height: 100%;
  }
  #app {
    font-family: 'Avenir', Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-align: center;
    color: #2c3e50;
    margin-bottom: 60px;
  }
</style>
