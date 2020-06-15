<template>
  <v-app id="inspire">
    <v-navigation-drawer v-model="drawer" app clipped>
      <v-list>
        <v-list-item v-if="smallWidth">
          <v-list-item-icon>
              <v-icon @click="drawer = false">mdi-close</v-icon>
          </v-list-item-icon>
        </v-list-item>
        <v-list-item
          v-for="item in items"
          :key="item.key"
          link
          :to="item.action"
          active-class="border"
        >
          <v-list-item-icon class="font-weight-bold">
            <v-icon>{{item.icon}}</v-icon>
          </v-list-item-icon>
          <v-list-item-title>{{item.text}}</v-list-item-title>
        </v-list-item>
        <v-list-item @click="logout">
          <v-list-item-icon class="font-weight-bold">
            <v-icon>mdi-logout</v-icon>
          </v-list-item-icon>
          <v-list-item-title>Logout</v-list-item-title>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>

    <v-app-bar app clipped-left :color="appTheme">
      <v-app-bar-nav-icon class="white--text" @click.stop="drawer = !drawer" />
      <v-toolbar-title>
        <span class="title white--text">Recruitment</span>
      </v-toolbar-title>
      <v-spacer />
      <v-row align="center" style="max-width: 320px">
        <v-spacer />
        <router-link to="/user/requesting">
          <v-btn icon>
            <v-icon class="white--text">mdi-plus</v-icon>
          </v-btn>
        </router-link>
        <v-btn icon @click="changeTheme">
          <v-icon
            class="white--text"
            v-if="this.$vuetify.theme.dark === false"
          >mdi-white-balance-sunny</v-icon>
          <v-icon v-else>mdi-moon-waxing-crescent</v-icon>
        </v-btn>
      </v-row>
    </v-app-bar>

    <v-content>
      <v-container fluid>
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
    drawer: false,
    theme: false,
    smallWidth: true,
    appTheme: "blue",
    items: [
      {
        icon: "mdi-view-dashboard",
        text: "Dashboard",
        action: "/hr/dashboard"
      },

      {
        icon: "mdi-account-clock",
        text: "Pending Applicants",
        action: "/hr/pending"
      },

      {
        icon: "mdi-account-network",
        text: "Screening Section",
        action: "/hr/screening"
      },
      {
        icon: "mdi-folder-clock",
        text: "Requirements Section",
        action: "/hr/requirements"
      },
      {
        icon: "mdi-account-tie",
        text: "Applicants",
        action: "/hr/applicants"
      },
      {
        icon: "mdi-format-list-checkbox",
        text: "Request",
        action: "/hr/mpr"
      }
    ]
  }),
  created() {
    this.$vuetify.theme.dark = false;
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
    this.handleView();
    window.addEventListener("resize", this.handleView);
  },
  methods: {
    logout() {
      this.$store.commit("logout");
      this.$router.push("/login");
    },
    handleView() {
      this.smallWidth = window.innerWidth <= 960;
    },
    changeTheme() {
      this.$vuetify.theme.dark = !this.$vuetify.theme.dark;
      if (this.$vuetify.theme.dark == true) {
        this.appTheme = "";
      } else {
        this.appTheme = "blue";
      }
    }
  },
  watch: {
    theme: function(old, newval) {
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
  border-left: 5px solid #2196f3;
  color: #2196f3;
}
</style>
