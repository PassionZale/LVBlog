

<template>
<form @submit.prevent="createTag(tag)" class="form-inline" role="form">

    <div class="form-group">
        <label class="sr-only" for="tag-edit">名称：</label>
        <input v-model="tag.name" type="text" class="form-control" id="tag-edit" placeholder="标签名称">
    </div>

    <button type="submit" class="btn btn-default">新建</button>
    <a v-link="{name:'tags'}" class="btn btn-primary btn-link">返回</a>
</form>
</template>

<script>
export default {
    data() {
        return {
            tag: {}
        }
    },
    methods: {
        createTag: function(tag) {
            this.$http.post('/api/tags' , tag).then(function(response) {
                if (response.data == 1) {
                    swal('操作成功', '您成功新增了一条数据', 'success');
                    this.$router.go('/tags/');
                } else {
                    swal('操作失败', '请重试', 'error');
                }
            });
        }
    }
}
</script>
