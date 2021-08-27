import Vue from 'vue'
import Router from 'vue-router'
import Dashboard from "./components/views/Dashboard";
import User from "./components/views/User";


Vue.use(Router)

const routes = [
    {
        path: '/',
        name: 'home',
        component: Dashboard
    },
    {
        path: '/user',
        name: 'user',
        component: User
    },
]

// keep it simple for now.
const router = new Router({
    routes, // short for `routes: routes`
    linkActiveClass: 'active'
})

export default router;
