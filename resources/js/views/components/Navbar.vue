<template>
  <nav :class="colorChange">
    <input type="checkbox" id="check" />
    <label for="check" class="checkBtn">
      <i class="mdi mdi-format-list-bulleted"></i>
    </label>
    <div class="logo">
      <img src="/img/ribshack_logo.png" alt />
    </div>
    <ul>
      <router-link to="/" active-class="active">
        <li>
          <a href="#">Home</a>
        </li>
      </router-link>

      <li>
        <a href="#">About</a>
      </li>
      <li>
        <a href="#">Services</a>
      </li>
      <li>
        <a href="#">Contact</a>
      </li>
      <router-link to="/opportunities" active-class="active">
        <li>
          <a href="#">Job Opportunities</a>
        </li>
      </router-link>
    </ul>
  </nav>
</template>

<script>
export default {
  data() {
    return {
      colorChange: "",
      lastScrollPosition: 0
    };
  },

  mounted() {
    window.addEventListener("scroll", this.onScroll);
  },

  beforeDestroy() {
    window.removeEventListener("scroll", this.onScroll);
  },
  methods: {
    onScroll() {
      const currentScrollPosition =
        window.pageYOffset || document.documentElement.scrollTop;
      if (currentScrollPosition > 0) {
        this.colorChange = "color-change";
      } else {
        this.colorChange = "";
      }

      this.lastScrollPosition = currentScrollPosition;
    }
  }
};
</script>

<style scoped>
nav {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100px;
  padding: 10px 80px;
  box-sizing: border-box;
  transition: 0.5s;
  font-weight: 700;
}

nav .logo {
  float: left;
}

nav .logo img {
  height: 80px;
  transition: 0.5s;
}

nav ul {
  float: right;
  margin: 0;
  padding: 0;
  z-index: 99;
}

nav ul li {
  display: inline-block;
  line-height: 80px;
  list-style: none;
  z-index: 99;
}

nav ul li a {
  color: #262626;
  padding: 2px 20px;
  line-height: 80px;
  text-decoration: none;
  text-transform: uppercase;
  transition: 0.5s;
}

nav ul li a.active,
nav ul li a:hover {
  border-bottom: 5px solid #f00;
}

.checkBtn {
  font-size: 40px;
  float: right;
  line-height: 80px;
  cursor: pointer;
  color: #fff;
  display: none;
}

#check {
  display: none;
}

.color-change {
  background: #f33232;
  color: #fff;
  z-index: 999;
  height: 60px;
  line-height: 60px;
}

.color-change ul {
  line-height: 60px;
  padding: -30px 10px;
}

.color-change ul li {
  line-height: 60px;
}

.color-change ul li a {
  color: #fff;
}

@media (max-width: 952px) {
  label.logo {
    font-size: 20px;
    padding-left: 50px;
  }

  nav ul li a {
    font-size: 16px;
  }
}

@media (max-width: 944px) {
  nav {
    background: #f33232;
    height: 80px;
    transition: 0.5s;
    z-index: 99;
    padding: 15px 15px;
  }

  nav .logo img {
    height: 60px;
    transition: 0.5s;
  }

  .checkBtn {
    display: block;
    font-size: 30px;
    float: right;
    line-height: 60px;
  }

  ul {
    position: fixed;
    width: 100%;
    height: 100vh;
    padding: 20px;
    background: #f33232;
    top: 80px;
    right: -100%;
    text-align: center;
    transition: all 0.5s;
    z-index: 999;
  }
  nav ul li {
    display: block;
    margin: 10px 0;
    line-height: 15px;
  }
  nav ul li a {
    font-size: 15px;
    color: #fff;
  }
  a:hover,
  a.active {
    color: #0082e6;
  }

  #check:checked ~ ul {
    right: 0;
  }
}

@media (max-width: 320px) {
nav {
    background: #f33232;
    height: 80px;
    transition: 0.5s;
    z-index: 99;
    padding: 15px 15px;
  }

  nav .logo img {
    height: 60px;
    transition: 0.5s;
  }

  .checkBtn {
    display: block;
    font-size: 20px;
    right: 0;
  }

  ul {
    position: fixed;
    width: 100%;
    height: 100vh;
    padding: 10px;
    background: #f33232;
    top: 80px;
    right: -100%;
    text-align: center;
    transition: all 0.5s;
    z-index: 999;
  }
  nav ul li {
    display: block;
    margin: 10px 0;
    line-height: 15px;
  }
  nav ul li a {
    font-size: 15px;
    color: #fff;
  }
  a:hover,
  a.active {
    color: #0082e6;
  }

}

</style>