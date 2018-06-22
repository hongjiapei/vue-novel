<template>
  <div>
    <mu-appbar style="width: 100%;position: fixed;top: 0;" :title="category_name" :color="'#ff0052'">
      <span slot="left">
        <mu-icon value="navigate_before" @click="goBack"></mu-icon>
      </span>
    </mu-appbar>
    <div style="margin: 60px 6%" v-if="lists.length > 0">
      <mu-list>
        <mu-list-item button v-for="(item,index) in lists" :style="{marginTop:'6px',marginBottom:'10px'}" :to="'/detail?book_name='+item.book_name+'&book_url='+item.book_url">
          <mu-list-item-content>
            <mu-list-item-title>{{item.book_name}}</mu-list-item-title>
            <mu-list-item-sub-title>{{item.book_author}}</mu-list-item-sub-title>
          </mu-list-item-content>
        </mu-list-item>
      </mu-list>
      <mu-row gutter>
        <mu-col span="2" @click="changePage(first_url)"><mu-button small :disabled="category_url === first_url" :color="'#ff0052'">首页</mu-button></mu-col>
        <mu-col span="2" offset="1" @click="changePage(prev_url)"><mu-button small :disabled="category_url === prev_url" :color="'#ff0052'">上页</mu-button></mu-col>
        <mu-col span="2" offset="1" @click="changePage(next_url)"><mu-button small :disabled="category_url === next_url" :color="'#ff0052'">下页</mu-button></mu-col>
        <mu-col span="2" offset="1" @click="changePage(last_url)"><mu-button small :disabled="category_url === last_url" :color="'#ff0052'">尾页</mu-button></mu-col>
      </mu-row>
    </div>
  </div>
</template>

<script>
    export default {
      data () {
        return {
          category_name: '',
          category_url: '',
          lists: [],
          first_url: '',
          prev_url: '',
          next_url: '',
          last_url: '',
        }
      },
      methods: {
        getLists (website) {
          if (this.$store.state.isLoading) return false
          this.$http.get('/novel/lists?website='+website).then(res => {
            this.lists = res.data
            this.category_url = website
            if (this.lists.length > 0) {
              if (this.lists[0].hasOwnProperty('first_url')) {
                this.first_url = this.lists[0].first_url
              } else {
                this.first_url = this.category_url
              }
              if (this.lists[0].hasOwnProperty('prev_url')) {
                this.prev_url = this.lists[0].prev_url
              } else {
                this.prev_url = this.category_url
              }
              if (this.lists[0].hasOwnProperty('next_url')) {
                this.next_url = this.lists[0].next_url
              } else {
                this.next_url = this.category_url
              }
              if (this.lists[0].hasOwnProperty('last_url')) {
                this.last_url = this.lists[0].last_url
              } else {
                this.last_url = this.category_url
              }
            }
          })
        },
        goBack () {
          this.$router.back()
        },
        changePage (url) {
          if (this.$store.state.isLoading) return false
          this.getLists(url)
        },
        scrollToTop () {
          window.scroll(0, 0)
        },
        setCategoryUrl () {
          this.$store.state.current_category_url = this.category_url
        },
      },
      mounted () {
        this.category_name = this.$route.query.category_name
        this.category_url = this.$store.state.current_category_url || this.$route.query.category_url
        this.getLists(this.category_url)
      },
      watch: {
        'lists': 'scrollToTop',
        'category_url': 'setCategoryUrl',
      }
    }
</script>

<style scoped>

</style>
