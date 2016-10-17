

<template>

<table class="table">
    <thead>
        <tr>
            <th>序号</th>
            <th>标题</th>
            <th>浏览量</th>
            <th>创建时间</th>
            <th>修改时间</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
        <tr v-for="article of articles.data">
            <td>{{article.id}}</td>
            <td>{{article.title}}</td>
            <td>{{article.views}}</td>
            <td>{{article.created_at}}</td>
            <td>{{article.updated_at}}</td>
            <td>
                <a @click.prevent="deleteArticle(article)" title="删除" class="btn btn-danger"><i class="fa fa-close"></i></a>
                <a v-link="{name:'articleEdit',params:{'hashid':article.id}}" title="修改" class="btn btn-success"><i class="fa fa-edit"></i></a>
            </td>
        </tr>
    </tbody>
</table>

<nav class=" text-center" v-if="articles.total > articles.per_page">
    <ul class="pagination">
        <li :class="[articles.prev_page_url === null ? 'disabled' : '']">
            <a href="#" @click.prevent="loadPageData(articles.current_page - 1)">&laquo;</a>
        </li>
        <li v-for="n in articles.last_page" :class="{'active':articles.current_page === (n+1)}">
            <a href="#" @click.prevent="loadPageData(n+1)">{{n+1}}</a>
        </li>
        <li :class="[articles.next_page_url === null ? 'disabled' : '']">
            <a href="#" @click.prevent="loadPageData(articles.current_page + 1)">&raquo;</a>
        </li>
    </ul>
</nav>

</template>

<script>

export default {
    data() {
            return {
                articles: {}
            }
        },
        created() {
            this.fetchArticles();
        },
        methods: {
            fetchArticles() {
                    this.$http.get('/api/articles').then(function(response) {
                        this.$set('articles', response.data);
                    });
                },
                deleteArticle(article) {
                    let self = this;
                    swal({
                        title: "确定要进行该操作?",
                        text: "操作无法回滚!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        cancelButtonText: "取消",
                        confirmButtonText: "确定",
                        closeOnConfirm: false
                    }, function() {
                        self.$http.delete('/api/articles/' + article.id).then(function(response) {
                            if (response.data == 1) {
                                self.articles.data.$remove(article);
                                swal('操作成功', '您成功删除了一篇文章', 'success');
                            } else {
                                swal('操作失败', '请重新尝试', 'error');
                            }
                        });

                    });
                },
                loadPageData(page) {
                    this.$http.get('/api/articles?page=' + page).then(function(response) {
                        this.$set('articles', response.data);
                    });
                }
        }
}

</script>
