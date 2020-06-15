<template>
  <v-card>
    <v-card-title>
      Request
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
      :items="requesting"
      :search="search"
      :loading="loading"
      loading-text="Loading... Please wait"
      class="elevation-1"
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
                @click="editItem(item.id)"
              >mdi-eye</v-icon>
            </template>
            <span>View</span>
          </v-tooltip>
           <v-tooltip bottom>
            <template v-slot:activator="{on}">
              <v-icon
                small
                color="success"
                v-on="on"
                class="mr-2"
                @click="approve(item.id)"
              >mdi-thumb-up</v-icon>
            </template>
            <span>Approve</span>
          </v-tooltip>
          <v-tooltip bottom>
            <template v-slot:activator="{on}">
              <v-icon small color="error" v-on="on" @click="disapprove(item.id)">mdi-thumb-down</v-icon>
            </template>
            <span>Disapprove</span>
          </v-tooltip>
        </div>
      </template>
      <template v-slot:item.date="{ item }">{{ formatDate(item.date) }}</template>
      <template v-slot:item.urgent="{ item }">
        <v-chip :color="getColor(item.urgent)" dark>{{ item.urgent.toUpperCase() }}</v-chip>
      </template>
      <template v-slot:item.approval_status="{ item }">
        <v-chip :color="statusColor(item.approval_status)" dark>{{ item.approval_status }}</v-chip>
      </template>
    </v-data-table>
  </v-card>
</template>

<script>
import moment from "moment";
export default {
  data: () => ({
    dialog: false,
    search: "",
    loading: true,
    headers: [
      {
        text: "Date",
        value: "date"
      },
       {
        text: "Requester",
        value: "requester"
      },
      {
        text: "Requesting",
        value: "requesting"
      },
      {
        text: "Total Request",
        value: "num_request"
      },
            {
        text: "Type of Request",
        value: "type_request"
      },
      {
        text: "Urgent",
        value: "urgent"
      },
       {
        text: "Status",
        value: "approval_status"
      },
      {
        text: "Action",
        value: "action",
        sortable: false
      }
    ],
    requesting : [],
    form: new Form({}),
  }),

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "New Request" : "Edit Request";
    }
  },

  watch: {
    dialog(val) {
      val || this.close();
    }
  },

  mounted() {

  },

  created() {

    this.initialize();

    Fire.$on("afterCreate", () => {
      this.initialize();
    });

    if (this.$store.state.currentUser == null && !localStorage.getItem("user")) {
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

    initialize(){
      axios.get('/api/admin_request', {})
      .then( (res) => {
        this.requesting = res.data.admin_request;
        this.loading = false;
      })
      .catch( err => console.dir(err));
    },

    logout() {
      this.$store.commit("logout");
      this.$router.push("/login");
    },

    deleteItem(id) {
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
      }).then((result) => {
        if (result.value) {
          this.form
          .delete("/api/requesting/" + id)
          .then((res) => {
            Fire.$emit('afterCreate')
            Swal.fire("Deleted!", "Your file has been deleted.", "success")
          })
          .catch(err => {
            Swal.fire({
              icon: "error",
              title: "Error",
              text: err
            })
          })

        }
      })
    },

    editItem(id){
      this.$router.push('/admin/request/'+id)
    },

    formatDate(value) {
      return moment(value).format("MMMM DD, YYYY");
    },
    getColor(urgent) {
      if (urgent == "Yes") return "red";
    },
    statusColor(approval_status) {
      if (approval_status == "APPROVED") {
        return "green";
      }

      if (approval_status == "DISAPPROVED") {
        return "red";
      }
    },
    approve(id){
      this.form
        .patch("/api/admin/approve/" + id)
        .then(res => {
          Fire.$emit('afterCreate');
          Swal.fire({
            icon: "success",
            title: "Success",
            text: "Successfully Approved"
          })
        })
        .catch(err => {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: err
          });
        });
    },
    disapprove(id){
      this.form
        .patch("/api/admin/disapprove/" + id)
        .then(res => {
          Fire.$emit('afterCreate');
          Swal.fire({
            icon: "success",
            title: "Success",
            text: "Successfully Disapproved"
          })
        })
        .catch(err => {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: err
          });
        });
    }
  }
};
</script>