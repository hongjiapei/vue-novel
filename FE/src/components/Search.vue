<template>
  <div>
    <mu-appbar style="width: 100%;position: fixed;top: 0;" title="搜索" :z-depth="1" :color="'#ff0052'"></mu-appbar>
    <div style="margin: 80px 0 60px 10px;">
      <mu-text-field placeholder="请输入书名" v-model="keyword" @keyup.enter="getSearch"></mu-text-field>
      <mu-button @click="getSearch" :color="'#ff0052'">搜索</mu-button>
      <br/>
      <mu-list>
        <mu-list-item button v-for="(item,index) in lists" :style="{marginTop:'6px',marginBottom:'10px'}" :to="'/detail?book_name='+item.book_name+'&book_url='+item.book_url">
          <mu-list-item-content>
            <mu-list-item-title>{{item.book_name}}</mu-list-item-title>
            <mu-list-item-sub-title>{{item.book_author}}</mu-list-item-sub-title>
          </mu-list-item-content>
        </mu-list-item>
      </mu-list>
    </div>
  </div>
</template>

<script>
    export default {
      data () {
        return {
          keyword: '',
          lists: [],
        }
      },
      methods: {
        getSearch () {
          if (!this.keyword || this.$store.state.isLoading) return false
          // 让搜索框blur，这样手机键盘会收回去
          document.getElementsByClassName('mu-text-field-input')[0].blur()
          this.$http.get('/novel/search?keyword='+this.keyword).then(res => {
            this.lists = res.data
          })

        },
        scrollToTop () {
          window.scroll(0, 0)
        }
      },
      mounted () {
        this.scrollToTop()
      }
    }
</script>

<style scoped>

</style>
