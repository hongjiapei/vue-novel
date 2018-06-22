<template>
    <div>
      <mu-appbar style="width: 100%;position: fixed;top: 0;" title="分类" :z-depth="1" :color="'#ff0052'"></mu-appbar>
      <div style="margin: 60px 0;">
        <mu-list>
          <mu-list-item :to="'/lists?category_name='+item.category_name+'&category_url='+item.category_url" button v-for="(item,index) in $store.state.categories">
            <mu-list-item-title :style="{textAlign: 'center'}">{{item.category_name}}</mu-list-item-title>
          </mu-list-item>
        </mu-list>
      </div>

    </div>
</template>

<script>
    import Vue from 'vue'
    export default {
      data () {
        return {

        }
      },
      methods: {
        getCategories () {
          if (this.$store.state.isLoading) return false
          this.$http.get('/novel/categories').then(res => {
              this.$store.state.categories = res.data
              this.setCategories(res.data)
          })
        },
        // 小说分类存入localStorage，过期时间10天
        setCategories (categories=[],expire=864000) {
          let tmp = {
            expire_time:Date.parse(new Date())/1000+expire,
            categories: categories
          }
          Vue.localStorage.set('categories',JSON.stringify(tmp))
        },
        scrollToTop () {
          window.scroll(0, 0)
        },
        clearCategoryUrl () {
          this.$store.state.current_category_url = ''
        },
      },
      mounted () {
        // 读取小说分类，缓存没过期直接用，过期了重新获取并设置缓存
        let categories = Vue.localStorage.get('categories')
        if (categories) {
          categories = JSON.parse(categories)
          if (categories.expire_time < Date.parse(new Date())/1000) {
            this.getCategories()
          } else {
            this.$store.state.categories = categories.categories
          }
        } else {
          this.getCategories()
        }
        this.clearCategoryUrl()
        this.scrollToTop()
      }
    }
</script>

<style scoped>

</style>
