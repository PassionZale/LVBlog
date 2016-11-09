<style scoped>

textarea {
    min-height: 500px;
}

</style>

<template>

<form @submit.prevent="createArticle(article)" role="form" v-show="!showUploader">
    <div v-show="isFullScreen == false">

        <div class="form-group">
            <label for="title">标题：</label>
            <input v-model="article.title" type="text" class="form-control" id="title" placeholder="文章标题">
        </div>
        <div class="form-group">
            <label for="desc">描述：</label>
            <input v-model="article.desc" type="text" class="form-control" id="desc" placeholder="文章描述">
        </div>
        <div class="form-group">
            <label>分类：</label>
            <div class="btn-group btn-group-sm">
                <button :class="{'btn-primary':article.categorySelected === category}" @click="toggleCategory(category)" v-for="category in categories.data" class="btn btn-default" type="button">
                    {{category.name}}
                </button>
                <div style="margin-left:10px;" class="btn-group btn-group-sm" v-if="categories.total > categories.per_page">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                        第{{categories.current_page}}页
                        <span class="fa fa-arrow-down"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu" style="min-width:0;">
                        <li :class="[categories.prev_page_url === null ? 'disabled' : '']">
                            <a href="#" @click.prevent="loadCategoryPageData(categories.current_page - 1)">&laquo;</a>
                        </li>
                        <li v-for="n in categories.last_page" :class="{'active':categories.current_page === (n+1)}">
                            <a href="#" @click.prevent="loadCategoryPageData(n+1)">{{n+1}}</a>
                        </li>
                        <li :class="[categories.next_page_url === null ? 'disabled' : '']">
                            <a href="#" @click.prevent="loadCategoryPageData(categories.current_page + 1)">&raquo;</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>标签：</label>
            <div class="btn-group btn-group-sm">
                <button :class="{'btn-primary':tag.isSelected == true}" @click="toggleTag(tag)" v-for="tag in tags.data" class="btn btn-default" type="button">
                    {{tag.name}}
                </button>
                <div style="margin-left:10px;" class="btn-group btn-group-sm" v-if="tags.total > tags.per_page">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                        第{{tags.current_page}}页
                        <span class="fa fa-arrow-down"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu" style="min-width:0;">
                        <li :class="[tags.prev_page_url === null ? 'disabled' : '']">
                            <a href="#" @click.prevent="loadTagPageData(tags.current_page - 1)">&laquo;</a>
                        </li>
                        <li v-for="n in tags.last_page" :class="{'active':tags.current_page === (n+1)}">
                            <a href="#" @click.prevent="loadTagPageData(n+1)">{{n+1}}</a>
                        </li>
                        <li :class="[tags.next_page_url === null ? 'disabled' : '']">
                            <a href="#" @click.prevent="loadTagPageData(tags.current_page + 1)">&raquo;</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>

    <div class="form-group">
        <label for="editor">内容：</label>
        <button @click="fullScreen" type="button" class="btn btn-primary btn-link">
            {{ isFullScreen ? "最小化" : "最大化" }}
        </button>
        <button @click="uploadPhoto" type="button" class="btn btn-primary btn-link">插入图片</button>
        <button @click="renderPreview" type="button" class="btn btn-primary btn-link">预览</button>
        <textarea id="editor" v-model="article.content" class="form-control" placeholder="好记性不如烂笔头，start writing..."></textarea>
    </div>
    <button type="submit" class="btn btn-default">保存</button>
    <a v-link="{name:'articles'}" class="btn btn-primary btn-link">返回</a>
</form>

<dialog :title="article.title ? article.title : '还未设置标题' " :show.sync="showDialog" :close-when-ok="true">
    {{{renderedMarkdown}}}
</dialog>

<upload :is-upload.sync="showUploader" :uploader.sync="uploader"></upload>

</template>

<script>

