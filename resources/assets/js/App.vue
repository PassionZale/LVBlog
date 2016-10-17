

<template>

<nav-bar :user=user>

</nav-bar>

<div class="container">
    <div class="row">
        <div class="col-sm-3 col-md-2">
            <side-bar></side-bar>
        </div>
        <div class="col-sm-9 col-md-10">
            <router-view></router-view>
        </div>
    </div>
</div>

</template>

<script>

import NavBar from './components/layout/Navbar.vue'
import SideBar from './components/layout/Sidebar.vue'

export default {
    components: {
        NavBar,SideBar
    },
    replace: false,
    data() {
        return {
            user: USER
        }
    }

}

</script>
