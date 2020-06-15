<template>
  <div class="mr-2 ml-5 mt-5 mb-5">
    <v-layout row wrap>
      <v-flex sm12 xs12 md3 lg3 class="mb-3">
        <v-card class="mr-3 mb-3">
          <v-list-item>
            <v-list-item-avatar tile size="62" class="mt-n10">
              <v-sheet color="green darken-1" width="100" height="100" elevation="20">
                <v-icon dark large>mdi-account-clock</v-icon>
              </v-sheet>
            </v-list-item-avatar>
            <v-list-item-content>
              <div class="overline text-right">Pending Applicants</div>
              <v-list-item-title class="headline mb-1 text-right">
                <animated-number :number="this.pACount"></animated-number>
              </v-list-item-title>
              <div>
                <v-divider></v-divider>
              </div>
            </v-list-item-content>
          </v-list-item>
          <v-card-actions>
            <router-link to="/hr/applicants">
              <v-btn outlined color="green darken-1">
                <span>View</span>
                <v-icon right>mdi-arrow-right</v-icon>
              </v-btn>
            </router-link>
          </v-card-actions>
        </v-card>
      </v-flex>
      <v-flex sm12 xs12 md3 lg3 class="mb-3">
        <v-card class="mr-3 mb-3">
          <v-list-item>
            <v-list-item-avatar tile size="62" class="mt-n10">
              <v-sheet color="yellow darken-1" width="100" height="100" elevation="20">
                <v-icon dark large>mdi-format-list-checkbox</v-icon>
              </v-sheet>
            </v-list-item-avatar>
            <v-list-item-content>
              <div class="overline text-right">Pending MPR</div>
              <v-list-item-title class="headline mb-1 text-right">
                <animated-number :number="this.pMCount"></animated-number>
              </v-list-item-title>
              <div>
                <v-divider></v-divider>
              </div>
            </v-list-item-content>
          </v-list-item>
          <v-card-actions>
            <router-link to="/hr/mpr">
              <v-btn outlined color="yellow darken-1">
                <span>View</span>
                <v-icon right>mdi-arrow-right</v-icon>
              </v-btn>
            </router-link>
          </v-card-actions>
        </v-card>
      </v-flex>
      <v-flex sm12 xs12 md3 lg3 class="mb-3">
        <v-card class="mr-3 mb-3">
          <v-list-item>
            <v-list-item-avatar tile size="62" class="mt-n10">
              <v-sheet color="blue darken-1" width="100" height="100" elevation="20">
                <v-icon dark large>mdi-account-network</v-icon>
              </v-sheet>
            </v-list-item-avatar>
            <v-list-item-content>
              <div class="overline text-right">Pending Screening</div>
              <v-list-item-title class="headline mb-1 text-right">
                <animated-number :number="this.pICount"></animated-number>
              </v-list-item-title>
              <div>
                <v-divider></v-divider>
              </div>
            </v-list-item-content>
          </v-list-item>
          <v-card-actions>
            <router-link to="/hr/screening">
              <v-btn outlined color="blue darken-1">
                <span>View</span>
                <v-icon right>mdi-arrow-right</v-icon>
              </v-btn>
            </router-link>
          </v-card-actions>
        </v-card>
      </v-flex>
      <v-flex sm12 xs12 md3 lg3 class="mb-3">
        <v-card class="mr-3 mb-3">
          <v-list-item>
            <v-list-item-avatar tile size="62" class="mt-n10">
              <v-sheet color="orange darken-1" width="100" height="100" elevation="20">
                <v-icon dark large>mdi-folder-clock</v-icon>
              </v-sheet>
            </v-list-item-avatar>
            <v-list-item-content>
              <div class="overline text-right">Pending Requirements</div>
              <v-list-item-title class="headline mb-1 text-right">
                <animated-number :number="this.pRCount"></animated-number>
              </v-list-item-title>
              <div>
                <v-divider></v-divider>
              </div>
            </v-list-item-content>
          </v-list-item>
          <v-card-actions>
            <router-link to="/hr/requirements">
              <v-btn outlined color="orange darken-1">
                <span>View</span>
                <v-icon right>mdi-arrow-right</v-icon>
              </v-btn>
            </router-link>
          </v-card-actions>
        </v-card>
      </v-flex>
    </v-layout>
    <v-flex sm12 xs12 md6 lg6 class="mb-3">
      <v-card v-for="project in projects" :key="project.title">
        <v-layout row wrap :class="`pa-3 project ${project.status}`">
          <v-flex xs12 sm12 md4>
            <div class="caption grey--text">Requesting</div>
            <div>{{project.title}}</div>
          </v-flex>
          <v-flex xs6 sm4 md2>
            <div class="caption grey--text">Requester</div>
            <div>{{project.person}}</div>
          </v-flex>
          <v-flex xs6 sm4 md2>
            <div class="caption grey--text">Date</div>
            <div>{{project.due}}</div>
          </v-flex>
          <v-flex xs6 sm6 md2>
            <div class="caption grey--text">Status</div>
            <div>
              <v-chip small :class="`${project.status} white--text caption my-2`">{{project.status}}</v-chip>
            </div>
          </v-flex>
          <v-flex xs6 sm6 md2>
            <div class="caption grey--text">Status</div>
            <div>
              <v-chip small :class="`${project.status} white--text caption my-2`">{{project.status}}</v-chip>
            </div>
          </v-flex>
        </v-layout>
      </v-card>
    </v-flex>
  </div>
