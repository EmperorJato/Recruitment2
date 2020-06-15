<template>
  <section class="sec1">
    <div class="bottomright">
      <p v-scrollanimation>Looking to serve you more.</p>
      <div id="btn" v-scrollanimation>
        <v-btn outlined color="#d63447" x-large>
          <v-icon>mdi-format-list-bulleted-square</v-icon>Our branches near you.
        </v-btn>
      </div>
    </div>
  </section>
</template>

<script>
export default {};
</script>

<style scoped>
p {
  transition-delay: 0.1s;
}

#btn {
  transition-delay: 0.3s;
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

section.sec1 {
  width: 100%;
  height: 100vh;
  background: url("/img/ribshack_bg4.jpg");
  background-size: cover;
}

section .bottomright {
  position: absolute;
  right: 180px;
  font-size: 30px;
  top: 20rem;
}

.v-btn {
  min-width: 0;
}

section.sec1 {
  background: url("/img/ribshack_bg.jpg");
  overflow-y: hidden !important;
  overflow-x: hidden !important;
  background-color: #f8f8f8;
  background-size: cover;
  background-repeat: no-repeat;
  background-position: left;
}

@media (max-width: 944px) {
  section.sec1 {
    background: url("/img/ribshack_bg.jpg");
    overflow-y: hidden !important;
    overflow-x: hidden !important;
    background-color: #f8f8f8;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    height: calc(100vh - 20px);
  }
  section .bottomright {
    position: absolute;
    right: 60px;
    font-size: 25px;
    top: 15rem;
    transition: 0.5s;
  }
}

@media (max-width: 320px) {
  section.sec1 {
    background: url("/img/ribshack_bg.jpg");
    overflow-y: hidden !important;
    overflow-x: hidden !important;
    background-color: #f8f8f8;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    height: calc(100vh - 5px);
  }
  section .bottomright {
    position: absolute;
    right: 5px;
    font-size: 20px;
    top: 15rem;
    transition: 0.5s;
  }

.v-btn {
  min-width: 0;
}
}

</style>