<template>
  <v-app>
    <v-container>
      <v-row justify="center">
        <v-col cols="12" sm="12" md="12">
          <v-card class="elevation-12">
            <v-form autocomplete="off" ref="form" @submit.prevent="savePost">
              <v-toolbar color="grey darken-3" dark flat>
                <v-toolbar-title>NEW REQUEST</v-toolbar-title>
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
                <v-row justify="center">
                  <v-col cols="12" sm="12" md="6">
                    <v-text-field
                      v-model="form.requesting"
                      label="Requesting"
                      name="requesting"
                      :error-messages="errors.first('requesting')"
                      v-validate="'required'"
                      data-vv-name="requesting"
                      data-vv-as="Requesting"
                      :rules="formRules.requiredRules"
                      prepend-inner-icon="mdi-account-circle"
                      type="text"
                      outlined
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="12" md="6">
                    <v-text-field
                      v-model="form.num_request"
                      label="Total"
                      prepend-inner-icon="mdi-counter"
                      :rules="formRules.intRules"
                      :error-messages="errors.first('num_request')"
                      v-validate="'required'"
                      data-vv-name="num_request"
                      data-vv-as="Total Request"
                      outlined
                    ></v-text-field>
                  </v-col>
                </v-row>
                <v-row justify="center">
                  <v-col cols="12" sm="12" md="6">
                    <v-text-field
                      v-model="form.branch_location"
                      :rules="formRules.requiredRules"
                      label="Branch Location (City)"
                      name="branch_location"
                      prepend-inner-icon="mdi-city"
                      :error-messages="errors.first('branch_location')"
                      v-validate="'required'"
                      data-vv-name="branch_location"
                      data-vv-as="Branch Location"
                      outlined
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="12" md="6">
                    <v-text-field
                      v-model="form.branch_position"
                      :rules="formRules.requiredRules"
                      label="Branch Position"
                      name="branch_position"
                      prepend-inner-icon="mdi-map-marker"
                      :error-messages="errors.first('branch_position')"
                      v-validate="'required'"
                      data-vv-name="branch_position"
                      data-vv-as="Branch Position"
                      outlined
                    ></v-text-field>
                  </v-col>
                </v-row>
                <v-row justify="center">
                  <v-col cols="12" sm="12" md="6">
                    <v-select
                      :items="request_items"
                      :rules="formRules.requiredRules"
                      v-model="form.type_request"
                      label="Request Type"
                      prepend-inner-icon="mdi-account-question"
                      :error-messages="errors.first('type_request')"
                      v-validate="'required'"
                      data-vv-name="type_request"
                      data-vv-as="Type Request"
                      outlined
                    ></v-select>
                  </v-col>
                  <v-col cols="12" sm="12" md="6">
                    <v-select
                      :items="employment_items"
                      v-model="form.type_employment"
                      :rules="formRules.requiredRules"
                      label="Employment Type"
                      prepend-inner-icon="mdi-account-box"
                      :error-messages="errors.first('type_employment')"
                      v-validate="'required'"
                      data-vv-name="type_employment"
                      data-vv-as="Type Employment"
                      outlined
                    ></v-select>
                  </v-col>
                </v-row>
                <v-row justify="center">
                  <v-col cols="12" sm="12" md="6">
                    <v-select
                      :items="experience_items"
                      v-model="form.work_exp"
                      :rules="formRules.requiredRules"
                      label="Work Experience"
                      prepend-inner-icon="mdi-folder-account"
                      :error-messages="errors.first('work_exp')"
                      v-validate="'required'"
                      data-vv-name="work_exp"
                      data-vv-as="Work Experience"
                      outlined
                    ></v-select>
                  </v-col>
                  <v-col cols="12" sm="12" md="6">
                    <v-text-field
                      v-model="form.salary_rate"
                      label="Salary Rate"
                      prepend-inner-icon="mdi-account-cash"
                      :rules="formRules.intRules"
                      :error-messages="errors.first('salary_rate')"
                      v-validate="'required'"
                      data-vv-name="salary_rate"
                      data-vv-as="Salary Rate"
                      outlined
                    ></v-text-field>
                  </v-col>
                </v-row>
                <v-row justify="center">
                  <v-col cols="12" sm="12" md="6">
                    <v-select
                      :items="company_items"
                      :rules="formRules.requiredRules"
                      v-model="form.company"
                      label="Company"
                      prepend-inner-icon="mdi-domain"
                      :error-messages="errors.first('company')"
                      v-validate="'required'"
                      data-vv-name="company"
                      data-vv-as="Company"
                      outlined
                    ></v-select>
                  </v-col>
                  <v-col cols="12" sm="12" md="6">
                    <v-select
                      :items="urgent_items"
                      :rules="formRules.requiredRules"
                      v-model="form.urgent"
                      label="Urgent"
                      prepend-inner-icon="mdi-calendar-question"
                      :error-messages="errors.first('urgent')"
                      v-validate="'required'"
                      data-vv-name="urgent"
                      data-vv-as="Urgent"
                      outlined
                    ></v-select>
                  </v-col>
                </v-row>
              </v-card-text>
              <v-card-actions class="justify-center">
                <v-btn
                  v-if="this.$route.params.id"
                  @click="editRequest($route.params.id)"
                  class="white--text"
                  block
                >
                  <v-icon left>mdi-content-save</v-icon>Save
                </v-btn>
                <v-btn v-else type="submit" class="white--text" block>
                  <v-icon left>mdi-content-save</v-icon>Submit
                </v-btn>
              </v-card-actions>
            </v-form>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </v-app>
