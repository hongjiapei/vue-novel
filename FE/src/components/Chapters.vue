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
      <div style="margin: 60px 4%" v-if="chapters.length > 0">
        <mu-list>
          <mu-list-item button v-for="(item,index) in chapters" :style="{marginTop:'6px',marginBottom:'10px'}" :to="'/chapter/detail?book_url='+book_url+'&book_name='+book_name+'&get_chapterDetail_url='+item.get_chapterDetail_url">
            <mu-list-item-title>{{item.chapter_name}}</mu-list-item-title>
            <mu-list-item-action>
              <mu-icon value="navigate_next"></mu-icon>
            </mu-list-item-action>
          </mu-list-item>
        </mu-list>
        <mu-row gutter>
          <mu-col span="2"><mu-button small :disabled="get_chapters_url === first_url" @click="changePage(first_url)" :color="'#ff0052'">首页</mu-button></mu-col>
          <mu-col span="2" offset="1"><mu-button small :disabled="get_chapters_url === prev_url" @click="changePage(prev_url)" :color="'#ff0052'">上页</mu-button></mu-col>
          <mu-col span="2" offset="1"><mu-button small :disabled="get_chapters_url === next_url" @click="changePage(next_url)" :color="'#ff0052'">下页</mu-button></mu-col>
          <mu-col span="2" offset="1"><mu-button small :disabled="get_chapters_url === last_url" @click="changePage(last_url)" :color="'#ff0052'">尾页</mu-button></mu-col>
        </mu-row>
      </div>
    </div>
</template>

<script>
    export default {
      data () {
        return {
          book_url: '',
          book_name: '',
          get_chapters_url: '',
          chapters: [],
          first_url: '',
          prev_url: '',
          next_url: '',
          last_url: '',
        }
      },
      methods: {
        getChapters (website) {
          if (this.$store.state.isLoading) return false
          this.$http.get('/novel/chapters?website='+website).then(res => {
            this.get_chapters_url = website
            this.chapters = res.data
            if (this.chapters.length > 0) {
              if (this.chapters[0].hasOwnProperty('first_url')) {
                this.first_url = this.chapters[0].first_url
              } else {
                this.first_url = this.get_chapters_url
              }
              if (this.chapters[0].hasOwnProperty('prev_url')) {
                this.prev_url = this.chapters[0].prev_url
              } else {
                this.prev_url = this.get_chapters_url
              }
              if (this.chapters[0].hasOwnProperty('next_url')) {
                this.next_url = this.chapters[0].next_url
              } else {
                this.next_url = this.get_chapters_url
              }
              if (this.chapters[0].hasOwnProperty('last_url')) {
                this.last_url = this.chapters[0].last_url
              } else {
                this.last_url = this.get_chapters_url
              }
            }
          })
        },
        goBack () {
          this.$router.back()
        },
        changePage (url) {
          this.getChapters(url)
        },
        scrollToTop () {
          window.scroll(0, 0)
        },
        setGetChaptersUrl () {
          this.$store.state.current_get_chapters_url = this.get_chapters_url
        },
      },
      mounted () {
        this.book_url = this.$route.query.book_url
        this.book_name = this.$route.query.book_name
        this.get_chapters_url = this.$store.state.current_get_chapters_url || this.$route.query.get_chapters_url
        this.getChapters(this.get_chapters_url)
      },
      watch:{
        'chapters': 'scrollToTop',
        'get_chapters_url': 'setGetChaptersUrl',
      }
    }
</script>

<style scoped>

</style>
