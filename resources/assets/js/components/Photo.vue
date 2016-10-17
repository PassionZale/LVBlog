<style scoped>

#file-content {
    display: none;
}
img{
    cursor: pointer;
}
img#showUploadFile {
    width: 200px;
    height: auto;
    display: block;
    margin: 10px 0 0 10px;
}
button#upload-btn{
    margin-bottom:10px;
}
.thumbnail img{
    width:242px;
    height:220px;
}

</style>

<template>

<div class="panel panel-default animated fadeIn">
    <div class="panel-heading">图片管理</div>
    <div v-show="imgBase64">
        <img :src="imgBase64" class="img-responsive" id="showUploadFile" />
    </div>
    <input @change="onFileChange" id="file-content" type="file">
    <div class="panel-body">
        <button @click="upLoadPhoto" id="upload-btn" class="btn btn-warning" :class="{'disabled' :uploading }">{{ uploading ? '上传中...' : '上传图片'}}</button>
        <div class="row animated fadeIn">
            <div v-for="item in itemList" class="col-sm-6 col-md-4">
                <div class="thumbnail">
                    <img :src="baseUrl+item.key" @click="showUrl(item)"/>
                </div>
            </div>
        </div>
    </div>
</div>

</template>

<script>

export default {
    data() {
            return {
                photo: {},
                imgBase64: '',
                uploading: false,
                itemList: {},
                baseUrl: 'http://oewvb9bk1.bkt.clouddn.com/'
            }
        },
        created() {
            this.fecthPhoto();
        },
        methods: {
            fecthPhoto() {
                    this.$http.get('/api/photos').then(function(response) {
                        this.$set('itemList', response.data);
                    });
                },
                upLoadPhoto() {
                    $('#file-content').trigger('click');
                },
                showUrl(item){
                    swal('',item.key);
                },
                onFileChange(e) {
                    var vm = this;
                    new html5ImgCompress(e.target.files[0], {
                        before: function(file) {
                            // console.log('压缩前...');
                            // 这里一般是对file进行filter，例如用file.type.indexOf('image') > -1来检验是否是图片
                            // 如果为非图片，则return false放弃压缩（不执行后续done、fail、complate），并相应提示
                            if (file.type.indexOf('image') <= -1) {
                                swal('操作失败', '请上传.PNG或.JPG格式的文件！', 'error');
                                return false;
                            }
                        },
                        done: function(base64, file) {
                            // console.log('压缩成功...');
                            // ajax和服务器通信上传base64图片等操作
                            vm.$set('uploading', true);
                            var fd = new FormData();
                            fd.append('file', base64);
                            vm.$http.post('/api/upload', fd).then(function(response) {
                                if (response.data.ret_code === 'success') {
                                    vm.$set('photo', response.data.ret_msg);
                                    vm.$set('imgBase64', file);
                                    swal('上传成功', '已上传至七牛云！', 'success');
                                } else {
                                    swal('上传失败', '上传至七牛云失败，请重试！', 'error');
                                }
                            });
                            vm.$set('uploading', false);
                        },
                        fail: function(file) {
                            // console.log('压缩失败...');
                            swal('图片压缩失败', '请重试！', 'error');
                            return false;
                        },
                        complate: function(file) {
                            // console.log('压缩完成...');
                        },
                        notSupport: function(file) {
                            // console.log('浏览器不支持！')
                            // 不支持操作，例如PC在这里可以采用swfupload上传
                            swal('无法开启上传功能', '浏览器不支持，请更换高级浏览器！', 'error');
                            return false;
                        }
                    });
                }
        }
}

</script>
