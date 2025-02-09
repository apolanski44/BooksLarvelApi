import { createRouter, createWebHistory} from "vue-router";
import booksIndex from '../components/books/Index.vue'
import List from '../components/books/List.vue'
import Review from '../components/reviews/Review.vue'
import Edit from '../components/reviews/Edit.vue'
import notFound  from '../components/notFound.vue'
import Login from '../components/auth/Login.vue';
import Register from '../components/auth/Register.vue';
const routes = [
    {
        path:'/books/:bookId/reviews/:reviewId/edit',
        name:'reviews.edit',
        component: Edit
    },
    {
        path:'/',
        name:'books.index',
        component: booksIndex
    },
    {
        path:'/list',
        name:'list',
        component: List
    },
    {
        path:'/books/:id/reviews',
        name:'review',
        component: Review
    },
    {
        path:'/:pathMath(.*)*',
        name:'notfound',
        component: notFound
    },
    {
        path: '/login', 
        name: 'login',
        component: Login
    },
    {
        path: '/register',
        name: 'register',
        component: Register
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router