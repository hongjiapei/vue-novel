import Vue from 'vue'
import Router from 'vue-router'
import Container from '@/components/Container'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      component: Container,
      children: [
        {path: '/', redirect: '/bookshelf'},
        {path: '/bookshelf', component: ()=>import('@/components/Bookshelf'),},
        {path: '/category', component: ()=>import('@/components/Category'),},
        {path: '/search', component: ()=>import('@/components/Search'),},
      ],
    },
    {
      path: '/lists',
      component: ()=>import('@/components/Lists'),
    },
    {
      path: '/detail',
      component: ()=>import('@/components/Detail'),
    },
    {
      path: '/chapters',
      component: ()=>import('@/components/Chapters'),
    },
    {
      path: '/chapter/detail',
      component: ()=>import('@/components/ChapterDetail'),
    },
  ]
})
