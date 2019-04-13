<template>
    <div class="wrapper">
        <div class="sidebar">
            <div class="sidebar-wrapper">
                <div class="logo">
                    <span class="simple-text logo-normal">
                        firesync
                    </span>
                </div>
                <navigation></navigation>
            </div>
        </div>
        <div class="content">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
import Navigation from '@/shared/components/navigation/Navigation';
import Loading from "@/shared/components/loading/Loading.vue"

export default {
    name: "home",
    components : {
       Navigation,
       Loading
    }
};
</script>
<style src='@/assets/style.scss' lang='scss'></style>
