<style scoped>

.sidebar {
    text-align: center;
}

.fa {
    display: none;
}


/*vue-router active class*/

a.v-link-active {
    z-index: 2;
    color: #fff;
    background-color: #337ab7;
    border-color: #337ab7;
}

a.v-link-active .fa {
    display: inline-block;
}

</style>

<template>

<div class="list-group sidebar">
    <a v-link="{name:'articles'}" class="list-group-item">
        <i class="fa fa-rocket fa-lg animated fadeIn" aria-hidden="true"></i> 文章管理
    </a>
    <a v-link="{name:'categories'}" class="list-group-item">
        <i class="fa fa-plane fa-lg animated fadeIn" aria-hidden="true"></i> 分类管理
    </a>
    <a v-link="{name:'tags'}" class="list-group-item">
        <i class="fa fa-tags fa-lg animated fadeIn" aria-hidden="true"></i> 标签管理
    </a>
    <a v-link="{name:'photos'}" class="list-group-item">
        <i class="fa fa-photo fa-lg animated fadeIn" aria-hidden="true"></i> 图片管理
    </a>
</div>

</template>
