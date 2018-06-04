<template>
  <div id="container">
    <router-view/>
    <custom-footer></custom-footer>
  </div>
</template>

<script>
    import CustomFooter from '@/components/CustomFooter'
    export default {
      components: {
        CustomFooter: CustomFooter,
      }
    }
</script>

<style>
  #container {
    width: 100%;
    height: 100%;
  }
</style>