import Dialog from './common/Dialog.vue'
import Upload from './common/Upload.vue'
export default {
    data() {
            return {
                article: {
                    title: '',
                    desc: '',
                    content: '',
                    categorySelected: {},
                    tagSelected: []
                },
                categories: {},
                tags: {},
                renderedMarkdown: '',
                showDialog: false,
                isFullScreen: false,
                showUploader: false,
                uploader: {}
            }
        },
        components: {
            Dialog, Upload
        },
        created() {
            this.loadCategoryPageData();
            this.loadTagPageData();
        },
        watch: {
            'uploader': {
                handler: function(val, oldVal) {
                    if (this.uploader.imgFinished) {
                        this.$set('showUploader', false);
                        this.article.content += "\n\n![" + this.uploader.imgText + "](" + this.uploader.imgSrc + " '" + this.uploader.imgTitle + "')";
                        this.$set('uploader', {});
                    }
                },
                deep: true
            }
        },
        methods: {
            loadCategoryPageData(page = 1) {
                    let self = this;
                    self.$http.get('/api/categories?page=' + page).then(function(response) {
                        self.$set('categories', response.data);
                        if (self.article.categorySelected != '') {
                            let itemId = self.article.categorySelected.id;
                            $.each(self.categories.data, function(index, item) {
                                if (item.id === itemId) {
                                    self.toggleCategory(self.categories.data[index]);
                                    return;
                                }
                            });
                        }
                    });
                },
                loadTagPageData(page = 1) {
                    let self = this;
                    self.$http.get('/api/tags?page=' + page).then(function(response) {
                        let tagCollection = self.article.tagSelected;
                        let tagData = response.data;
                        $.each(tagData.data, function(i, item) {
                            item.isSelected = false;
                            tagData.data[i] = item;
                        });

                        if (tagCollection.length > 0) {
                            $.each(tagData.data, function(i, item) {
                                self.checkTag(tagData.data[i]);
                            });
                        }
                        self.$set('tags', tagData);
                    });
                },
                checkTag: function(tag) {
                    let self = this;
                    let tagCollection = self.article.tagSelected;
                    tag.isSelected = false;
                    $.each(tagCollection, function(i, item) {
                        if ((tag.id === item.id) && !tag.isSelected) {
                            tag.isSelected = true;
                        }
                    });
                },
                toggleCategory: function(category) {
                    this.article.categorySelected != category ?
                        this.$set('article.categorySelected', category) :
                        this.$set('article.categorySelected', '');
                },
                toggleTag: function(tag) {
                    if (tag.isSelected) {
                        this.article.tagSelected.$remove(tag);
                    } else {
                        this.article.tagSelected.push(tag);
                    }
                    tag.isSelected = !tag.isSelected;
                },
                fullScreen: function() {
                    this.isFullScreen = !this.isFullScreen;
                },
                uploadPhoto: function() {
                    this.showUploader = !this.showUploader;
                    // this.article.content += "\n![Alt text](http://oewvb9bk1.bkt.clouddn.com/image/article/14762526509806.jpg?imageView2/2/w/565/interlace/1/q/50 'Optional title')";
                },
                renderPreview: function() {
                    // markdown to html
                    let self = this;
                    let converter = new showdown.Converter(),
                        text = selft.article.content,
                        html = converter.makeHtml(text);
                    self.renderedMarkdown = html;
                    self.renderedMarkdown != '' ? self.showDialog = true : self.showDialog = false;

                    // $.post('http://gfm-kyanny.sqale.jp/markdown/raw', self.article.content, function(response) {
                    //     self.renderedMarkdown = response;
                    //     self.renderedMarkdown != '' ? self.showDialog = true : self.showDialog = false;
                    // });
                },
                createArticle: function(article) {
                    this.$http.post('/api/articles', article).then(function(response) {
                        if (response.data == 1) {
                            swal('操作成功', '您成功创建了一篇博文', 'success');
                            this.$router.go('/articles/');
                        } else {
                            swal('操作失败', '请重试', 'error');
                        }
                    });
                }
        }
}

</script>
