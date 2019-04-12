<template>
  <div>
    <span style="color:red" v-if="!isOnline">Network connection lost</span>
    <router-view></router-view>
  </div>
</template>
<script>

export default {
  name: "main-app",
};

</script>
<style src='@/assets/style.scss' lang='scss'></style>
