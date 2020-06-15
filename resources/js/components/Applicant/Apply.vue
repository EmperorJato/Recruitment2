<template>
  <v-app>
    <v-dialog v-model="dialog" width="1000px">
      <v-card>
        <v-toolbar color="primary" dark flat>
          <v-toolbar-title>Application Form</v-toolbar-title>
          <v-spacer />
        </v-toolbar>
        <v-card-text>
          <br />
          <h3>Where did you hear about our vacancy?</h3>
          <v-row>
            <v-col cols="12" sm="12">
              <v-select
                :rules="formRules.requiredRules"
                :items="src1"
                label="Where"
                outlined
                v-validate="'required'"
                data-vv-name="app_src1"
                data-vv-as="Where"
                v-model="form.app_src1"
                :error-messages="errors.first('app_src1')"
              ></v-select>
            </v-col>
          </v-row>
          <v-row v-if="form.app_src1 == 'Referred'">
            <v-col cols="12" md="6" sm="12">
              <v-text-field
                outlined
                label="Who reffered you?"
                v-model="form.app_src2"
                :rules="formRules.requiredRules"
                v-validate="'required'"
                data-vv-name="app_sr2c"
                data-vv-as="field"
                :error-messages="errors.first('app_src2')"
              ></v-text-field>
            </v-col>
          </v-row>
          <v-row v-else-if="form.app_src1 == 'Others'">
            <v-col cols="12" md="6" sm="12">
              <v-text-field
                outlined
                label="In what?"
                v-model="form.app_src2"
                :rules="formRules.requiredRules"
                v-validate="'required'"
                data-vv-name="app_src2"
                data-vv-as="field"
                :error-messages="errors.first('app_src2')"
              ></v-text-field>
            </v-col>
          </v-row>
          <h3>Name</h3>
          <v-row align="center" justify="center">
            <v-col cols="12" sm="4">
              <v-text-field
                outlined
                label="First Name"
                v-model="form.app_firstname"
                :error-messages="errors.first('app_firstname')"
                v-validate="'required'"
                data-vv-name="app_firstname"
                :rules="formRules.requiredRules"
                data-vv-as="Firstname"
              ></v-text-field>
            </v-col>
            <v-col cols="12" sm="4">
              <v-text-field outlined label="Middle Name" v-model="form.app_middlename"></v-text-field>
            </v-col>
            <v-col cols="12" sm="4">
              <v-text-field
                outlined
                label="Last Name"
                v-model="form.app_lastname"
                :error-messages="errors.first('app_lastname')"
                v-validate="'required'"
                data-vv-name="app_lastname"
                :rules="formRules.requiredRules"
                data-vv-as="Lastname"
              ></v-text-field>
            </v-col>
          </v-row>
          <h3>Personal Information</h3>
          <v-row align="center" justify="center">
            <v-col cols="12" sm="4">
              <v-text-field
                outlined
                label="Contact"
                v-mask="'####-###-####'"
                v-model="form.app_phone"
                :error-messages="errors.first('app_phone')"
                v-validate="'required'"
                data-vv-name="app_phone"
                :rules="formRules.requiredRules"
                data-vv-as="Phone"
              ></v-text-field>
            </v-col>
            <v-col cols="12" sm="4">
              <v-menu
                ref="menu1"
                v-model="menu1"
                :close-on-content-click="false"
                transition="scale-transition"
                offset-y
                max-width="290px"
                min-width="290px"
              >
                <template v-slot:activator="{ on }">
                  <v-text-field
                    outlined
                    v-model="form.app_birthdate"
                    label="Birth Date"
                    persistent-hint
                    @blur="date = parseDate(form.app_birthdate)"
                    v-on="on"
                    :error-messages="errors.first('app_birthdate')"
                    v-validate="'required'"
                    data-vv-name="app_birthdate"
                    :rules="formRules.requiredRules"
                    data-vv-as="Birthdate"
                  ></v-text-field>
                </template>
                <v-date-picker v-model="date" no-title @input="menu1 = false"></v-date-picker>
              </v-menu>
            </v-col>
            <v-col cols="12" sm="4">
              <v-text-field
                outlined
                label="Email"
                v-model="form.app_email"
                :error-messages="errors.first('app_email')"
                v-validate="'required'"
                data-vv-name="app_email"
                :rules="formRules.requiredRules"
                data-vv-as="Email"
              ></v-text-field>
            </v-col>
          </v-row>
          <v-row align="center">
            <v-col cols="12" sm="4">
              <v-select
                :items="marital_status"
                label="Marital Status"
                outlined
                v-model="form.app_marital_status"
              ></v-select>
            </v-col>
            <v-col cols="12" sm="4">
              <v-select :items="gender" label="Gender" outlined v-model="form.app_gender"></v-select>
            </v-col>
          </v-row>
          <h3>School</h3>
          <v-row>
            <v-col class="d-flex" cols="12" sm="4">
              <v-select
                :items="educational"
                label="Latest Educational Attainment"
                outlined
                v-model="form.app_education"
              ></v-select>
            </v-col>
            <v-col
              class="d-flex"
              cols="12"
              sm="4"
              v-if="form.app_education === 'Senior High School Level' || form.app_education === 'Senior High School Graduate' || form.app_education === 'College Level' || form.app_education === 'College Graduate' || form.app_education === 'Vocational Course Level' || form.app_education === 'Vocational Course Graduate' || form.app_education === 'Post Graduate'"
            >
              <v-text-field label="Course" outlined v-model="form.app_course" name="course"></v-text-field>
            </v-col>
            <v-col class="d-flex" cols="12" sm="4">
              <v-select
                :items="year"
                label="Year Graduated"
                outlined
                v-model="form.app_year_graduated"
              ></v-select>
            </v-col>
          </v-row>
          <h3>Location</h3>
          <v-row align="center" justify="center">
            <v-col cols="12" sm="12">
              <v-textarea
                outlined
                label="Present Address"
                v-model="form.app_p_address"
                :error-messages="errors.first('app_p_address')"
                v-validate="'required'"
                data-vv-name="app_p_address"
                data-vv-as="Present Address"
              ></v-textarea>
            </v-col>
            <v-col cols="12" sm="12">
              <v-textarea outlined label="Home Address" v-model="form.app_h_address"></v-textarea>
            </v-col>
          </v-row>
          <h3>Work Experience</h3>
          <v-row align="center" justify="center">
            <v-col cols="12" sm="6">
              <v-text-field
                outlined
                label="Work"
                v-model="form.work_experience"
                name="work_experience"
              ></v-text-field>
            </v-col>
            <v-col cols="12" sm="3">
              <v-select
                :items="year"
                label="From"
                outlined
                v-model="form.experience_from"
                name="experience_from"
              ></v-select>
            </v-col>
            <v-col cols="12" sm="3">
              <v-select
                :items="year"
                label="To"
                outlined
                v-model="form.experience_to"
                name="experience_to"
              ></v-select>
            </v-col>
          </v-row>
          <h3>Incase of Emergency</h3>
          <v-row align="center" justify="center">
            <v-col cols="12" sm="8">
              <v-text-field outlined label="Person" v-model="form.app_person"></v-text-field>
            </v-col>
            <v-col cols="12" sm="4">
              <v-text-field
                outlined
                label="Contact"
                v-mask="'####-###-####'"
                v-model="form.app_person_phone"
              ></v-text-field>
            </v-col>
            <v-col cols="12" sm="8">
              <v-textarea outlined label="Address" v-model="form.app_person_address"></v-textarea>
            </v-col>
            <v-col cols="12" sm="4">
              <v-select
                :items="relationship"
                label="Relationship"
                outlined
                v-model="form.app_relationship"
              ></v-select>
            </v-col>
          </v-row>
          <v-file-input
            v-model="form.app_resume"
            color="deep-purple accent-4"
            counter
            label="Send Resume"
            placeholder="Select your files"
            prepend-icon="mdi-paperclip"
            outlined
            multiple
            :show-size="1000"
          >
            <template v-slot:selection="{ index, text }">
              <v-chip v-if="index < 2" color="deep-purple accent-4" dark label small>{{ text }}</v-chip>
              <span
                v-else-if="index === 2"
                class="overline grey--text text--darken-3 mx-2"
              >+{{ files.length - 2 }} File(s)</span>
            </template>
          </v-file-input>
          <v-checkbox
            label="I hereby certify that all information written are true and correct."
            color="info"
            value
            hide-details
          ></v-checkbox>
          <br />
        </v-card-text>
        <v-card-actions>
          <v-row align="center" justify="center">
            <v-btn rounded color="primary" dark type="submit" @click="saveApplicant">
              <v-icon left>mdi-account</v-icon>Submit
            </v-btn>
          </v-row>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-app>
