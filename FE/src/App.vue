<template>
  <div id="app">
    <atom-spinner
      :animation-duration="1000"
      :color="'#ff1d5e'"
      v-show="$store.state.isLoading"
      :style="loadingStyle"
    />
    <mu-dialog title="加载失败" width="360" :open.sync="$store.state.isLoadingFailed">
      是否刷新？
      <mu-button slot="actions" flat color="primary" @click="refreshWindow">OK</mu-button>
    </mu-dialog>
    <mu-snackbar :color="'#ff1d5e'" :open.sync="$store.state.isRetryShow">
       加载失败，自动重试中...
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
      refreshWindow () {
        this.$router.push({
          path: '/'
        })
        window.location.reload()
      }
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
