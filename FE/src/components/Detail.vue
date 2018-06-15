<template>
  <div>
    <mu-appbar style="width: 100%;position: fixed;top: 0;" :title="book_name" :color="'#ff0052'">
      <span slot="left">
        <mu-icon value="navigate_before" @click="goBack"></mu-icon>
      </span>
      <mu-button flat slot="right" :to="'/'" color="rgba(0,0,0,0.54)">
        <mu-icon value="home" :color="'#fff'"></mu-icon>
      </mu-button>
    </mu-appbar>
    <div style="margin-top: 60px;" v-if="book_description">
      <mu-card style="width: 100%; max-width: 375px; margin: 0 auto;">
        <mu-card-text v-html="book_description"></mu-card-text>
        <mu-card-actions>
          <mu-button flat :to="'/chapters?book_url='+book_url+'&book_name='+book_name+'&get_chapters_url='+get_chapters_url">查看目录</mu-button>
        </mu-card-actions>
        <mu-card-actions v-if="book && book.hasOwnProperty('get_chapterDetail_url')">
          <mu-button flat :to="'/chapter/detail?book_url='+book_url+'&book_name='+book_name+'&get_chapterDetail_url='+book.get_chapterDetail_url">继续上次阅读</mu-button>
        </mu-card-actions>
        <mu-card-actions>
          <mu-button flat @click="toggleSaveBook">{{showText}}</mu-button>
        </mu-card-actions>
      </mu-card>
      <mu-alert color="#ff0052" :show="isShow" transition="mu-scale-transition">
        <mu-icon value="check_circle"></mu-icon> 操作成功
      </mu-alert>
    </div>

  </div>
</template>

<script>
    import Vue from 'vue'
    export default {
      data () {
        return {
          book: {},
          book_url: '',
          book_name: '',
          book_description: '',
          get_chapters_url: '',
          isShow: false,
          showText: '',
        }
      },
      methods: {
        getDetail (website) {
          if (this.$store.state.isLoading) return false
          this.$http.get('/novel/detail?website='+website).then(res => {
            this.book_description = res.data.book_description
            this.get_chapters_url = res.data.get_chapters_url
          })
        },
        goBack () {
          this.$router.back()
        },
        toggleSaveBook () {
          if (Vue.localStorage.get(this.book_url)) {
            Vue.localStorage.remove(this.book_url)
            this.isShow = !this.isShow
            this.showText = '加入书架'
            setTimeout(()=>{
              this.isShow = !this.isShow
            },1000)
            return false
          }
          let book = {book_name: this.book_name, book_url: this.book_url}
          book = JSON.stringify(book)
          Vue.localStorage.set(this.book_url,book)
          this.isShow = !this.isShow
          this.showText = '从书架删除'
          setTimeout(()=>{
            this.isShow = !this.isShow
          },1000)
        },
        scrollToTop () {
          window.scroll(0, 0)
        },
        clearGetChaptersUrl () {
          this.$store.state.current_get_chapters_url = ''
        },
      },
      mounted () {
        this.book_url = this.$route.query.book_url
        this.book_name = this.$route.query.book_name
        this.showText = Vue.localStorage.get(this.book_url) ? '从书架删除' : '加入书架'
        this.getDetail(this.book_url)
        let book = Vue.localStorage.get(this.book_url)
        if (book) {
          this.book = JSON.parse(book)
        }
        this.clearGetChaptersUrl()
        this.scrollToTop()
      },
    }
</script>

<style scoped>

</style>
