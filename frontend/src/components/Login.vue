<template>
    <div id="login-page">
        <div id="login-card">
            <img src="https://cdn-icons-png.flaticon.com/512/3082/3082383.png" alt="RMS Logo" id="logo">
            
            <h1 id="login-card-title">
                Sign in
            </h1>
            
            <h3 id="login-card-message">
                Please login to UWDC Office Map
            </h3>
            
            <div class="field">
                <span class="material-symbols-outlined">
                    person
                </span>
                <input v-model="username" class="input-field" id="username-field" type="text" placeholder="Username" />
            </div>

            <div class="field" style="margin-top: 30px; text-align: left; margin-bottom: 10px; padding-left: 40px; font-weight: bold;">
                <span>Avatar</span>
            </div>

            <div class="avatar-selectors">
                <div class="avatar" :class="{selected: avatar === selected_avatar}" v-for="avatar in avatars" :key="avatar" @click="selectAvatar(avatar)">
                    <img :src="avatar" alt="avatar"/>
                </div>
            </div>
            

            <button @keydown="login()" class="input-field" @click="login()">Login</button>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Header',

    data: () => ({
        username: '',
        selected_avatar: '/avatars/avatar-01.svg',
        
        avatars: [
            '/avatars/avatar-01.svg',
            '/avatars/avatar-02.svg',
            '/avatars/avatar-03.svg',
            '/avatars/avatar-04.svg',
            '/avatars/avatar-05.svg',
            '/avatars/avatar-06.svg',
            '/avatars/avatar-07.svg',
            '/avatars/avatar-08.svg',
            '/avatars/avatar-09.svg',
            '/avatars/avatar-10.svg',
            '/avatars/avatar-11.svg',
            '/avatars/avatar-12.svg',
            '/avatars/avatar-13.svg',
            '/avatars/avatar-14.svg',
            '/avatars/avatar-15.svg',
            '/avatars/avatar-16.svg',
            '/avatars/avatar-17.svg',
            '/avatars/avatar-18.svg',
            '/avatars/avatar-19.svg'
        ]
    }),

    methods: {
        login() {
            this.$emit('login', this.username, this.selected_avatar);
        },

        selectAvatar(avatar) {
            this.selected_avatar = avatar;
        }
    }
}
</script>

<style scoped lang="scss">
.avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: #fff;
    margin: 0 10px;
    cursor: pointer;
    transition: all 0.2s ease-in-out;
    display: inline-block;
    filter: grayscale(100%);
    z-index: 0;
    position: relative;
    
    &.selected {
        background: rgb(107, 181, 107);
        transform: scale(1.3);
        filter: grayscale(0%);
        z-index: 100;
    }

    &:hover {
        transform: scale(1.1);
    }
    
    img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }
}

body {
  padding: 0;
  margin: 0;
  height: 100vh;
}

#login-page {
  background: red;
  height: calc(100vh - 100px);
  background: linear-gradient(
    135deg,
    rgb(255, 255, 255) 0%,
    rgba(36, 112, 114, 1) 63%,
    rgba(9, 68, 121, 1) 100%,
    rgba(0, 212, 255, 1) 100%
  );
  
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 50px;
}

#login-card {
  display: grid;
  padding: 50px;
  background: rgba(95%, 95%, 95%, 70%);
  width: 80vw;
  text-align: center;
  border-radius: 10px;
  max-width: 400px;
  position: relative;
  z-index: 10;
  background: rgba( 255, 255, 255, 0.25 );
box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );
backdrop-filter: blur( 4px );
-webkit-backdrop-filter: blur( 4px );
border-radius: 10px;
border: 1px solid rgba( 255, 255, 255, 0.18 );
}

#login-card:before {
  content: "";
  position: absolute;
  background: rgba(95%, 95%, 95%, 30%);
  inset: 0;
  transform: rotate(-2deg);
  border-radius: 10px;
  z-index: -10;
  background: rgba( 255, 255, 255, 0.25 );
box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );
backdrop-filter: blur( 4px );
-webkit-backdrop-filter: blur( 4px );
border-radius: 10px;
border: 1px solid rgba( 255, 255, 255, 0.18 );
}

#login-card:after {
  content: "";
  position: absolute;
  background: rgba(95%, 95%, 95%, 30%);
  inset: 0;
  transform: rotate(2deg);
  border-radius: 10px;
  z-index: -10;
  background: rgba( 255, 255, 255, 0.25 );
box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );
backdrop-filter: blur( 4px );
-webkit-backdrop-filter: blur( 4px );
border-radius: 10px;
border: 1px solid rgba( 255, 255, 255, 0.18 );
}

#login-card #logo {
  width: 100px;
  height: 100px;
  display: inline-block;
  filter: grayscale(100%);
  margin-left: calc(50% - 50px);
  margin-bottom: 50px;
}

#login-card .field .material-symbols-outlined {
  margin-right: -20px;
  z-index: 20;
  position: relative;
  right: -16px;
  top: 6px;
  color: #999;
}

#login-card input {
  border-radius: 1000px;
  border: none;
  margin: 5px 0;
  padding: 10px;
  width: calc(100% - 100px);
  padding-left: 40px;
  background: white;
  color: black;

  // Get rid of firefox outline
  &:focus {
    outline: none;
  }
}

#login-card input#password-field {
  margin-bottom: 20px;
}

#login-card h1 {
  margin: 0;
  font-size: 40px;
  font-weight: bold;
}

#login-card h3 {
  color: #222;
  font-weight: normal;
  font-size: 15px;
}

#login-card button {
  background: black;
  border: none;
  color: white;
  border-radius: 10000px;
  padding: 14px;
  font-size: 16px;
  margin: 20px 0;
  text-transform: uppercase;
}

#login-card button:hover {
  cursor: pointer;
  outline: 2px solid white;
  box-shadow: 0px 0px 20px 10px rgba(255, 255, 255, 1);
}

#login-card #login-card-title {
  margin-top: -20px;
  margin-bottom: -10px;
}

#login-card #login-card-message {
  margin-bottom: 40px;
}

#login-card #login-card-message-error {
  margin-bottom: 40px;
  color: #973c3c;
  font-weight: bold;
}

#version {
  position: absolute;
  bottom: 5px;
  left: 5px;
  font-weight: bold;
  opacity: 0.7;
}

.material-symbols-outlined {
  font-variation-settings: "FILL" 0, "wght" 400, "GRAD" 0, "opsz" 48;
}
</style>
