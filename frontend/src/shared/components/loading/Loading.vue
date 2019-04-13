<template>
     <transition name="fade">
    <div v-if="loading" class="loader">
        <machine-learning-icon id="loader-icon" :fill="'#fff'" :secondaryfill="'#333'" :width="'100px'" :height="'100px'"></machine-learning-icon>
    </div>
     </transition>
</template>
<script>
import MachineLearningIcon from '@/shared/components/icons/MachineLearningIcon';

export default {
  name: 'loading',
  components: {
    MachineLearningIcon,
  },
  computed: {
    loading() {
      return this.$store.state.general.loading;
    },
  },
};
</script>
<style lang="scss">
#loader-icon {
  animation: ckw 5s infinite;
  position: relative;
  left: 50%;
  top: 50%;
}

@keyframes ckw {
  0% {
    transform: rotate(0deg);
  }
  50% {
    transform: rotate(360deg);
  }
  100% {
    transform: rotate(-360deg);
  }
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s;
}
</style>
