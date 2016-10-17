

<template>

<table class="table">
    <thead>
        <tr>
            <th>序号</th>
            <th>名称</th>
            <th>创建时间</th>
            <th>修改时间</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
        <tr v-for="category of categories.data">
            <td>{{category.id}}</td>
            <td>{{category.name}}</td>
            <td>{{category.created_at}}</td>
            <td>{{category.updated_at}}</td>
            <td>
                <a @click.prevent="deleteCategory(category)" title="删除" class="btn btn-danger"><i class="fa fa-close"></i></a>
                <a v-link="{name:'categoryEdit',params:{'hashid':category.id}}" title="修改" class="btn btn-success"><i class="fa fa-edit"></i></a>
            </td>
        </tr>
    </tbody>
</table>

<nav class=" text-center" v-if="categories.total > categories.per_page">
    <ul class="pagination">
        <li :class="[categories.prev_page_url === null ? 'disabled' : '']">
            <a href="#" @click.prevent="loadPageData(categories.current_page - 1)">&laquo;</a>
        </li>
        <li v-for="n in categories.last_page" :class="{'active':categories.current_page === (n+1)}">
            <a href="#" @click.prevent="loadPageData(n+1)">{{n+1}}</a>
        </li>
        <li :class="[categories.next_page_url === null ? 'disabled' : '']">
            <a href="#" @click.prevent="loadPageData(categories.current_page + 1)">&raquo;</a>
        </li>
    </ul>
</nav>

</template>

<script>

export default {
    data() {
            return {
                categories: {}
            }
        },
        created() {
            this.fetchCategories();
        },
        methods: {
            fetchCategories() {
                    this.$http.get('/api/categories').then(function(response) {
                        this.$set('categories', response.data);
                    });
                },
                deleteCategory(category) {
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
                        self.$http.delete('/api/categories/' + category.id).then(function(response) {
                            if(response.data == 1){
                                self.categories.data.$remove(category);
                                swal('操作成功','您成功删除了一条分类数据','success');
                            }else{
                                swal('操作失败','请重新尝试','error');
                            }
                        });

                    });
                },
                loadPageData(page) {
                    this.$http.get('/api/categories?page=' + page).then(function(response) {
                        this.$set('categories', response.data);
                    });
                }
        }
}

</script>
