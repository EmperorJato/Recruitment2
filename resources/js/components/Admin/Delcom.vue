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
      :items="delcom"
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
                color="success"
                v-on="on"
                class="mr-2"
                @click="editItem(item.id)"
              >mdi-pencil</v-icon>
            </template>
            <span>Edit</span>
          </v-tooltip>
          <v-tooltip bottom>
            <template v-slot:activator="{on}">
              <v-icon small color="error" v-on="on" @click="deleteItem(item.id)">mdi-delete</v-icon>
            </template>
            <span>Delete</span>
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
        text: "Requesting",
        value: "requesting"
      },
      {
        text: "Total Request",
        value: "num_request"
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
    delcom : [],
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
      axios.get('/api/delcom', {})
      .then( (res) => {
        this.delcom = res.data.delcom;
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
      this.$router.push('/user/requesting/'+id)
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
  }
};
</script>