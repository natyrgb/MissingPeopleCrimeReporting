import Vue from 'vue'
import Router from 'vue-router'
import store from './store'
import Login from './components/Login'
import Logout from './components/Logout'
import Register from './components/Register'
import Home from './components/Home'
import MissingPeople from './components/MissingPeople'
import MakeComplaint from './components/MakeComplaint'
import ReportMissing from './components/ReportMissing'
import NewsFeed from './components/NewsFeed'
import WantedCriminals from './components/WantedCriminals'
import MyComplaints from './components/MyComplaints'
import MyMissing from './components/MyMissing'

Vue.use(Router)

let router = new Router({
    mode: 'history',
    routes: [
        {
            path: '/api',
            name: 'home',
            component: Home
        },
        {
            path: '/api/missing_people',
            name: 'missing_people',
            component: MissingPeople
        },
        {
            path: '/api/news_feed',
            name: 'news_feed',
            component: NewsFeed
        },
        {
            path: '/api/wanted_criminals',
            name: 'wanted_criminals',
            component: WantedCriminals
        },
        {
            path: '/api/login',
            name: 'login',
            component: Login
        },
        {
            path: '/api/register',
            name: 'register',
            component: Register
        },
        {
            path: '/api/logout',
            name: 'logout',
            component: Logout,
            meta: {
                requiresAuth: true
            }
        },
        {
            path: '/api/make_complaint',
            name: 'make_complaint',
            component: MakeComplaint,
            meta: {
                requiresAuth: true
            }
        },
        {
            path: '/api/report_missing',
            name: 'report_missing',
            component: ReportMissing,
            meta: {
                requiresAuth: true
            }
        },
        {
            path: '/api/my_complaints',
            name: 'my_complaints',
            component: MyComplaints,
            meta: {
                requiresAuth: true
            }
        },
        {
            path: '/api/my_missing_people',
            name: 'my_missing_people',
            component: MyMissing,
            meta: {
                requiresAuth: true
            }
        },
    ]
})
router.beforeEach((to, from, next) => {
    if(to.matched.some(record => record.meta.requiresAuth)) {
      if (store.getters.isLoggedIn) {
        next()
        return
      }
      next('/api/login')
    } else {
      next()
    }
})

export default router
