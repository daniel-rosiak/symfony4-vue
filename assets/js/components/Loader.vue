<template>
    <div class="loader-container" v-show="loading"><div class="loader"></div></div>
</template>


<script>
export default {
    props: {
        loading: {
          type: Boolean,
          default: false
        }
   }
}
</script>