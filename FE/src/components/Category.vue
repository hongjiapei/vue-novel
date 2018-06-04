<template>
    <div>
      <mu-appbar style="width: 100%;position: fixed;top: 0;" title="分类" :z-depth="1"></mu-appbar>
      <div style="margin-top: 60px;">
        <mu-list>
          <mu-list-item :to="'/lists?category_name='+item.category_name+'&category_url='+item.category_url" button v-for="(item,index) in categories" :class="index % 2 === 0 ? 'white' : 'gray'">
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
          categories: [],
        }
      },
      methods: {
        getCategories () {
          this.$http.get('/novel/categories').then(res => {
              this.categories = res.data
              this.setCategories(res.data)
          })
        },
        setCategories (categories=[],expire=86400) {
          let tmp = {
            expire_time:Date.parse(new Date())/1000+expire,
            categories: categories
          }
          Vue.localStorage.set('categories',JSON.stringify(tmp))
        },
        scrollToTop () {
          window.scroll(0, 0)
        }
      },
      mounted () {
        let categories = Vue.localStorage.get('categories')
        if (categories) {
          categories = JSON.parse(categories)
          // 过期了重新拉取分类并存到localStorage
          if (categories.expire_time < Date.parse(new Date())/1000) {
            this.getCategories()
          } else {
          // 没过期则直接用
            this.categories = categories.categories
          }
        } else {
          this.getCategories()
        }

        this.scrollToTop()
      }
    }
</script>

<style scoped>
  .gray {
    background-color: rgba(240,240,240,1);
  }
  .white {
    background-color: #fff;
  }
</style>
