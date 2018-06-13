import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    isLoading: false,
    retryText: '加载失败，自动重试中...',
    isRetryShow: false,
    loadingTranslate: {},
    navigator_value: '/bookshelf',
    isLastPage: false,
    current_category_url: '',
    current_get_chapters_url: '',
    books: [],
    source: '',
    categories: [],
  },
  mutations: {
    setLoadingTranslate (state) {
      state.loadingTranslate = {
        x: -30,
        y: -30,
      }
    },
  },
  actions: {

  },
});
