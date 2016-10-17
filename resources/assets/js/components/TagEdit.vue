

<template>

<form @submit.prevent="updateTag(tag)" class="form-inline" role="form">

    <div class="form-group">
        <label class="sr-only" for="tag-edit">名称：</label>
        <input v-model="tag.name" type="text" class="form-control" id="tag-edit" placeholder="分类名称">
    </div>

    <button type="submit" class="btn btn-default">保存</button>
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
        created() {
            this.fecthTag();
        },
        methods: {
            fecthTag: function() {
                let itemId = this.$route.params.hashid;
                this.$http.get('/api/tags/' + itemId).then(function(response) {
                    this.$set('tag', response.data);
                });
            },
            updateTag: function(tag) {
                this.$http.put('/api/tags/' + tag.id, tag).then(function(response) {
                    if(response.data == 1){
                        swal('操作成功','您成功修改了一条数据','success');
                        this.$router.go('/tags/');
                    }else{
                        swal('操作失败','请重试','error');
                    }
                });
            }
        }
}

</script>
