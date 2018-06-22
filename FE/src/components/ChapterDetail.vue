<template>
    <div>
      <mu-appbar style="width: 100%;position: fixed;top: 0;" :title="book_name" :color="'#ff0052'" :style="{background:isDark ? '#111': '#ff0052'}">
        <span slot="left">
          <mu-icon value="navigate_before" @click="goBack"></mu-icon>
        </span>
        <mu-button flat slot="right" :to="'/'" color="rgba(0,0,0,0.54)">
          <mu-icon value="home" :color="'#fff'"></mu-icon>
        </mu-button>
      </mu-appbar>
      <div style="margin: 58px 0;" v-if="chapter_content" @click="operate('','',$event)">
        <mu-card :style="{width: '100%',maxWidth: '375px', margin: '0 auto'}">
          <mu-card-text v-html="chapter_name" :style="{textAlign:'center',background:isDark ? '#111': '#fff', color:isDark ? '#ccc': '#000',fontSize:fontSize+'px',}"></mu-card-text>
          <mu-card-text v-html="chapter_content" :style="{textAlign: 'left',background:isDark ? '#111': '#fff', color:isDark ? '#ccc': '#000',fontSize:fontSize+'px',}"></mu-card-text>
        </mu-card>
      </div>
      <mu-appbar :color="'#ff0052'" :style="{width: '100%',position: 'fixed',bottom: 0,background:isDark ? '#111': '#ff0052'}">
        <mu-row gutter>
          <mu-col span="4"><mu-button flat :disabled="prev_url === get_chapters_url" @click="changePage(prev_url)">上页</mu-button></mu-col>
          <mu-col span="4"><mu-button flat :to="'/chapters?book_name='+book_name+'&get_chapters_url='+get_chapters_url">目录</mu-button></mu-col>
          <mu-col span="4"><mu-button flat :disabled="next_url === get_chapters_url" @click="changePage(next_url)">下页</mu-button></mu-col>
        </mu-row>
      </mu-appbar>
      <!-- 设置选项 -->
      <mu-appbar class="operation" color="rgba(0,0,0,0.94)" v-show="isOperationShow">
        <mu-list>
          <mu-sub-header>设置</mu-sub-header>
          <mu-list-item button>
            <mu-list-item-action>
              <mu-icon value="brightness_2" color="orange"></mu-icon>
            </mu-list-item-action>
            <mu-list-item-title>
              <mu-switch v-model="isDark"></mu-switch>
            </mu-list-item-title>
          </mu-list-item>
          <mu-list-item button>
            <mu-list-item-action>
              <mu-icon value="font_download" color="cyan"></mu-icon>
            </mu-list-item-action>
            <mu-list-item-title>
              <mu-radio :value="14" v-model="fontSize" :label="'14'" style="padding: 0 8px;"></mu-radio>
              <mu-radio :value="16" v-model="fontSize" :label="'16'" style="padding: 0 8px;"></mu-radio>
              <mu-radio :value="18" v-model="fontSize" :label="'18'" style="padding: 0 8px;"></mu-radio>
            </mu-list-item-title>
          </mu-list-item>
        </mu-list>
      </mu-appbar>
    </div>
</template>

<script>
    import Vue from 'vue'
    export default {
      data () {
        return {
          book_url: '',
          book_name: '',
          chapter_name: '',
          chapter_content: '',
          get_chapterDetail_url: '',
          prev_url: '',
          next_url: '',
          get_chapters_url: '',
          isOperationShow: false,
          isDark: false,
          fontSize: 14,
        }
      },
      methods: {
        getChapterDetail (website) {
          if (this.$store.state.isLoading) return false
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
          if (this.$store.state.isLoading) return false
          this.getChapterDetail(url)
        },
        scrollToTop () {
          window.scroll(0,0)
        },

        // 点击中间弹出设置选项,点击右边下一章,点击左边上一章
        operate (param1,param2,$event) {
          let x = $event.pageX
          let y = $event.pageY - window.scrollY
          if (this.isClickCenter(x,y)) {
            this.isOperationShow = !this.isOperationShow
          } else if (this.isClickLeft(x)) {
            if (this.$store.state.isLoading) return false
            // 判断是否是首页
            if (this.prev_url === this.get_chapters_url) {
              this.$store.state.isLastPage = true
              setTimeout(() => {
                this.$store.state.isLastPage = false
              },1000)
            } else {
              this.changePage(this.prev_url)
            }

          } else if (this.isClickRight(x)) {
            if (this.$store.state.isLoading) return false
            // 判断是否是尾页
            if (this.next_url === this.get_chapters_url) {
              this.$store.state.isLastPage = true
              setTimeout(() => {
                this.$store.state.isLastPage = false
              },1000)
            } else {
              this.changePage(this.next_url)
            }
          }
        },
        // 夜间模式
        setDark () {
          Vue.localStorage.set('isDark',this.isDark ? 1 : 0)
        },
        // 字体大小
        setFontSize () {
          Vue.localStorage.set('fontSize',this.fontSize)
        },
        isClickCenter (x,y) {
          let centerX = window.innerWidth / 2
          let centerY = window.innerHeight / 2
          let isXCenter = ( x < (centerX+40) ) && ( x > (centerX-40) )
          let isYCenter = ( y < (centerY+100) ) && ( y > (centerY-100) )
          return isXCenter && isYCenter
        },
        isClickLeft (x) {
          let leftBoundary = 0
          let rightBoundary = window.innerWidth / 4
          return ( x < rightBoundary ) && ( x > leftBoundary )
        },
        isClickRight (x) {
          let leftBoundary = window.innerWidth / 2 + window.innerWidth / 4
          let rightBoundary = window.innerWidth
          return ( x < rightBoundary ) && ( x > leftBoundary )
        },
      },
      watch: {
        'chapter_name': 'scrollToTop', //切换章节时回滚到顶部
        'isDark': 'setDark',
        'fontSize': 'setFontSize',
      },
      mounted () {
        this.book_url = this.$route.query.book_url
        this.book_name = this.$route.query.book_name
        this.get_chapterDetail_url = this.$route.query.get_chapterDetail_url
        this.getChapterDetail(this.get_chapterDetail_url)
        // 夜间模式
        let isDark = Vue.localStorage.get('isDark')
        if (Number(isDark) !== 0) this.isDark = true
        // 字体大小
        let fontSize = Vue.localStorage.get('fontSize')
        if (fontSize)  this.fontSize = Number(fontSize)
      },
      destroyed () {
        // 退出时保存阅读进度
        let book = Vue.localStorage.get(this.book_url)
        if (book) {
          book = JSON.parse(book)
          book.get_chapterDetail_url = this.get_chapterDetail_url
          book = JSON.stringify(book)
          Vue.localStorage.set(this.book_url,book)
        }
      },
    }
</script>

<style>
  .operation {
    width: 100%;
    position: fixed;
    bottom: 0;
    height: auto;
    z-index: 9999;
  }
  .operation .mu-sub-header {
    color: #fff;
  }
  .operation .mu-item {
    color: #fff;
  }
  .operation .mu-radio-label {
    color: #fff;
  }
</style>