</template>
<script>
export default {
  data() {
    return {
      projects: [
        {
          title: "Programmer",
          person: "Steto Javellana",
          due: "1st Jan 2019",
          status: "pending",
          content:
            "Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos quas nisi, numquam veritatis similique laudantium fuga neque culpa quasi earum, quo fugiat dolor a reiciendis odio recusandae eligendi ab consectetur?"
        },
        {
          title: "Junior Programmer",
          person: "Steto Javellana",
          due: "1st Jan 2019",
          status: "approved",
          content:
            "Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos quas nisi, numquam veritatis similique laudantium fuga neque culpa quasi earum, quo fugiat dolor a reiciendis odio recusandae eligendi ab consectetur?"
        },
        {
          title: "Junior Developer",
          person: "Steto Javellana",
          due: "1st Jan 2019",
          status: "disapproved",
          content:
            "Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos quas nisi, numquam veritatis similique laudantium fuga neque culpa quasi earum, quo fugiat dolor a reiciendis odio recusandae eligendi ab consectetur?"
        }
      ],
      pACount: 0,
      pRCount: 0,
      pICount: 0,
      pMCount: 0
    };
  },
  created() {
    this.pendingApplicant();
    if (
      this.$store.state.currentUser == null ||
      !localStorage.getItem("user")
    ) {
      Swal.fire("Error", "Your session has timed out.", "error").then(() => {
        location.reload();
      });
    }
  },

  mounted() {},
  methods: {
    pendingApplicant() {
      axios
        .get("/api/pending/applicants", {})
        .then(res => {
          console.dir(res);
          this.pACount = res.data.pending_app.length;
          this.pMCount = res.data.fetch_request.length;
          this.pICount = res.data.screening_app.length;
          this.pRCount = res.data.requirements_app.length;
        })
        .catch(err => console.dir(err));
    }
  }
};
</script>

<style scoped>
.project.pending {
  border-left: 5px solid orange;
}
.project.approved {
  border-left: 5px solid green;
}
.project.disapproved {
  border-left: 5px solid red;
}

.v-chip.pending {
  background: orange;
}
.v-chip.approved {
  background: green;
}
.v-chip.disapproved {
  background: red;
}

.before-enter {
  opacity: 0;
  transform: translateX(100px);
  transition: all 1s cubic-bezier(0.41, 0.01, 0.57, 1.61);
}

.enter {
  opacity: 1;
  transform: translateX(0px);
}

.delay-1 {
  transition-delay: 0s;
}
.delay-2 {
  transition-delay: 0.1s;
}
.delay-3 {
  transition-delay: 0.2s;
}
.delay-4 {
  transition-delay: 0.3s;
}
</style>