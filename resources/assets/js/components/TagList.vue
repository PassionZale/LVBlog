

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
        <tr v-for="tag of tags.data">
            <td>{{tag.id}}</td>
            <td>{{tag.name}}</td>
            <td>{{tag.created_at}}</td>
            <td>{{tag.updated_at}}</td>
            <td>
                <a @click.prevent="deleteCategory(tag)" title="删除" class="btn btn-danger"><i class="fa fa-close"></i></a>
                <a v-link="{name:'tagEdit',params:{'hashid':tag.id}}" title="修改" class="btn btn-success"><i class="fa fa-edit"></i></a>
            </td>
        </tr>
    </tbody>
</table>

<nav class=" text-center" v-if="tags.total > tags.per_page">
    <ul class="pagination">
        <li :class="[tags.prev_page_url === null ? 'disabled' : '']">
            <a href="#" @click.prevent="loadPageData(tags.current_page - 1)">&laquo;</a>
        </li>
        <li v-for="n in tags.last_page" :class="{'active':tags.current_page === (n+1)}">
            <a href="#" @click.prevent="loadPageData(n+1)">{{n+1}}</a>
        </li>
        <li :class="[tags.next_page_url === null ? 'disabled' : '']">
            <a href="#" @click.prevent="loadPageData(tags.current_page + 1)">&raquo;</a>
        </li>
    </ul>
</nav>

</template>

<script>

export default {
    data() {
            return {
                tags: {}
            }
        },
        created() {
            this.fetchTags();
        },
        methods: {
            fetchTags() {
                    this.$http.get('/api/tags').then(function(response) {
                        this.$set('tags', response.data);
                    });
                },
                deleteCategory(tag) {
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
                        self.$http.delete('/api/tags/' + tag.id).then(function(response) {
                            if(response.data == 1){
                                self.tags.data.$remove(tag);
                                swal('操作成功','您成功删除了一条标签数据','success');
                            }else{
                                swal('操作失败','请重新尝试','error');
                            }
                        });

                    });
                },
                loadPageData(page) {
                    this.$http.get('/api/tags?page=' + page).then(function(response) {
                        this.$set('tags', response.data);
                    });
                }
        }
}

</script>
