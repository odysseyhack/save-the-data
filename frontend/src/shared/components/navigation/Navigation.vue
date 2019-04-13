<template>
<div class="sidebar">
    <div class="sidebar-wrapper">
        <div class="logo">
            <span class="simple-text logo-normal">
                firesync
            </span>
        </div>
        <navigation-links></navigation-links>
    </div>
</div>
</template>        
<script>
import NavigationLinks from '@/shared/components/navigation/links/NavigationLinks';

export default {
    name : "navigation",
    components : {
        NavigationLinks
    },

}
</script>