</template>

<script>
export default {
    props: ['visible'],
    data() {
    return {
      date: new Date().toISOString().substr(0, 10),
      menu1: false,
      dialog: false,
      loading: true,
      dialogForm: false,
      hr_img: "/img/hr_img.png",
      src1: ["Social Media", "Referred", "Job Fair", "Walk-in", "Others"],
      locations: [],
      positions: [],
      form: new Form({
        app_location: "",
        app_apply: "",
        app_company: "",
        app_src1: "",
        app_src2: "",
        app_firstname: "",
        app_middlename: "",
        app_lastname: "",
        app_phone: "",
        app_birthdate: "",
        app_email: "",
        app_gender: "",
        app_marital_status: "",
        app_education: "",
        app_course: "",
        app_year_graduated: "",
        app_p_address: "",
        app_h_address: "",
        app_person: "",
        app_person_phone: "",
        app_person_address: "",
        app_relationship: "",
        app_resume: []
      }),
      formRules: {
        requiredRules: [v => !!v || "This field is required"],
        intRules: [
          v => !!v || "Total field is required",
          v => Number.isInteger(Number(v)) || "Numbers Only"
        ]
      },
      marital_status: [
        { value: 1, text: "Single" },
        { value: 2, text: "Married" }
      ],

      gender: [
        { value: 1, text: "Male" },
        { value: 2, text: "Female" }
      ],

      educational: [
        "Elementary Level",
        "Elementary Graduate",
        "High School Level",
        "High School Graduate",
        "Senior High School Level",
        "Senior High School Graduate",
        "College Level",
        "College Graduate",
        "Vocational Course Level",
        "Vocational Course Graduate",
        "Post Graduate"
      ],

      year: [],

      relationship: [
        "Child",
        "Friend",
        "Parent",
        "Relative",
        "Sibling",
        "Spouse"
      ]
    };
  },
    created() {
    this.$vuetify.theme.dark = false;
  },
  mounted() {
    this.getYear();
    this.getLocation();
  },
  computed: {
    computedDateFormatted() {
      return this.formatDate(this.date);
    },
    show: {
      get () {
        return this.visible
      },
      set (value) {
        if (!value) {
          this.$emit('close')
        }
      }
    }
  },

  watch: {
    date(val) {
      this.form.app_birthdate = this.formatDate(this.date);
    }
  },

  methods: {
    showLoading() {
      Swal.showLoading();
    },
    saveApplicant() {
      this.$validator.validateAll().then(valid => {
        Swal.showLoading();
        this.form
          .post("/api/applicants")
          .then(res => {
            Swal.close();
            Swal.fire({
              icon: "success",
              title: "Success",
              text:
                "We will call you once we recieved this application. Thank you"
            }).then(() => {
              Swal.showLoading();
              location.reload();
            });
          })
          .catch(() => {
            Swal.close();
            this.dialog = true,
            console.log(this.$refs.applicant_form.$el)
            console.log(this.$validator.errors.items[0].field);
            document
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
    formatDate(date) {
      if (!date) return null;

      const [year, month, day] = date.split("-");
      return `${month}/${day}/${year}`;
    },
    parseDate(date) {
      if (!date) return null;
      const [month, day, year] = date.split("/");
      return `${year}-${month.padStart(2, "0")}-${day.padStart(2, "0")}`;
    },
    getYear() {
      let dt = new Date();
      for (let i = dt.getFullYear(); i >= 1930; i--) {
        this.year.push(i);
      }
    },
    getLocation() {
      Swal.showLoading();
      axios
        .get("/api/applicants/location")
        .then(res => {
          this.locations = res.data.location;
          Swal.close();
        })
        .catch(err => console.dir(err));
    },
    getPosition() {
      Swal.showLoading();
      axios
        .get(`/api/applicants/position/${this.form.app_location}`)
        .then(res => {
          console.dir(res);
          this.positions = res.data.position;
          Swal.close();
        })
        .catch(err => console.dir(err));
    },
    getCompany(company) {
      console.log(company);
    }
  }
};
</script>