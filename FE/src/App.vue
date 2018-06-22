<template>
  <div>
    <breeding-rhombus-spinner
      :animation-duration="2000"
      :size="65"
      :color="'#ff0052'"
      v-show="$store.state.isLoading"
      :style="loadingStyle"
    />
    <mu-snackbar :color="'#ff0052'" :open.sync="$store.state.isRetryShow">
       {{$store.state.retryText}}
    </mu-snackbar>
    <mu-snackbar :color="'#ff0052'" :open.sync="$store.state.isLastPage">
      没有更多章节了
    </mu-snackbar>
    <router-view/>
  </div>
</template>

<script>
  import {BreedingRhombusSpinner} from 'epic-spinners'
  export default {
    components: {
      BreedingRhombusSpinner,
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
  .mu-appbar-title {
    text-align: center;
  }
  .mu-card-actions {
    text-align: center;
  }
  .mu-raised-button {
    min-width: 60px;
  }
</style>
