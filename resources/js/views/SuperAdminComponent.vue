<template>
  <v-app id="inspire">
    <v-navigation-drawer v-model="drawer" app clipped>
      <v-list dense>
        <v-list-item v-for="item in items" :key="item.key" link :to="item.action">
          <v-list-item-icon>
            <v-icon>{{item.icon}}</v-icon>
          </v-list-item-icon>
          <v-list-item-title>{{item.text}}</v-list-item-title>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>

    <v-app-bar app clipped-left>
      <v-app-bar-nav-icon @click.stop="drawer = !drawer" />
      <v-toolbar-title>Recruitment</v-toolbar-title>
      <v-spacer />
      <v-btn @click="logout">Logout</v-btn>
    </v-app-bar>
    <v-content>
      <v-container>
        <router-view></router-view>
      </v-container>
    </v-content>
  </v-app>
</template>

<script>
export default {
  props: {
    source: String
  },
  data: () => ({
    drawer: null,
    items: [
      {
        icon: "mdi-view-dashboard",
        text: "Dashboard",
        action: "/super_admin/#"
      },
      {
        icon: "mdi-account-details",
        text: "Roles",
        action: "/super_admin/roles"
      }
    ]
  }),
  created() {
    this.$vuetify.theme.dark = true;
  },
  methods: {
    logout() {
      localStorage.removeItem("token");
      this.$router
        .push("/login")
        .then(res => {
          console.log("Logout Successfully");
        })
        .catch(res => {
          console.log(err);
        });
    }
  }
};
</script>
