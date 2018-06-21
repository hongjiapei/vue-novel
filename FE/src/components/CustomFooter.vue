<template>
  <div :style="footerStyle">
    <mu-bottom-nav :value.sync="$store.state.navigator_value" shift :color="'#ff0052'">
      <mu-bottom-nav-item title="书架" icon="restore" :to="navigator.bookshelf" :value="navigator.bookshelf"></mu-bottom-nav-item>
      <mu-bottom-nav-item title="分类" icon="list" :to="navigator.category" :value="navigator.category"></mu-bottom-nav-item>
      <mu-bottom-nav-item title="搜索" icon="search" :to="navigator.search" :value="navigator.search"></mu-bottom-nav-item>
    </mu-bottom-nav>
  </div>
</template>

<script>
    export default {
      data () {
        return {
          footerStyle: {
            position: 'fixed',
            bottom: '0',
            width: '100%',
          },
          navigator: {
            bookshelf: '/bookshelf',
            category: '/category',
            search: '/search',
          }
        }
      },
    }
</script>

<style>
  a.mu-bottom-item {
    color: #fff;
  }
</style>
