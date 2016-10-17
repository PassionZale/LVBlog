

<template>
<form @submit.prevent="createCategory(category)" class="form-inline" role="form">

    <div class="form-group">
        <label class="sr-only" for="category-edit">名称：</label>
        <input v-model="category.name" type="text" class="form-control" id="category-edit" placeholder="分类名称">
    </div>

    <button type="submit" class="btn btn-default">新建</button>
    <a v-link="{name:'categories'}" class="btn btn-primary btn-link">返回</a>
</form>
</template>

<script>
export default {
    data() {
        return {
            category: {}
        }
    },
    methods: {
        createCategory: function(category) {
            this.$http.post('/api/categories' , category).then(function(response) {
                if (response.data == 1) {
                    swal('操作成功', '您成功新增了一条数据', 'success');
                    this.$router.go('/categories/');
                } else {
                    swal('操作失败', '请重试', 'error');
                }
            });
        }
    }
}
</script>
