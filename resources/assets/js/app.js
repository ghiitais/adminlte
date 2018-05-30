
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
import VueResource from 'vue-resource';

import Paginate from 'vuejs-paginate'
Vue.component('paginate', Paginate)

Vue.use(VueFroala)
Vue.use(VeeValidate);
Vue.use(VueResource);

Vue.component('collaborateurs', require('./components/Collaborateurs'));
Vue.component('services', require('./components/Services'));

Vue.component('VPaginator', require('vuejs-paginator'));


import Vue from 'vue'
import VueQuillEditor from 'vue-quill-editor'

// require styles
import 'quill/dist/quill.core.css'
import 'quill/dist/quill.snow.css'
import 'quill/dist/quill.bubble.css'

Vue.use(VueQuillEditor, /* { default global options } */)

import ArticlesIndex from './components/ArticlesIndex';
import ArticlesCreate from './components/ArticlesCreate';
import ArticlesEdit from './components/ArticlesEdit';
import ArticleShow from './components/ArticleShow';



import VeeValidate from 'vee-validate';


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

