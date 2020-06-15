<template>
  <v-container class="my-6">
    <v-layout row wrap>
      <v-flex sm12 xs12 md6 lg4 class="mb-3">
        <v-card class="mr-3 mb-3">
          <v-list-item>
            <v-list-item-avatar tile size="62" class="mt-n10">
              <v-sheet color="orange" width="100" height="100" elevation="20">
                <v-icon dark large>mdi-account-clock</v-icon>
              </v-sheet>
            </v-list-item-avatar>
            <v-list-item-content>
              <div class="overline text-right">Pending</div>
              <v-list-item-title class="headline mb-1 text-right">3</v-list-item-title>
              <div>
                <v-divider></v-divider>
              </div>
            </v-list-item-content>
          </v-list-item>
          <v-card-actions>
            <v-btn outlined color="orange">
              <span>View</span>
              <v-icon right>mdi-arrow-right</v-icon>
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-flex>
      <v-flex sm12 xs12 md6 lg4 class="mb-3">
        <v-card class="mr-3 mb-3">
          <v-list-item>
            <v-list-item-avatar tile size="62" class="mt-n10">
              <v-sheet color="green" width="100" height="100" elevation="20">
                <v-icon dark large>mdi-account-check</v-icon>
              </v-sheet>
            </v-list-item-avatar>
            <v-list-item-content>
              <div class="overline text-right">Approved</div>
              <v-list-item-title class="headline mb-1 text-right">6</v-list-item-title>
              <div>
                <v-divider></v-divider>
              </div>
            </v-list-item-content>
          </v-list-item>
          <v-card-actions>
             <v-btn outlined color="green">
              <span>View</span>
              <v-icon right>mdi-arrow-right</v-icon>
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-flex>
      <v-flex sm12 xs12 md6 lg4 class="mb-3">
        <v-card class="mr-3 mb-3">
          <v-list-item>
            <v-list-item-avatar tile size="62" class="mt-n10">
              <v-sheet color="red" width="100" height="100" elevation="20">
                <v-icon dark large>mdi-account-cancel</v-icon>
              </v-sheet>
            </v-list-item-avatar>
            <v-list-item-content>
              <div class="overline text-right">Disapproved</div>
              <v-list-item-title class="headline mb-1 text-right">4</v-list-item-title>
              <div>
                <v-divider></v-divider>
              </div>
            </v-list-item-content>
          </v-list-item>
          <v-card-actions>
                 <v-btn outlined color="red">
              <span>View</span>
              <v-icon right>mdi-arrow-right</v-icon>
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-flex>
    </v-layout>
    <v-card flat v-for="project in projects" :key="project.title">
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
    <!-- <v-layout row wrap>
      <v-flex xs12 sm6 md3 lg3 class="mt-3">
        <v-card class="text-center mr-3 mt-3">
          <v-responsive class="pt-4">
            <v-avatar size="100" class="red lighten-2">
              <v-img></v-img>
            </v-avatar>
          </v-responsive>
          <v-card-text>
            <div class="subhrading">Steto Javelana</div>
            <div class="grey--text">Junior Programmer</div>
          </v-card-text>
          <v-card-actions>
            <v-btn outlined color="primary">
              <v-icon small left>mdi-message</v-icon>
              <span>Message</span>
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-flex>
      <v-flex xs12 sm6 md3 lg3 class="mt-3">
        <v-card class="text-center mr-3 mt-3">
          <v-responsive class="pt-4">
            <v-avatar size="100" class="red lighten-2">
              <v-img></v-img>
            </v-avatar>
          </v-responsive>
          <v-card-text>
            <div class="subhrading">Steto Javelana</div>
            <div class="grey--text">Junior Programmer</div>
          </v-card-text>
          <v-card-actions>
            <v-btn outlined color="primary">
              <v-icon small left>mdi-message</v-icon>
              <span>Message</span>
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-flex>
      <v-flex xs12 sm6 md3 lg3 class="mt-3">
        <v-card class="text-center mr-3 mt-3">
          <v-responsive class="pt-4">
            <v-avatar size="100" class="red lighten-2">
              <v-img></v-img>
            </v-avatar>
          </v-responsive>
          <v-card-text>
            <div class="subhrading">Steto Javelana</div>
            <div class="grey--text">Junior Programmer</div>
          </v-card-text>
          <v-card-actions>
            <v-btn outlined color="primary">
              <v-icon small left>mdi-message</v-icon>
              <span>Message</span>
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-flex>
      <v-flex xs12 sm6 md3 lg3 class="mt-3">
        <v-card class="text-center mr-3 mt-3">
          <v-responsive class="pt-4">
            <v-avatar size="100" class="red lighten-2">
              <v-img></v-img>
            </v-avatar>
          </v-responsive>
          <v-card-text>
            <div class="subhrading">Steto Javelana</div>
            <div class="grey--text">Junior Programmer</div>
          </v-card-text>
          <v-card-actions>
            <v-btn outlined color="primary">
              <v-icon small left>mdi-message</v-icon>
              <span>Message</span>
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-flex>
    </v-layout> -->
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
      ]
    };
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
  background : orange;
}
.v-chip.approved {
  background : green;
}
.v-chip.disapproved {
  background : red;
}
</style>