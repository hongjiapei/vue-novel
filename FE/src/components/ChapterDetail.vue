<template>
    <div>
      <mu-appbar style="width: 100%;position: fixed;top: 0;" :title="book_name">
      <span slot="left">
        <mu-icon value="navigate_before" @click="goBack"></mu-icon>
      </span>
      </mu-appbar>
      <div style="margin-top: 60px;" v-if="chapter_content">
        <mu-card style="width: 100%; max-width: 375px; margin: 0 auto;">
          <mu-card-title :sub-title="chapter_name"></mu-card-title>
          <mu-card-text v-html="chapter_content" :style="{textAlign: 'left'}"></mu-card-text>
          <mu-card-actions>
            <mu-row gutter>
              <mu-col span="4"><mu-button flat :disabled="prev_url === get_chapters_url" @click="changePage(prev_url)">上页</mu-button></mu-col>
              <mu-col span="4"><mu-button flat :to="'/chapters?book_name='+book_name+'&get_chapters_url='+get_chapters_url">目录</mu-button></mu-col>
              <mu-col span="4"><mu-button flat :disabled="next_url === get_chapters_url" @click="changePage(next_url)">下页</mu-button></mu-col>
            </mu-row>
          </mu-card-actions>
          <mu-card-actions>
            <mu-button flat :to="'/'">返回书架</mu-button>
          </mu-card-actions>
        </mu-card>
      </div>

    </div>
</template>

<script>
    import Vue from 'vue'
    export default {
      data () {
        return {
          book_name: '',
          chapter_name: '',
          chapter_content: '',
          get_chapterDetail_url: '',
          prev_url: '',
          next_url: '',
          get_chapters_url: '',
        }
      },
      methods: {
        getChapterDetail (website) {
          this.$http.get('/novel/chapterDetail?website='+website).then(res => {
            this.get_chapterDetail_url = website
            this.chapter_name = res.data.chapter_name
            this.chapter_content = res.data.chapter_content
            this.prev_url = res.data.prev_url
            this.next_url = res.data.next_url
            this.get_chapters_url = res.data.get_chapters_url
          })
        },
        goBack () {
          this.$router.back()
        },
        changePage (url) {
          this.getChapterDetail(url)
        },
        scrollToTop () {
          window.scroll(0, 0)
        }
      },
      watch: {
        'chapter_name': 'scrollToTop', //切换章节时回滚到顶部
      },
      mounted () {
        this.book_name = this.$route.query.book_name
        this.get_chapterDetail_url = this.$route.query.get_chapterDetail_url
        this.getChapterDetail(this.get_chapterDetail_url)
      },
      destroyed () {
        let book = Vue.localStorage.get(this.book_name)
        if (book) {
          book = JSON.parse(book)
          book.get_chapterDetail_url = this.get_chapterDetail_url
          book = JSON.stringify(book)
          Vue.localStorage.set(this.book_name,book)
        }
      },
    }
</script>

<style scoped>

</style>
