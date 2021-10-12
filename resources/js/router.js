import Vue from 'vue'
import Router from 'vue-router'
import Dashboard from "./components/views/Dashboard";
import User from "./components/views/User";
import CategoryList from "./components/views/Category/List"
import ProjectList from "./components/views/Projects/List"
import ProjectImage from "./components/views/Projects/ProjectImage";
import TagList from "./components/views/Tags/List"
import axios from "axios";


Vue.use(Router)



const routes = [
    {
        path: '/home',
        name: 'home',
        component: Dashboard,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/user',
        name: 'user',
        component: User,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/category',
        name: 'category',
        component: CategoryList,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/project',
        name: 'project',
        component: ProjectList,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/project-image',
        name: 'project-image',
        component: ProjectImage,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/tag',
        name: 'tag',
        component: TagList,
        meta: {
            requiresAuth: true
        }
    },
]

// keep it simple for now.
const router = new Router({
    routes, // short for `routes: routes`
    linkActiveClass: 'active',
    mode: 'history'
})

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        axios.get('api/check-login')
            .then(response => {
                console.log(response)
                if (response.data.status){
                    next()
                }else {
                    next('/login')
                    location.reload();
                }
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            });
    } else {
        next() // does not require auth, make sure to always call next()!
    }
})

export default router;
