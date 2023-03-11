<template>
  <div v-if="isLoggedIn">
    <Map :avatar="avatar" :username="username" @logout="logout" />
  </div>

  <div v-else>
    <Login @login="login" />
  </div>
</template>

<script>
import Map from "./components/Map.vue";
import Login from "./components/Login.vue";

export default {
  data: () => ({
    isLoggedIn: false,
    username: "",
    avatar: ""
  }),
  
  components: {
    Map,
    Login
  },

  methods: {
    login(username, avatar) {
      this.isLoggedIn = true;
      this.avatar = avatar;
      this.username = username;
    },

    logout() {
      this.isLoggedIn = false;
      this.avatar = "";
      this.username = "";
    }
  }
}
</script>