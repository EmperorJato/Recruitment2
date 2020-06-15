<template>
  <v-app>
    <v-container fill-height>
      <v-row justify="center" align="center">
        <img :src="not_found" />
      </v-row>
    </v-container>
  </v-app>
</template>
<script>
export default {
  data() {
    return {
      not_found: "/img/NotFound.svg"
    };
  },
  created() {
    this.$vuetify.theme.dark = false;
  }
};
</script>

<style scoped>
img {
  width: 500px;
}
</style>