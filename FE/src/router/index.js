import Vue from 'vue'
import Router from 'vue-router'
import Index from '@/components/Index'
import mdqh from '@/components/mdqh'
import login from '@/components/login'

Vue.use(Router)
export default new Router({
  //mode:'history',
  routes: [
    {
      path: '/',
      name:'Index',
      component: Index
    },
    {
      path:'/mdqh/:empID/:empName',
      name:'mdqh',
      component:mdqh,
    },
    {
      path:'/login',
      name:'login',
      component:login
    }     
  ]
})

