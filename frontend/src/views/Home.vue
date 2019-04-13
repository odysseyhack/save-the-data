<template>
    <div class="wrapper">
        <navigation></navigation>
        <div class="content">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
import Navigation from '@/shared/components/navigation/Navigation';
import Loading from '@/shared/components/loading/Loading.vue';

export default {
  name: 'home',
  components: {
    Navigation,
    Loading,
  },
};
</script>
<style src='@/assets/style.scss' lang='scss'></style>
