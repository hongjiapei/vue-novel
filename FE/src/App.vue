<template>
  <div id="app">
    <atom-spinner
      :animation-duration="1000"
      :color="'#ff1d5e'"
      v-show="$store.state.isLoading"
      :style="loadingStyle"
    />
    <mu-snackbar :color="'#ff1d5e'" :open.sync="$store.state.isRetryShow">
       {{$store.state.retryText}}
    </mu-snackbar>
    <mu-snackbar :color="'#ff1d5e'" :open.sync="$store.state.isLastPage">
      没有更多章节了
    </mu-snackbar>
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
          left: '50%',
          top: '50%',
          transform: '',
          zIndex: 999,
        }
      }
    },
    methods: {

    },
    mounted () {
      this.$store.commit("setLoadingTranslate")
      // loading动画居中
      this.loadingStyle.transform = 'translate('+this.$store.state.loadingTranslate.x+'px,'+this.$store.state.loadingTranslate.y+'px)'
    },
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
