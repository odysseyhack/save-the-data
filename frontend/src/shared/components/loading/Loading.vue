<template>
     <transition name="fade">
    <div v-if="loading" class="loader">
        <machine-learning-icon id="loader-icon" :fill="'#fff'" :secondaryfill="'#333'" :width="'100px'" :height="'100px'"></machine-learning-icon>
    </div>
     </transition>
</template>
<script>
import MachineLearningIcon from "@/shared/components/icons/MachineLearningIcon";

export default {
  name: "loading",
  components: {
    MachineLearningIcon
  },
  computed: {
    loading() {
      return this.$store.state.general.loading;
    }
  }
};
</script>

