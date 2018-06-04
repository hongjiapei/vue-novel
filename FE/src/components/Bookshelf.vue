<template>
  <div>
    <mu-appbar style="width: 100%;position: fixed;top: 0;" title="书架" :z-depth="1">
         <span slot="left">
        <mu-icon value="menu" @click="drawerShow = !drawerShow"></mu-icon>
      </span>
    </mu-appbar>
    <div style="margin-top: 60px;">
      <mu-grid-list v-if="books.length > 0">
        <mu-grid-tile v-for="(item,index) in books" @click="toDetail(item)">
          <!-- 网页直接看的话，图片路径这样写-->
          <img :src="'../../static/img/'+index%3+'.jpeg'" :style="{width:'100%',height:'100%'}">
          <!-- 用HBuilder打包成ap的话，p图片路径这样写-->
          <!--<img :src="'./static/img/'+index%3+'.jpeg'" :style="{width:'100%',height:'100%'}">-->
          <span slot="title">{{item.book_name}}</span>
          <mu-button slot="action" icon>
            <mu-icon value="book"></mu-icon>
          </mu-button>
        </mu-grid-tile>
      </mu-grid-list>
    </div>
    <mu-drawer :open.sync="drawerShow" :docked="false">
      <mu-list toggle-nested>
        <mu-list-item button :ripple="false" nested :open="true">
          <mu-list-item-title>书源设置</mu-list-item-title>
          <mu-list-item-action>
            <mu-icon size="24" :value="'keyboard_arrow_down'"></mu-icon>
          </mu-list-item-action>
          <mu-list-item button :ripple="false" slot="nested">
            <mu-list-item-title>
              <mu-radio :label="'笔趣阁(m.biquge5200.cc)'" :value="'001'" v-model="source"></mu-radio>
            </mu-list-item-title>
          </mu-list-item>
          <mu-list-item button :ripple="false" slot="nested">
            <mu-list-item-title>
              <mu-radio :label="'有空再做'" :value="'002'" v-model="source" disabled></mu-radio>
            </mu-list-item-title>
          </mu-list-item>
          <mu-list-item button :ripple="false" slot="nested">
            <mu-list-item-title>
              <mu-radio :label="'有空再做'" :value="'003'" v-model="source" disabled></mu-radio>
            </mu-list-item-title>
          </mu-list-item>
        </mu-list-item>
      </mu-list>
    </mu-drawer>
  </div>
</template>

<script>
    import Vue from 'vue'
    export default {
      data () {
        return {
          books: [],
          drawerShow: false,
          source: '001',
        }
      },
      methods: {
        getBooks () {
          Object.keys(localStorage).forEach((v,i)=>{
            if (v === 'categories') return false
            try {
              let book = JSON.parse(Vue.localStorage.get(v))
              this.books.push(book)
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
        }
      },
      mounted () {
        this.getBooks()
        this.scrollToTop()
      },
    }
</script>

<style scoped>

</style>
