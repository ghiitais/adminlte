
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router';

window.Vue.use(VueRouter);

// Require Froala Editor js file.
require('froala-editor/js/froala_editor.pkgd.min')

// Require Froala Editor css files.
require('froala-editor/css/froala_editor.pkgd.min.css')
require('font-awesome/css/font-awesome.css')
require('froala-editor/css/froala_style.min.css')

// Import and use Vue Froala lib.
import VueFroala from 'vue-froala-wysiwyg'
Vue.use(VueFroala)

Vue.component('collaborateurs', require('./components/Collaborateurs'));

import ArticlesIndex from './components/ArticlesIndex';
import ArticlesCreate from './components/ArticlesCreate';
import ArticlesEdit from './components/ArticlesEdit';
import ArticleShow from './components/ArticleShow';


const routes = [
    {
        path: '/',
        components: {
            articlesIndex: ArticlesIndex
        }
    },
    {path: '/create', component: ArticlesCreate, name: 'createArticle'},
    {path: '/edit/:id', component: ArticlesEdit, name: 'editArticle'},
    {path: '/show/:id', component: ArticleShow, name: 'showArticle'},
]

const router = new VueRouter({ routes })

const app = new Vue({ router }).$mount('#app')

