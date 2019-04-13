<template>
  <div>
    <loading></loading>
    <router-view></router-view>
  </div>
</template>
<script>
import Loading from "@/shared/components/loading/Loading.vue"

export default {
  name: "main-app",
  components : {
    Loading
  },
};
</script>
