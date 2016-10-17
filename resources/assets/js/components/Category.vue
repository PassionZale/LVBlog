<style scoped>
a{
    margin-bottom:15px;
}
</style>

<template>

<div class="panel panel-default animated fadeIn">
    <div class="panel-heading">分类管理</div>
    <div class="panel-body">
        <a v-link="{name:'categoryCreate'}" class="btn btn-warning">新建</a>
        <router-view></router-view>
    </div>
</div>

</template>