</template>

<script>
import { mask } from "vue-the-mask";

export default {
  $_veeValidate: {
    validator: "new"
  },

  directives: {
    mask
  },

  data() {
    return {
      valid: true,
      loading: false,
      edit_request: {},
      form: new Form({
        requesting: "",
        num_request: "",
        branch_location: "",
        branch_position: "",
        type_request: "",
        type_employment: "",
        work_exp: "",
        salary_rate: "",
        company: "",
        urgent: ""
      }),
      formRules: {
        requiredRules: [v => !!v || "This field is required"],
        intRules: [
          v => !!v || "Total field is required",
          v => Number.isInteger(Number(v)) || "Numbers Only"
        ]
      },
      employment_items: ["Contractual", "Probationary", "Training"],
      request_items: ["Additional", "Replacement"],
      experience_items: ["With Experience", "Without Experience"],
      company_items: ["DELCOM", "RIBSHACK", "RAMX"],
      urgent_items: ["Yes", "No"]
    };
  },
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
    savePost() {
      this.$validator.validate().then(valid => {
        this.form
          .post("/api/requesting")
          .then(res => {
            Swal.fire({
              icon: "success",
              title: "Success",
              text: "Save Successfully"
            }).then(() => {
              this.$router.push("/user/requested");
            });
          })
          .catch(() => {
            this.$el
              .querySelector(
                '[data-vv-name="' + this.$validator.errors.items[0].field + '"]'
              )
              .scrollIntoView({
                behavior: "smooth",
                block: "center",
                inline: "center"
              });
          });
      });
    },
    fetchRequest(id) {
      axios
        .get("/api/edit_request/" + id)
        .then(res => {
          Vue.set(this.$data, "edit_request", res.data.edit_request);
          this.form.fill(this.edit_request);
        })
        .catch(err => {
          console.log(err);
        });
    },
    editRequest(id) {
      this.form
        .patch("/api/edit/requesting/" + id)
        .then(res => {
          Swal.fire({
            icon: "success",
            title: "Success",
            text: "Save Successfully"
          }).then(() => {
            this.$router.push("/user/requested");
          });
        })
        .catch(err => {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: err
          });
        });
    }
  },
  mounted() {
    var id = this.$route.params.id;
    if (id) {
      this.fetchRequest(id);
    }
  }
};
</script>

<style scoped>
</style>