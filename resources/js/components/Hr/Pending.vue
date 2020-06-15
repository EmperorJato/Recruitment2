<template>
  <v-card class="ma-5">
    <v-card-title>
      Pending Applicants
      <v-spacer></v-spacer>
      <v-text-field
        v-model="search"
        append-icon="mdi-magnify"
        label="Search"
        single-line
        hide-details
      ></v-text-field>
    </v-card-title>
    <v-data-table
      :headers="headers"
      :items="applicants"
      :search="search"
      :loading="loading"
      loading-text="Loading... Please wait"
      class="elevation-1"
      item-key="app_id"
    >
      <template v-slot:item.action="{item}">
        <div class="text-center d-flex align-center">
          <v-tooltip bottom>
            <template v-slot:activator="{on}">
              <v-icon
                small
                color="primary"
                v-on="on"
                class="mr-2"
                @click="viewModal(item.app_id)"
              >mdi-eye</v-icon>
            </template>
            <span>View</span>
          </v-tooltip>
          <v-tooltip bottom>
            <template v-slot:activator="{on}">
              <v-icon small color="error" v-on="on" @click="removeItem(item.app_id)">mdi-delete</v-icon>
            </template>
            <span>Delete</span>
          </v-tooltip>
        </div>
      </template>
      <template v-slot:item.app_date="{ item }">{{ formatDate(item.app_date) }}</template>
      <template #item.fullname="{ item }">{{ item.app_firstname }} {{ item.app_lastname }}</template>
      <template #item.app_gender="{ item }">{{ gender(item.app_gender) }}</template>
    </v-data-table>

    <!-- dialog for view -->
    <v-dialog v-model="showDialog" fullscreen hide-overlay transition="dialog-bottom-transition">
      <v-card justify="center" align="center">
        <v-toolbar dark color="primary">
          <v-btn icon dark @click="this.closeDialog">
            <v-icon>mdi-close</v-icon>
          </v-btn>
          <v-toolbar-title>Applicant</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-toolbar-items>
            <v-btn dark text @click="this.closeDialog; dialog = true">Edit</v-btn>
          </v-toolbar-items>
        </v-toolbar>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12" md="4" sm="12" xs="12">
                <v-card class="pa-2" elevation="6">
                  <v-card-title class="justify-center">
                    <v-flex>
                      <v-avatar color="grey" size="100">
                        <v-img src="/img/avatar.svg"></v-img>
                      </v-avatar>
                      <p class="subheading mt-1">{{form.app_firstname + " " + form.app_lastname}}</p>
                    </v-flex>
                  </v-card-title>
                  <v-card-text>
                    <div class="subheading mb-2">{{form.requesting}}</div>
                    <v-divider></v-divider>
                    <div class="text-left mt-4">
                      <v-row>
                        <v-col cols="12" sm="4" md="4" xs="4" lg="4">
                          <p class="font-weight-bold">Applied Date:</p>
                        </v-col>
                        <v-col cols="12" sm="8" md="8" xs="8" lg="8">
                          <p class="font-weight-regular">{{form.app_date}}</p>
                        </v-col>
                      </v-row>
                      <v-row>
                        <v-col cols="12" sm="4" md="4" xs="4" lg="4">
                          <p class="font-weight-bold">Phone:</p>
                        </v-col>
                        <v-col cols="12" sm="8" md="8" xs="8" lg="8">
                          <p class="font-weight-regular">{{form.app_phone}}</p>
                        </v-col>
                      </v-row>
                      <v-row>
                        <v-col cols="12" sm="4" md="4" xs="4" lg="4">
                          <p class="font-weight-bold">Birthdate:</p>
                        </v-col>
                        <v-col cols="12" sm="8" md="8" xs="8" lg="8">
                          <p
                            class="font-weight-regular"
                          >{{form.app_birthdate+ " (" + getAge + " years old)" }}</p>
                        </v-col>
                      </v-row>
                      <v-row>
                        <v-col cols="12" sm="4" md="4" xs="4" lg="4">
                          <p class="font-weight-bold">Email:</p>
                        </v-col>
                        <v-col cols="12" sm="8" md="8" xs="8" lg="8">
                          <p class="font-weight-regular">{{form.app_email}}</p>
                        </v-col>
                      </v-row>
                      <v-row>
                        <v-col cols="12" sm="4" md="4" xs="4" lg="4">
                          <p class="font-weight-bold">Gender:</p>
                        </v-col>
                        <v-col cols="12" sm="8" md="8" xs="8" lg="8">
                          <p class="font-weight-regular">{{getGender}}</p>
                        </v-col>
                      </v-row>
                      <v-row>
                        <v-col cols="12" sm="4" md="4" xs="4" lg="4">
                          <p class="font-weight-bold">Marital:</p>
                        </v-col>
                        <v-col cols="12" sm="8" md="8" xs="8" lg="8">
                          <p class="font-weight-regular">{{getMarital}}</p>
                        </v-col>
                      </v-row>
                    </div>
                  </v-card-text>
                </v-card>
              </v-col>
              <v-col cols="12" md="8" sm="12" xs="12">
                <v-card class="pa-2" elevation="6">
                  <v-card-title></v-card-title>
                  <v-card-text>
                    <h3 class="subheading text-left">School</h3>
                    <v-row class="text-left">
                      <v-col cols="12" sm="6" md="6" xs="6" lg="6">
                        <v-row class="text-left">
                          <v-col cols="12" md="6">
                            <p class="font-weight-bold">Education:</p>
                          </v-col>
                          <v-col cols="12" md="6">
                            <p class="font-weight-regular">{{form.app_education}}</p>
                          </v-col>
                        </v-row>
                      </v-col>
                      <v-col cols="12" sm="6" md="6" xs="6" lg="6">
                        <v-flex>
                          <v-row>
                            <v-col cols="12" md="6">
                              <p class="font-weight-bold">Year Graduated:</p>
                            </v-col>
                            <v-col cols="12" md="6">
                              <p class="font-weight-regular">{{form.app_year_graduated}}</p>
                            </v-col>
                          </v-row>
                        </v-flex>
                      </v-col>
                    </v-row>
                    <v-row class="text-left" v-if="this.form.app_course != null">
                      <v-col cols="12" sm="12" md="12" xs="12" lg="12">
                        <v-row>
                          <v-col cols="12" sm="3" md="3" xs="3" lg="3">
                            <p class="font-weight-bold">Course:</p>
                          </v-col>
                          <v-col cols="12" sm="9" md="9" xs="9" lg="9">
                            <p class="font-weight-regular">{{form.app_course}}</p>
                          </v-col>
                        </v-row>
                      </v-col>
                    </v-row>
                    <v-divider class="mb-5"></v-divider>
                    <h3 class="subheading text-left">Address</h3>
                    <v-row class="text-left">
                      <v-col cols="12" sm="3" md="3" xs="3" lg="3">
                        <p class="font-weight-bold">Present Address:</p>
                      </v-col>
                      <v-col cols="12" sm="9" md="9" xs="9" lg="9">
                        <p class="font-weight-regular">{{form.app_p_address}}</p>
                      </v-col>
                    </v-row>
                    <v-row class="text-left">
                      <v-col cols="12" sm="3" md="3" xs="3" lg="3">
                        <p class="font-weight-bold">Home Address:</p>
                      </v-col>
                      <v-col cols="12" sm="9" md="9" xs="9" lg="9">
                        <p class="font-weight-regular">{{form.app_h_address}}</p>
                      </v-col>
                    </v-row>
                    <v-divider class="mb-5"></v-divider>
                    <h3 class="subheading text-left">Person in case of emergency</h3>
                    <v-row class="text-left">
                      <v-col cols="12" sm="6" md="6" xs="6" lg="6">
                        <v-row>
                          <v-col cols="12" md="6">
                            <p class="font-weight-bold">Person:</p>
                          </v-col>
                          <v-col cols="12" md="6">
                            <p class="font-weight-regular">{{form.app_person}}</p>
                          </v-col>
                        </v-row>
                      </v-col>
                      <v-col cols="12" sm="6" md="6" xs="6" lg="6">
                        <v-flex>
                          <v-row>
                            <v-col cols="12" md="6">
                              <p class="font-weight-bold">Phone:</p>
                            </v-col>
                            <v-col cols="12" md="6">
                              <p class="font-weight-regular">{{form.app_person_phone}}</p>
                            </v-col>
                          </v-row>
                        </v-flex>
                      </v-col>
                    </v-row>
                    <v-row class="text-left">
                      <v-col cols="12" sm="6" md="6" xs="6" lg="6">
                        <v-row>
                          <v-col cols="12" md="6">
                            <p class="font-weight-bold">Address:</p>
                          </v-col>
                          <v-col cols="12" md="6">
                            <p class="font-weight-regular">{{form.app_person_address}}</p>
                          </v-col>
                        </v-row>
                      </v-col>
                      <v-col cols="12" sm="6" md="6" xs="6" lg="6">
                        <v-flex>
                          <v-row>
                            <v-col cols="12" md="6">
                              <p class="font-weight-bold">Relationship:</p>
                            </v-col>
                            <v-col cols="12" md="6">
                              <p class="font-weight-regular">{{form.app_relationship}}</p>
                            </v-col>
                          </v-row>
                        </v-flex>
                      </v-col>
                    </v-row>
                  </v-card-text>
                </v-card>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" md="12" sm="12" xs="12">
                <v-card class="pa-2" elevation="6">
                  <v-card-title>
                    <p class="subheading mt-1">Screening Section</p>
                    <v-spacer></v-spacer>
                    <v-btn class="mx-2" fab dark color="blue" @click="modalScreening(form)">
                      <v-icon dark>mdi-pencil</v-icon>
                    </v-btn>
                  </v-card-title>
                  <v-card-text>
                    <v-row class="text-left">
                      <v-col cols="12" sm="6" md="6" xs="6" lg="6">
                        <v-row>
                          <v-col cols="12" md="6">
                            <p class="font-weight-bold">Interviewer:</p>
                          </v-col>
                          <v-col cols="12" md="6">
                            <p class="font-weight-regular">{{form.ss_interviewer}}</p>
                          </v-col>
                        </v-row>
                      </v-col>
                      <v-col cols="12" sm="6" md="6" xs="6" lg="6">
                        <v-flex>
                          <v-row>
                            <v-col cols="12" md="6">
                              <p class="font-weight-bold">Interview Date:</p>
                            </v-col>
                            <v-col cols="12" md="6">
                              <p class="font-weight-regular">{{dateFormat + " " + timeFormat}}</p>
                            </v-col>
                          </v-row>
                        </v-flex>
                      </v-col>
                    </v-row>
                    <v-row class="text-left">
                      <v-col cols="12" sm="6" md="6" xs="6" lg="6">
                        <v-row>
                          <v-col cols="12" md="6">
                            <p class="font-weight-bold">Pass or Fail:</p>
                          </v-col>
                          <v-col cols="12" md="6">
                            <p class="font-weight-regular">{{form.ss_pof}}</p>
                          </v-col>
                        </v-row>
                      </v-col>
                      <v-col cols="12" sm="6" md="6" xs="6" lg="6">
                        <v-flex>
                          <v-row>
                            <v-col cols="12" md="6">
                              <p class="font-weight-bold">Status:</p>
                            </v-col>
                            <v-col cols="12" md="6">
                              <p class="font-weight-regular">{{getStatus}}</p>
                            </v-col>
                          </v-row>
                        </v-flex>
                      </v-col>
                    </v-row>
                  </v-card-text>
                  <v-divider></v-divider>
                  <v-card-title>
                    <p class="subheading mt-1">Requirements Section</p>
                    <v-spacer></v-spacer>
                    <v-btn class="mx-2" fab dark color="blue" v-if="this.form.ss_status === 1" @click="modalRequirements(form)">
                      <v-icon dark>mdi-pencil</v-icon>
                    </v-btn>
                  </v-card-title>
                  <v-card-text>
                    <v-row class="text-left">
                      <v-col cols="12" sm="3" md="3" lg="3">
                        <v-checkbox v-model="form.rs_pic" readonly label="Picture"></v-checkbox>
                      </v-col>
                      <v-col cols="12" sm="3" md="3" lg="3">
                        <v-checkbox v-model="form.rs_resume" readonly label="Resume"></v-checkbox>
                      </v-col>
                      <v-col cols="12" sm="3" md="3" lg="3">
                        <v-checkbox v-model="form.rs_nso" readonly label="NSO"></v-checkbox>
                      </v-col>
                      <v-col cols="12" sm="3" md="3" lg="3">
                        <v-checkbox v-model="form.rs_clearance" readonly label="Clearance"></v-checkbox>
                      </v-col>
                    </v-row>
                    <v-row class="text-left">
                      <v-col cols="12" sm="3" md="3" lg="3">
                        <v-checkbox v-model="form.rs_xray" readonly label="X-Ray"></v-checkbox>
                      </v-col>
                      <v-col cols="12" sm="3" md="3" lg="3">
                        <v-checkbox v-model="form.rs_hcard" readonly label="Health Card"></v-checkbox>
                      </v-col>
                      <v-col cols="12" sm="3" md="3" lg="3">
                        <v-checkbox v-model="form.rs_drug" readonly label="Drug Test"></v-checkbox>
                      </v-col>
                      <v-col cols="12" sm="3" md="3" lg="3">
                        <v-checkbox v-model="form.rs_hepa" readonly label="Hepatitis Test"></v-checkbox>
                      </v-col>
                    </v-row>
                    <v-row class="text-left">
                      <v-col cols="12" sm="3" md="3" lg="3">
                        <v-checkbox v-model="form.rs_pregnancy" readonly label="Pregnancy Test"></v-checkbox>
                      </v-col>
                    </v-row>
                    <v-row class="text-left">
                      <v-col cols="12" sm="6" md="6" xs="6" lg="6">
                        <v-row>
                          <v-col cols="12" md="6">
                            <p class="font-weight-bold">SSS:</p>
                          </v-col>
                          <v-col cols="12" md="6">
                            <p class="font-weight-regular">{{form.sss}}</p>
                          </v-col>
                        </v-row>
                      </v-col>
                      <v-col cols="12" sm="6" md="6" xs="6" lg="6">
                        <v-flex>
                          <v-row>
                            <v-col cols="12" md="6">
                              <p class="font-weight-bold">Philhealth:</p>
                            </v-col>
                            <v-col cols="12" md="6">
                              <p class="font-weight-regular">{{form.philhealth}}</p>
                            </v-col>
                          </v-row>
                        </v-flex>
                      </v-col>
                    </v-row>
                    <v-row class="text-left">
                      <v-col cols="12" sm="6" md="6" xs="6" lg="6">
                        <v-row>
                          <v-col cols="12" md="6">
                            <p class="font-weight-bold">HDMF:</p>
                          </v-col>
                          <v-col cols="12" md="6">
                            <p class="font-weight-regular">{{form.hdmf}}</p>
                          </v-col>
                        </v-row>
                      </v-col>
                      <v-col cols="12" sm="6" md="6" xs="6" lg="6">
                        <v-flex>
                          <v-row>
                            <v-col cols="12" md="6">
                              <p class="font-weight-bold">TIN:</p>
                            </v-col>
                            <v-col cols="12" md="6">
                              <p class="font-weight-regular">{{form.tin}}</p>
                            </v-col>
                          </v-row>
                        </v-flex>
                      </v-col>
                    </v-row>
                    <v-row class="text-left">
                      <v-col cols="12" sm="6" md="6" xs="6" lg="6">
                        <v-row>
                          <v-col cols="12" md="6">
                            <p class="font-weight-bold">Bank Account:</p>
                          </v-col>
                          <v-col cols="12" md="6">
                            <p class="font-weight-regular">{{form.bank_account}}</p>
                          </v-col>
                        </v-row>
                      </v-col>
                      <v-col cols="12" sm="6" md="6" xs="6" lg="6">
                        <v-flex>
                          <v-row>
                            <v-col cols="12" md="6">
                              <p class="font-weight-bold">Status:</p>
                            </v-col>
                            <v-col cols="12" md="6">
                              <p class="font-weight-regular">{{this.status(form.req_status)}}</p>
                            </v-col>
                          </v-row>
                        </v-flex>
                      </v-col>
                    </v-row>
                  </v-card-text>
                </v-card>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
      </v-card>
    </v-dialog>

    <!-- dialog for edit -->
    <v-row justify="center">
      <v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition">
        <v-card>
          <v-toolbar dark color="primary">
            <v-btn icon dark @click="dialog = false">
              <v-icon>mdi-close</v-icon>
            </v-btn>
            <v-toolbar-title>Applicant</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-items>
              <v-btn dark text @click="dialog = false">Save</v-btn>
            </v-toolbar-items>
          </v-toolbar>
          <v-list three-line subheader>
            <v-list-item>
              <v-list-item-content>
                <v-list-item-title>Name</v-list-item-title>
                <v-row align="center" justify="center">
                  <v-col cols="12" lg="4" md="4" sm="12">
                    <v-text-field outlined label="First Name" v-model="form.app_firstname"></v-text-field>
                  </v-col>
                  <v-col cols="12" lg="4" md="4" sm="12">
                    <v-text-field outlined label="Middle Name" v-model="form.app_middlename"></v-text-field>
                  </v-col>
                  <v-col cols="12" lg="4" md="4" sm="12">
                    <v-text-field outlined label="Last Name" v-model="form.app_lastname"></v-text-field>
                  </v-col>
                </v-row>
              </v-list-item-content>
            </v-list-item>
            <v-divider></v-divider>
            <v-list-item>
              <v-list-item-content>
                <v-list-item-title>Personal Information</v-list-item-title>
                <v-row>
                  <v-col cols="12" lg="4" md="4" sm="12">
                    <v-text-field outlined label="Contact" v-model="form.app_phone"></v-text-field>
                  </v-col>
                  <v-col cols="12" lg="4" md="4" sm="12">
                    <v-text-field outlined label="Birthdate" v-model="form.app_birthdate"></v-text-field>
                  </v-col>
                  <v-col cols="12" lg="4" md="4" sm="12">
                    <v-text-field outlined label="Email" v-model="form.app_email"></v-text-field>
                  </v-col>
                  <v-col cols="12" lg="4" md="4" sm="12">
                    <v-text-field outlined label="Gender" v-model="form.app_gender"></v-text-field>
                  </v-col>
                  <v-col cols="12" lg="4" md="4" sm="12">
                    <v-text-field outlined label="Marital Status" v-model="form.app_marital_status"></v-text-field>
                  </v-col>
                </v-row>
              </v-list-item-content>
            </v-list-item>
            <v-divider></v-divider>
            <v-list-item>
              <v-list-item-content>
                <v-list-item-title>Education</v-list-item-title>
                <v-row>
                  <v-col cols="12" lg="4" md="4" sm="12">
                    <v-text-field outlined label="Education" v-model="form.app_education"></v-text-field>
                  </v-col>
                  <v-col cols="12" lg="4" md="4" sm="12">
                    <v-text-field outlined label="Year Graduated" v-model="form.app_year_graduated"></v-text-field>
                  </v-col>
                  <v-col cols="12" lg="4" md="4" sm="12">
                    <v-text-field outlined label="Course" v-model="form.app_course"></v-text-field>
                  </v-col>
                </v-row>
              </v-list-item-content>
            </v-list-item>
            <v-divider></v-divider>
            <v-list-item>
              <v-list-item-content>
                <v-list-item-title>Address</v-list-item-title>
                <v-row>
                  <v-col cols="12" lg="4" md="4" sm="12">
                    <v-text-field outlined label="Present Address" v-model="form.app_p_address"></v-text-field>
                  </v-col>
                  <v-col cols="12" lg="4" md="4" sm="12">
                    <v-text-field outlined label="Home Address" v-model="form.app_h_address"></v-text-field>
                  </v-col>
                </v-row>
              </v-list-item-content>
            </v-list-item>
            <v-divider></v-divider>
            <v-list-item>
              <v-list-item-content>
                <v-list-item-title>Incase of Emergency</v-list-item-title>
                <v-row>
                  <v-col cols="12" lg="4" md="4" sm="12">
                    <v-text-field outlined label="Contact Person" v-model="form.app_person"></v-text-field>
                  </v-col>
                  <v-col cols="12" lg="4" md="4" sm="12">
                    <v-text-field outlined label="Phone" v-model="form.app_person_phone"></v-text-field>
                  </v-col>
                  <v-col cols="12" lg="4" md="4" sm="12">
                    <v-text-field outlined label="Address" v-model="form.app_person_address"></v-text-field>
                  </v-col>
                  <v-col cols="12" lg="4" md="4" sm="12">
                    <v-text-field outlined label="Relationship" v-model="form.app_relationship"></v-text-field>
                  </v-col>
                </v-row>
              </v-list-item-content>
            </v-list-item>
          </v-list>
        </v-card>
      </v-dialog>
    </v-row>

    <!-- dialog for screenings -->
    <v-dialog v-model="screeningDialog" width="600px">
      <v-card>
        <v-card-title>Screening Section</v-card-title>
        <v-container>
          <v-row align="center" justify="center">
            <v-col cols="12" sm="12" md="12" lg="12">
              <v-form
                autocomplete="off"
                ref="screeningForm"
                @submit.prevent="saveScreening"
                v-model="screeningValid"
              >
                <v-card-text>
                  <v-menu
                    v-model="menu2"
                    :close-on-content-click="false"
                    transition="scale-transition"
                    offset-y
                    max-width="290px"
                    min-width="290px"
                  >
                    <template v-slot:activator="{ on }">
                      <v-row justify="center">
                        <v-col cols="12" sm="12" md="12" class="mt-3">
                          <v-text-field
                            v-model="screeningForm.ss_date"
                            label="Date"
                            prepend-inner-icon="mdi-calendar"
                            outlined
                            readonly
                            v-on="on"
                            :rules="formRules.requiredRules"
                          ></v-text-field>
                        </v-col>
                      </v-row>
                    </template>
                    <v-date-picker v-model="date">
                      <v-spacer></v-spacer>
                      <v-btn text color="primary" @click="menu2 = false">OK</v-btn>
                    </v-date-picker>
                  </v-menu>
                  <v-menu
                    ref="menu"
                    v-model="menu1"
                    :close-on-content-click="false"
                    transition="scale-transition"
                    offset-y
                    max-width="290px"
                    min-width="290px"
                  >
                    <template v-slot:activator="{ on }">
                      <v-row justify="center">
                        <v-col cols="12" sm="12" md="12" class="mt-3">
                          <v-text-field
                            v-model="screeningForm.ss_time"
                            label="Time"
                            prepend-inner-icon="mdi-clock"
                            outlined
                            readonly
                            v-on="on"
                            :rules="formRules.requiredRules"
                          ></v-text-field>
                        </v-col>
                      </v-row>
                    </template>
                    <v-time-picker v-if="menu1" v-model="screeningForm.ss_time" full-width>
                      <v-spacer></v-spacer>
                      <v-btn text color="primary" @click="menu1 = false">Ok</v-btn>
                    </v-time-picker>
                  </v-menu>
                  <v-row justify="center">
                    <v-col cols="12" sm="12" md="12" class="mt-3">
                      <v-select
                        v-if="this.form.ss_status != null"
                        :items="pof"
                        label="Pass or Fail"
                        prepend-inner-icon="mdi-help-network"
                        outlined
                        v-model="screeningForm.ss_pof"
                        class="mt-3"
                      ></v-select>
                    </v-col>
                  </v-row>
                </v-card-text>
                <v-card-actions class="justify-center">
                  <v-spacer></v-spacer>
                  <v-btn color="blue darken-1" text @click="screeningDialog = false">Close</v-btn>
                  <v-btn
                    v-if="this.form.ss_status != null"
                    class="white--text"
                    color="blue"
                    :disabled="this.disable === true"
                    @click="updateScreening(form.app_id)"
                  >Save</v-btn>
                  <v-btn
                    v-else
                    type="submit"
                    class="white--text"
                    color="blue"
                    :disabled="!screeningValid || this.disable === true"
                  >Submit</v-btn>
                </v-card-actions>
              </v-form>
            </v-col>
          </v-row>
        </v-container>
      </v-card>
    </v-dialog>

    <!-- dialog for requirements -->
    <v-dialog v-model="requirementsDialog" width="1200px">
      <v-card>
        <v-card-title>Requirements Section</v-card-title>
        <v-container>
          <v-row align="center" justify="center">
            <v-col cols="12" sm="12" md="12" lg="12">
              <v-form autocomplete="off" ref="requirmentsForm" @submit.prevent="saveRequirements">
                <v-card-text>
                  <v-row class="text-left">
                    <v-col cols="12" sm="3" md="3" lg="3">
                      <v-checkbox v-model="requirementsForm.rs_pic" label="Picture"></v-checkbox>
                    </v-col>
                    <v-col cols="12" sm="3" md="3" lg="3">
                      <v-checkbox v-model="requirementsForm.rs_resume" label="Resume"></v-checkbox>
                    </v-col>
                    <v-col cols="12" sm="3" md="3" lg="3">
                      <v-checkbox v-model="requirementsForm.rs_nso" label="NSO"></v-checkbox>
                    </v-col>
                    <v-col cols="12" sm="3" md="3" lg="3">
                      <v-checkbox v-model="requirementsForm.rs_clearance" label="Clearance"></v-checkbox>
                    </v-col>
                  </v-row>
                  <v-row class="text-left">
                    <v-col cols="12" sm="3" md="3" lg="3">
                      <v-checkbox v-model="requirementsForm.rs_xray" label="X-Ray"></v-checkbox>
                    </v-col>
                    <v-col cols="12" sm="3" md="3" lg="3">
                      <v-checkbox v-model="requirementsForm.rs_hcard" label="Health Card"></v-checkbox>
                    </v-col>
                    <v-col cols="12" sm="3" md="3" lg="3">
                      <v-checkbox v-model="requirementsForm.rs_drug" label="Drug Test"></v-checkbox>
                    </v-col>
                    <v-col cols="12" sm="3" md="3" lg="3">
                      <v-checkbox v-model="requirementsForm.rs_hepa" label="Hepatitis Test"></v-checkbox>
                    </v-col>
                  </v-row>
                  <v-row class="text-left">
                    <v-col cols="12" sm="3" md="3" lg="3">
                      <v-checkbox v-model="requirementsForm.rs_pregnancy" label="Pregnancy Test"></v-checkbox>
                    </v-col>
                  </v-row>
                  <v-row justify="center">
                    <v-col cols="12" sm="12" md="6" class="mt-3">
                      <v-text-field v-model="requirementsForm.sss" label="SSS" type="text" outlined></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="12" md="6" class="mt-3">
                      <v-text-field
                        label="Philhealth"
                        v-model="requirementsForm.philhealth"
                        outlined
                      ></v-text-field>
                    </v-col>
                  </v-row>
                  <v-row justify="center">
                    <v-col cols="12" sm="12" md="6" class="mt-3">
                      <v-text-field
                        v-model="requirementsForm.hdmf"
                        label="HDMF"
                        type="text"
                        outlined
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="12" md="6" class="mt-3">
                      <v-text-field label="TIN" v-model="requirementsForm.tin" outlined></v-text-field>
                    </v-col>
                  </v-row>
                  <v-row>
                    <v-col cols="12" sm="12" md="6" class="mt-3">
                      <v-text-field
                        v-model="requirementsForm.bank_account"
                        label="Bank Account"
                        type="text"
                        outlined
                      ></v-text-field>
                    </v-col>
                  </v-row>
                </v-card-text>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="blue darken-1" text @click="requirementsDialog = false">Close</v-btn>
                  <v-btn
                    v-if="this.form.req_status != null"
                    class="white--text"
                    color="blue"
                    @click="updateRequirements(form.app_id)"
                  >Save</v-btn>
                  <v-btn v-else type="submit" class="white--text" color="blue">Submit</v-btn>
                </v-card-actions>
              </v-form>
            </v-col>
          </v-row>
        </v-container>
      </v-card>
    </v-dialog>

  </v-card>
