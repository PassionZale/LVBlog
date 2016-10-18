<style scoped>

#file-content {
    display: none;
}

img#showUploadFile {
    width: 200px;
    height: auto;
    display: block;
    margin: 10px 0 0 10px;
}

</style>

<template>

<!-- v-if 保证Upload组件每次都会重新初始化 -->
<form v-if="isUpload" @submit.prevent="uploadPhoto" class="animated fadeIn" role="form">
    <div class="form-group">
        <label>Alt text:</label>
        <input v-model="uploader.imgText" type="text" class="form-control" placeholder="<img alt='...'/>" required>
    </div>
    <div class="form-group">
        <label>Alt title:</label>
        <input v-model="uploader.imgTitle" type="text" class="form-control" placeholder="<img title='...'/>" required>
    </div>
    <div class="form-group">
        <label>选择图片：</label>
        <button @click="choosePhoto" type="button" class="btn btn-danger" :class="{'disabled' :uploading }">
            <span v-show="uploading">Loading...</span>
            <i v-else="uploading" class="fa fa-plus"></i>
        </button>
        <div v-show="uploader.imgBase64">
            <img :src="uploader.imgBase64" class="img-responsive" id="showUploadFile" />
        </div>
        <input @change="onFileChange" type="file" id="file-content">
    </div>
    <div class="form-group">
        <button class="btn btn-primary btn-link" type="submit">插入博文</button>
        <a @click.prevent="toggleUpload" class="btn btn-default btn-link">取消</a>
    </div>
</form>

</template>

<script>

export default {
    props: {
        isUpload: {
            type: Boolean,
            twoWay: true,
            default: false
        },
        uploader: {
            type: Object,
            twoWay: true,
            default: function() {
                return {
                    data: {
                        imgText: '',
                        imgTitle: '',
                        imgSrc: '',
                        imgBase64: '',
                        imgFinished: false
                    }
                }
            }
        }
    },
    data() {
        return {
            uploading: false
        }
    },
    methods: {
        uploadPhoto: function() {
            this.$set('uploader.imgFinished', true);
        },
        choosePhoto: function() {
            $('#file-content').trigger('click');
        },
        toggleUpload: function() {
            this.isUpload = !this.isUpload;
        },
        onFileChange(e) {
            var vm = this;
            new html5ImgCompress(e.target.files[0], {
                before: function(file) {
                    if (file.type.indexOf('image') <= -1) {
                        swal('操作失败', '请上传.PNG或.JPG格式的文件！', 'error');
                        return false;
                    }
                },
                done: function(base64, file) {
                    vm.$set('uploading', true);
                    var fd = new FormData();
                    fd.append('file', base64);
                    vm.$http.post('/api/upload', fd).then(function(response) {
                        if (response.data.ret_code === 'success') {
                            vm.$set('uploader.imgSrc', response.data.ret_msg);
                            vm.$set('uploader.imgBase64', file);
                        } else {
                            swal('上传失败', '上传至七牛云失败，请重试！', 'error');
                        }
                    });
                    vm.$set('uploading', false);
                },
                fail: function(file) {
                    swal('图片压缩失败', '请重试！', 'error');
                    return false;
                },
                complate: function(file) {
                },
                notSupport: function(file) {
                    swal('无法开启上传功能', '浏览器不支持，请更换高级浏览器！', 'error');
                    return false;
                }
            });
        }
    }
}

</script>
