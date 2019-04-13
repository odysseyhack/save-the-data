<template>
<ul class="nav">

    <router-link to="/" tag="li" exact-active-class="active">
        <a>
        <i class="fire-icons icon-laptop"></i>
        <p>Statistics</p>
        </a>
    </router-link>

    <router-link to="incidents" tag="li" aexact-active-class="active">
        <a>
        <i class="fire-icons icon-molecule-40"></i>
        <p>Incidents</p>
        </a>
    </router-link>

</ul>
</template>

<script>
export default {
  name: 'navigation-links',
};
</script>