</template>

<script>
import moment from "moment";
export default {
  
  data: vm => ({
    date: new Date().toISOString().substr(0, 10),
    screeningValid: false,
    menu2: false,
    menu1: false,
    disable: false,
    showDialog: false,
    dialog: false,
    screeningDialog: false,
    requirementsDialog: false,
    showId: "",
    showApplicant: {},
    showRequirements: {},
    showScreening: {},
    search: "",
    time: null,
    modal2: false,
    loading: true,
    pof: [
      { value: "PASSED", text: "Passed" },
      { value: "FAILED", text: "Failed" }
    ],
    age: "",
    headers: [
      {
        text: "Date",
        value: "app_date"
      },
      {
        text: "Applying",
        value: "requesting"
      },
      {
        text: "Name",
        value: "fullname"
      },
      {
        text: "Contact",
        value: "app_phone"
      },
      {
        text: "Gender",
        value: "app_gender"
      },

      {
        text: "Company",
        value: "company"
      },

      {
        text: "Action",
        value: "action",
        sortable: false
      }
    ],
    formRules: {
      requiredRules: [v => !!v || "This field is required"]
    },
    applicants: [],
    form: new Form({
      app_id: "",
      app_location: "",
      app_apply: "",
      app_company: "",
      app_date: "",
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
      requesting: "",
      ss_date: "",
      ss_time: "",
      ss_interviewer: "",
      ss_pof: "",
      ss_status: "",
      ss_status_date: "",
      rs_pic: "",
      rs_resume: "",
      rs_nso: "",
      rs_clearance: "",
      rs_xray: "",
      rs_hcard: "",
      rs_hepa: "",
      rs_drug: "",
      rs_pregnancy: "",
      sss: "",
      philhealth: "",
      hdmf: "",
      tin: "",
      bank_account: "",
      date_hired: "",
      req_status: "",
      req_status_date: ""
    }),
    screeningForm: new Form({
      ss_app_id: "",
      ss_date: "",
      ss_time: "",
      ss_pof: ""
    }),
    requirementsForm: new Form({
      rs_app_id: "",
      rs_pic: "",
      rs_resume: "",
      rs_nso: "",
      rs_clearance: "",
      rs_xray: "",
      rs_hcard: "",
      rs_hepa: "",
      rs_drug: "",
      rs_pregnancy: "",
      sss: "",
      philhealth: "",
      hdmf: "",
      tin: "",
      bank_account: ""
    })
  }),

  computed: {
    timeFormat() {
      return this.form.ss_time == null
        ? ""
        : this.formatTime(this.form.ss_time);
    },
    dateFormat() {
      return this.form.ss_date == null
        ? ""
        : this.formatDate(this.form.ss_date);
    },
    getGender() {
      return this.gender(this.form.app_gender);
    },
    getAge() {
      return this.calculateAge(this.form.app_birthdate);
    },
    getMarital() {
      return this.marital(this.form.app_marital_status);
    },
    getStatus() {
      return this.status(this.form.ss_status);
    }
  },

  watch: {
    date(val) {
      this.screeningForm.ss_date = this.date;
    }
  },

  mounted() {},

  created() {
    this.initialize();

    Fire.$on("afterCreate", () => {
      this.initialize();
    });

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
    initialize() {
      axios
        .get("/api/applicants/pending", {})
        .then(res => {
          this.applicants = res.data.applicants;
          this.loading = false;
        })
        .catch(err => console.dir(err));
    },
    logout() {
      this.$store.commit("logout");
      this.$router.push("/login");
    },
    removeItem(id) {
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
      }).then(result => {
        if (result.value) {
          axios
            .patch("/api/remove/applicant/" + id)
            .then(res => {
              Fire.$emit("afterCreate");
              Swal.fire({
                icon: "success",
                title: "Deleted Successfully",
                showConfirmButton: false,
                timer: 1500
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
      });
    },
    modalScreening(form) {
      this.screeningDialog = true;
      let obj = {
        ss_app_id: form.app_id,
        ss_date: form.ss_date,
        ss_time: form.ss_time,
        ss_pof: form.ss_pof,
        ss_status: form.ss_status
      };

      this.screeningForm = obj;
    },
    modalRequirements(form) {
      this.requirementsDialog = true;

      let req = {
        rs_app_id: form.app_id,
        rs_pic: form.rs_pic,
        rs_resume: form.rs_resume,
        rs_nso: form.rs_nso,
        rs_clearance: form.rs_clearance,
        rs_xray: form.rs_xray,
        rs_hcard: form.rs_hcard,
        rs_hepa: form.rs_hepa,
        rs_drug: form.rs_drug,
        rs_pregnancy: form.rs_pregnancy,
        sss: form.sss,
        philhealth: form.philhealth,
        hdmf: form.hdmf,
        tin: form.tin,
        bank_account: form.bank_account,
        date_hired: form.date_hired
      };

      this.requirementsForm = req;
    },
    viewModal(id) {
      this.showDialog = true;
      this.showItem(id);
      Fire.$on("afterView", () => {
        this.showItem(id);
      });
    },
    showItem(id) {
      axios
        .get("/api/applicant/show/" + id)
        .then(res => {
          console.log(res);
          Vue.set(this.$data, "showApplicant", res.data.showApplicant);
          this.form.fill(this.showApplicant);
        })
        .catch(err => {
          console.log(err);
        });
    },

    editItem(id) {
      showScheduleForm = true;
      axios
        .get("/api/applicant/show/" + id)
        .then(res => {
          console.dir(res);
          Vue.set(this.$data, "showApplicant", res.data.showApplicant);
          this.form.fill(this.showApplicant);
        })
        .catch(err => {
          console.log(err);
        });
    },
    formatDate(value) {
      return moment(value).format("MMMM DD, YYYY");
    },
    gender(gender) {
      return gender == 1 ? "Male" : "Female";
    },
    marital(marital) {
      return marital == 1 ? "Single" : "Married";
    },
    calculateAge(dateString) {
      var today = new Date();
      var birthDate = new Date(dateString);
      var age = today.getFullYear() - birthDate.getFullYear();
      var m = today.getMonth() - birthDate.getMonth();
      if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
      }
      return age;
    },
    parseDate(date) {
      if (!date) return null;

      const [month, day, year] = date.split("/");
      return `${year}-${month.padStart(2, "0")}-${day.padStart(2, "0")}`;
    },
    formatTime(time) {
      return moment(time, "HH:mm").format("LT");
    },
    status(val) {
      if (val == 1) {
        return "COMPLETED";
      } else if (val == 0) {
        return "PROCESSING";
      } else {
        return "";
      }
    },
    saveScreening() {
      this.disable = true;
      axios
        .post("/api/insert/screening", this.screeningForm)
        .then(res => {
          Fire.$emit("afterView");
          this.screeningDialog = false;
          Swal.fire({
            icon: "success",
            title: "Submitted Successfully",
            showConfirmButton: false,
            timer: 1500
          });
          this.disable = false;
        })
        .catch(err => {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: err
          });
          this.disable = false;
        });
    },
    updateScreening(id) {
      this.disable = true;
      axios
        .patch("/api/update/screening/" + id, this.screeningForm)
        .then(res => {
          Fire.$emit("afterView");
          this.screeningDialog = false;
          Swal.fire({
            icon: "success",
            title: "Saved Successfully",
            showConfirmButton: false,
            timer: 1500
          });
          this.disable = false;
        })
        .catch(err => {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: err
          });
          this.disable = false;
        });
    },
    saveRequirements() {
      axios
        .post("/api/insert/requirements", this.requirementsForm)
        .then(res => {
          console.log(res);
          Fire.$emit("afterView");
          this.requirementsDialog = false;
          Swal.fire({
            icon: "success",
            title: "Submitted Successfully",
            showConfirmButton: false,
            timer: 1500
          });
        })
        .catch(err => {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: err
          });
        });
    },
    updateRequirements(id) {
      axios
        .patch("/api/update/requirements/" + id, this.requirementsForm)
        .then(res => {
          Fire.$emit("afterView");
          this.requirementsDialog = false;
          Swal.fire({
            icon: "success",
            title: "Saved Successfully",
            showConfirmButton: false,
            timer: 1500
          });
        })
        .catch(err => {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: err
          });
        });
    },
    closeDialog(){
      this.showDialog = false;
      Fire.$emit("afterCreate");
    }
  }
};
</script>

<style scoped>
.v-text-field {
  height: 50px;
}
</style>