<template>
  <v-app id="inspire">
    <v-content>
      <v-container class="fill-height" fluid>
        <v-row align="center" justify="center">
          <v-col cols="12" sm="8" md="4">
            <v-card class="elevation-12">
              <v-form autocomplete="off" ref="form" @submit.prevent="authenticate" v-model="valid">
              <v-toolbar color="grey darken-3" dark flat>
                <v-spacer />
                <v-toolbar-title>RECRUITMENT</v-toolbar-title>
                <v-spacer />
              </v-toolbar>
              <v-card-text>
                <v-progress-linear
                  :active="loading"
                  :indeterminate="loading"
                  absolute
                  top
                  color="blue darken-4"
                ></v-progress-linear>
                  <v-text-field
                    v-model="form.email"
                    label="Email"
                    name="email"
                    prepend-inner-icon="mdi-account-circle"
                    type="email"
                    outlined
                    :rules="emailRules"
                    required
                  ></v-text-field>

                  <v-text-field
                    v-model="form.password"
                    label="Password"
                    name="password"
                    prepend-inner-icon="mdi-lock"
                    type="password"
                    outlined
                    :rules="passwordRules"
                    required
                  />
              </v-card-text>
              <v-card-actions class="justify-center">
                <v-btn
                  class="white--text"
                  color="grey darken-3"
                  block
                  @click="authenticate"
                  :disabled="!valid"
                >
                  <v-icon left>mdi-login</v-icon>Login
                </v-btn>
              </v-card-actions>
              </v-form>
            </v-card>
          </v-col>
        </v-row>
      </v-container>
    </v-content>
  </v-app>
</template>

<script>
import { login } from "../helpers/auth";
export default {
  props: {
    source: String
  },

  data() {
    return {
      valid: true,
      form: new Form({
      email: "",
      password: "",
      }),
      emailRules: [
        v => !!v || "Email is required",
      ],
      passwordRules: [v => !!v || "Password is required"],
      loading: false,
    };
  },
  created() {
    this.$vuetify.theme.dark = true;
  },
  methods: {
    authenticate() {
      this.$store.dispatch("login");
      this.loading = true;
      login(this.$data.form)
        .then(res => {
          this.loading = false;
          this.$store.commit("loginSuccess", res);
          if (res.user.role == "admin") {
            this.$router.push("/");
          } else {
            this.$router.push("/");
          }
        })
        .catch(err => {
          this.loading = false;
          Swal.fire({
            icon: "error",
            title: "Failed",
            text: err
          });
        });
    }
  }
};
</script>

<style scoped>
</style>