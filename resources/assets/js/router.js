export default function(router) {
    router.redirect({
        '*': '/'
    });

    router.map({
        '/': {
            name: 'index',
            component: require('./components/Index.vue')
        },
        '/categories': {
            name: 'categories',
            component: require('./components/Category.vue'),
            subRoutes: {
                '/': {
                    component: require('./components/CategoryList.vue')
                },
                '/:hashid/edit': {
                    name: 'categoryEdit',
                    component: require('./components/CategoryEdit.vue')
                },
                '/create': {
                    name: 'categoryCreate',
                    component: require('./components/CategoryCreate.vue')
                }
            }
        },
        '/tags': {
            name: 'tags',
            component: require('./components/Tag.vue'),
            subRoutes: {
                '/': {
                    component: require('./components/TagList.vue')
                },
                '/:hashid/edit': {
                    name: 'tagEdit',
                    component: require('./components/TagEdit.vue')
                },
                '/create': {
                    name: 'tagCreate',
                    component: require('./components/TagCreate.vue')
                }
            }
        },
        '/articles': {
            name: 'articles',
            component: require('./components/Article.vue'),
            subRoutes: {
                '/': {
                    component: require('./components/ArticleList.vue')
                },
                '/:hashid/edit': {
                    name: 'articleEdit',
                    component: require('./components/ArticleEdit.vue')
                },
                '/create': {
                    name: 'articleCreate',
                    component: require('./components/ArticleCreate.vue')
                }
            }
        },
        '/photos': {
            name: 'photos',
            component: require('./components/Photo.vue')
        },
    });
}
