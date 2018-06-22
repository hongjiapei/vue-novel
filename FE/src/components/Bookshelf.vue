<template>
  <div>
    <mu-appbar style="width: 100%;position: fixed;top: 0;" title="书架" :z-depth="1" :color="'#ff0052'">
         <span slot="left">
        <mu-icon value="menu" @click="drawerShow = !drawerShow"></mu-icon>
      </span>
    </mu-appbar>
    <div style="margin: 60px 0;">
      <mu-grid-list v-if="$store.state.books.length > 0">
        <mu-grid-tile v-for="(item,index) in $store.state.books" @click="toDetail(item)">
          <img src="./static/img/0_compressed.png" :style="{width:'100%',height:'100%'}">
          <span slot="title">{{item.book_name}}</span>
          <mu-button slot="action" icon>
            <mu-icon value="book"></mu-icon>
          </mu-button>
        </mu-grid-tile>
      </mu-grid-list>
    </div>
    <!-- 侧边菜单 -->
    <mu-drawer :open.sync="drawerShow" :docked="false" :style="{background:'rgba(255,255,255,0.92)'}">
      <mu-list toggle-nested>
        <mu-list-item button nested :open="true">
          <mu-list-item-title>书源设置</mu-list-item-title>
          <mu-list-item-action>
            <mu-icon size="24" :value="'keyboard_arrow_down'"></mu-icon>
          </mu-list-item-action>
          <mu-list-item button :ripple="false" slot="nested" @click="changeSource">
            <mu-list-item-title>
              <mu-radio :label="'笔趣阁(m.biquge5200.cc)'" :value="'001'" v-model="$store.state.source"></mu-radio>
            </mu-list-item-title>
          </mu-list-item>
          <mu-list-item button :ripple="false" slot="nested" @click="changeSource">
            <mu-list-item-title>
              <mu-radio :label="'三七中文(m.37zw.net)'" :value="'002'" v-model="$store.state.source"></mu-radio>
            </mu-list-item-title>
          </mu-list-item>
          <mu-list-item button :ripple="false" slot="nested">
            <mu-list-item-title>
              <mu-radio :label="'有空再做'" :value="'003'" v-model="$store.state.source" disabled></mu-radio>
            </mu-list-item-title>
          </mu-list-item>
        </mu-list-item>
        <mu-list-item button @click="isClearCacheShow = true">
          <mu-list-item-action>
            <mu-icon value="cached"></mu-icon>
          </mu-list-item-action>
          <mu-list-item-title>清除缓存 &ensp;&ensp;&ensp;&ensp;{{cacheSize+'KB'}}</mu-list-item-title>
        </mu-list-item>
      </mu-list>
    </mu-drawer>
    <mu-dialog title="确认清除？" width="360" :open.sync="isClearCacheShow">
      清空书架和分类缓存
      <mu-button slot="actions" flat color="primary" @click="clearCache">OK</mu-button>
    </mu-dialog>
  </div>
</template>

<script>
    import Vue from 'vue'
    export default {
      data () {
        return {
          drawerShow: false,
          source: '001',
          // 把不是book的过滤掉
          localStorageFilter: ['categories','fontSize','isDark','loglevel:webpack-dev-server','source'],
          isClearCacheShow: false,
          cacheSize: 0,
        }
      },
      methods: {
        getBooks () {
          this.$store.state.books = []
          Object.keys(localStorage).forEach((v,i)=>{
            if (this.localStorageFilter.includes(v)) return false
            try {
              let book = JSON.parse(Vue.localStorage.get(v))
              this.$store.state.books.push(book)

              // 去重
              let hash = {}
              this.$store.state.books = this.$store.state.books.reduce(function(item, next) {
                hash[next.book_url] ? '' : hash[next.book_url] = true && item.push(next)
                return item
              }, [])
            } catch (e) {

            }
          })
        },
        toDetail (book) {
          this.$router.push({
            path: '/detail?book_name='+book.book_name+'&book_url='+book.book_url,
          })
        },
        scrollToTop () {
          window.scroll(0, 0)
        },
        clearCache () {
          window.localStorage.clear()
          this.$store.state.books = []
          this.$store.state.categories = []
          this.getCacheSize()
          this.isClearCacheShow = false
        },
        // 缓存大小，单位KB
        getCacheSize () {
          let cacheSize = 0
          Object.keys(window.localStorage).forEach(function (v,i) {
            cacheSize += Vue.localStorage.get(v).length
          })
          this.cacheSize = (cacheSize/1024).toFixed(2)
        },
        // 切换小说源
        changeSource () {
          if (Vue.localStorage.get('source') === this.$store.state.source) return false
          localStorage.clear()
          this.$store.state.books = []
          this.$store.state.categories = []
          Vue.localStorage.set('source',this.$store.state.source)
          this.drawerShow = false
        },
        setSource () {
          this.$store.state.source = Vue.localStorage.get('source') || '001'
        }
      },
      mounted () {
        this.getBooks()
        this.setSource()
        this.scrollToTop()
        this.getCacheSize()
      },
    }
</script>

<style scoped>

</style>
