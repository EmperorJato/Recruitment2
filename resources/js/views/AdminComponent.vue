<template>
  <v-app id="inspire">
    <v-navigation-drawer v-model="drawer" app clipped expand-on-hover>
      <v-list>
        <v-list-item v-for="item in items" :key="item.key" link :to="item.action" active-class="border">
          <v-list-item-icon>
            <v-icon>{{item.icon}}</v-icon>
          </v-list-item-icon>
          <v-list-item-title>{{item.text}}</v-list-item-title>
        </v-list-item>
        <v-list-item @click="logout">
          <v-list-item-icon>
            <v-icon>mdi-logout</v-icon>
          </v-list-item-icon>
          <v-list-item-title>Logout</v-list-item-title>
        </v-list-item>
                 <v-list-item>
          <v-list-item-title>
            <v-switch v-model="theme" class="ma-4" label="Dark Theme"></v-switch>
          </v-list-item-title>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>

    <v-app-bar app clipped-left>
      <v-app-bar-nav-icon @click.stop="drawer = !drawer" />
      <v-toolbar-title class="mr-12 align-center">
        <span class="title">Recruitment</span>
      </v-toolbar-title>
      <v-spacer />
      <v-row align="center" style="max-width: 650px">
        <v-spacer />
        <router-link to="/user/requesting">
          <v-btn>New Request</v-btn>
        </router-link>
      </v-row>
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
    theme : true,
    items: [
      {
        icon: "mdi-view-dashboard",
        text: "Dashboard",
        action: "/admin/dashboard"
      },

      {
        icon: "mdi-silverware-fork-knife",
        text: "Ribshack",
        action: "/admin/ribshack"
      },

      {
        icon: "mdi-tools",
        text: "Delcom",
        action: "/admin/delcom"
      },

      {
        icon: "mdi-dolly",
        text: "Ramx",
        action: "/admin/ramx"
      },

      {
        icon: "mdi-format-list-checkbox",
        text: "Request",
        action: "/admin/request"
      }
    ]
  }),
  created() {
    this.$vuetify.theme.dark = true;
    if (
      this.$store.state.currentUser == null &&
      !localStorage.getItem("user")
    ) {
      Swal.fire(
        "Error",
        "You have been inactive for too long. Your session has timed out.",
        "error"
      ).then(() => {
        location.reload();
      });
    }
  },
  methods: {
    logout() {
      this.$store.commit("logout");
      this.$router.push("/login");
    }
  },
  watch : {
    theme : function(old, newval){
      this.$vuetify.theme.dark = old;
    }
  }
};
</script>

<style  scoped>
a {
  text-decoration: none;
}

.border {
  border-left: 5px solid #0ba518;
}
</style>
