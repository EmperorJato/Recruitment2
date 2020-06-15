<template>
  <v-app>
    <router-view></router-view>
  </v-app>
</template>

<script>
export default {
  name: 'App',
  mounted() {
    console.log("Component mounted.");
  }
};
</script>
