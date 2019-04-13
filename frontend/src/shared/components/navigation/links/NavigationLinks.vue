<template>
<ul class="nav">

    <router-link to="/demo" tag="li" exact-active-class="active">
        <a>
        <i class="fire-icons icon-app"></i>
        <p>Demo</p>
        </a>
    </router-link>

    <router-link to="/login" tag="li" exact-active-class="active">
        <a>
        <i class="fire-icons icon-button-power"></i>
        <p>Stop</p>
        </a>
    </router-link>

</ul>
</template>

<script>
export default {
  name: 'navigation-links',
};
</script>
