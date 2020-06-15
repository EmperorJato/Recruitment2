<template>
  <v-container class="my-6">
    <v-layout row wrap>
      <v-flex sm12 xs12 md6 lg4 class="mb-3">
        <v-card class="mr-3 mb-3">
          <v-list-item>
            <v-list-item-avatar tile size="62" class="mt-n10">
              <v-sheet color="orange" width="100" height="100" elevation="20">
                <v-icon dark large>mdi-silverware-fork-knife</v-icon>
              </v-sheet>
            </v-list-item-avatar>
            <v-list-item-content>
              <div class="overline text-right">Ribshack</div>
              <v-list-item-title class="headline mb-1 text-right">{{this.ribshackCount}}</v-list-item-title>
              <div>
                <v-divider></v-divider>
              </div>
            </v-list-item-content>
          </v-list-item>
          <v-card-actions>
              <router-link to="/admin/ribshack">
            <v-btn outlined color="orange">
              <span>View</span>
              <v-icon right>mdi-arrow-right</v-icon>
            </v-btn>
                   </router-link>
          </v-card-actions>
        </v-card>
      </v-flex>
      <v-flex sm12 xs12 md6 lg4 class="mb-3">
        <v-card class="mr-3 mb-3">
          <v-list-item>
            <v-list-item-avatar tile size="62" class="mt-n10">
              <v-sheet color="green" width="100" height="100" elevation="20">
                <v-icon dark large>mdi-tools</v-icon>
              </v-sheet>
            </v-list-item-avatar>
            <v-list-item-content>
              <div class="overline text-right">Delcom</div>
              <v-list-item-title class="headline mb-1 text-right">{{this.delcomCount}}</v-list-item-title>
              <div>
                <v-divider></v-divider>
              </div>
            </v-list-item-content>
          </v-list-item>
          <v-card-actions>
              <router-link to="/admin/delcom">
            <v-btn outlined color="green">
              <span>View</span>
              <v-icon right>mdi-arrow-right</v-icon>
            </v-btn>
            </router-link>
          </v-card-actions>
        </v-card>
      </v-flex>
      <v-flex sm12 xs12 md6 lg4 class="mb-3">
        <v-card class="mr-3 mb-3">
          <v-list-item>
            <v-list-item-avatar tile size="62" class="mt-n10">
              <v-sheet color="red" width="100" height="100" elevation="20">
                <v-icon dark large>mdi-dolly</v-icon>
              </v-sheet>
            </v-list-item-avatar>
            <v-list-item-content>
              <div class="overline text-right">Ramx</div>
              <v-list-item-title class="headline mb-1 text-right">{{this.ramxCount}}</v-list-item-title>
              <div>
                <v-divider></v-divider>
              </div>
            </v-list-item-content>
          </v-list-item>
          <v-card-actions>
              <router-link to="/admin/ramx">
            <v-btn outlined color="red">
              <span>View</span>
              <v-icon right>mdi-arrow-right</v-icon>
            </v-btn>
              </router-link>
          </v-card-actions>
        </v-card>
      </v-flex>
    </v-layout>
    <v-card v-for="project in projects" :key="project.title">
      <v-layout row wrap :class="`pa-3 project ${project.status}`">
        <v-flex xs12 md6>
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
      </v-layout>
    </v-card>
  </v-container>
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
      ribshackCount : 0,
      delcomCount : 0,
      ramxCount : 0
    };
  },
  created() {
    this.ribshack();
    this.delcom();
    this.ramx();
  },
  methods: {
    ribshack() {
      axios
        .get("/api/ribshack", {})
        .then(res => {
          this.ribshackCount = res.data.ribshack.length;
        })
        .catch(err => console.dir(err));
    },
    delcom() {
      axios
        .get("/api/delcom", {})
        .then(res => {
           this.delcomCount = res.data.delcom.length;
        })
        .catch(err => console.dir(err));
    },
    ramx() {
      axios
        .get("/api/ramx", {})
        .then(res => {
          this.ramxCount = res.data.ramx.length;
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
</style>