<template>
  <div>
    <div id="main-app">
      <div id="navigation">
        <button id="logout-btn" @click="logout()">Log out</button>
  
        <div id="profile">
          <img :src="avatar" alt="avatar" />
          <div>
            <h3>{{ username }}</h3>
            <p>Being at work {{ sessionLengthString }}</p>
          </div>
        </div>
  
        <hr />
  
        <div id="offices" :class="{ 'full-height': currentRoom == null }">
          <div v-for="(office, name) in officeSpaces" :key="name">
            <div class="office-name" :class="{ full: office.workers.length >= office.maxCapacity }" @click="tryJoinRoom(office)">
              {{ office.name }}
  
              <span class="office-occupancy">
                <span>({{ office.workers.length }} / {{ office.maxCapacity }})</span>
              </span>
            </div>
  
            <div v-if="office.workers.length === 0" class="worker">&lt;empty&gt;</div>
  
            <div v-for="worker in office.workers" :key="worker.name" class="worker">
              <img :src="`/avatars/${worker.avatar}`" alt="avatar" />
              <span>{{ worker.name }}</span>
            </div>
          </div>
        </div>
  
        <div id="office-chat" v-if="currentRoom != null">
          <hr />
          <span class="nav-label">
            {{ currentRoom }} chat
          </span>
          <div id="chat-window">
            <div v-for="msg in chatMessages" :key="msg.msg" class="msg">
              <span class="username" :style="`color: ${hashStringToColor(msg.by)}`">{{ msg.by }}</span>
              <span>{{ msg.msg }}</span>
            </div>
          </div>
  
          <span class="nav-label">
            Send message
          </span>
          <div>
            <input type="text" id="typing-bar" v-model="currentMessage" @keydown="trySendMessage($event)" :disabled="sendingMsg">
            <div id="send-button" @click="sendMessage"></div>
          </div>
        </div>
      </div>

      <div id="map">
        <img src="/office_base_clean/office_base_clean.jpg" alt="office-map">
      </div>
    </div>
  </div>  
  </template>
  
  <script>
  import axios from 'axios';

  export default {
    name: 'OfficeMap',
    props: ['username', 'avatar'],

    data: () => ({
      sessionStart: 0,
      sessionLength: 0,
      currentMessage: '',
      currentRoom: null,
      sendingMsg: false,
      chatMessages: [],
      lastMsgId: null,
      officeSpaces: [],
      officeCoords: {
        "The office": {},
      }
    }),

    methods: {
      GetXYStyling(office, worker) {
        console.log(office.name)
        return 'position: absolute; top: 50px;';
        
      },

      async loadMessages() {
        try {
          const data = (await axios.get(API + 'chats?room=' + this.currentRoom)).data;
          this.chatMessages = data;
        } catch (err) {
          console.log(err);
        }

        this.$nextTick(() => {
          if (this.chatMessages.length > 0) {
            if (this.lastMsgId === this.chatMessages[this.chatMessages.length - 1].id) return;
            this.scrollChatToBottom();
            this.lastMsgId = this.chatMessages[this.chatMessages.length - 1].id;
          }
        });
      },

      async logout() {
        await axios.post(API + 'rooms', {
            'name': this.username,
            'room': '',
            'avatar': ''
          });

        this.$emit('logout')
      },

      async loadRooms() {
        try {
          const data = (await axios.get(API + 'rooms')).data;
          this.officeSpaces = data;
        } catch (err) {
          console.log(err);
        }
      },

      async tryJoinRoom(room) {
        // Dont join if full
        if (room.workers.length >= room.maxCapacity) return;

        try {
          const avatar = this.avatar.split('/').pop();
          await axios.post(API + 'rooms', {
            'name': this.username,
            'room': room.name,
            'avatar': avatar
          });

          this.currentRoom = room.name;
          await this.loadRooms();
        } catch (err) {
          console.log(err);
        }
      },
      
      scrollChatToBottom() {
        const chatWindow = document.getElementById('chat-window');
        if (chatWindow == null)
          return
        chatWindow.scrollTop = chatWindow.scrollHeight;
      },

      hashStringToColor(number) {
        let hash = 0;
        for (let i = 0; i < number.length; i++) {
          hash = number.charCodeAt(i) + ((hash << 5) - hash);
        }
        return `hsl(${hash % 255} 80% 40%);`;
      },

      trySendMessage(event) {
        if (event.key === 'Enter')
          this.sendMessage();
      },

      async sendMessage() {
        try {
          this.sendingMsg = true
          await axios.post(API + 'chats', {
            'by': this.username,
            'msg': this.currentMessage,
            'room': this.currentRoom
          });
        } catch (err) {
          console.log(err);
        }

        this.currentMessage = '';
        this.sendingMsg = false;
      }
    },
  
    mounted() {
      this.sessionStart = new Date();
      const that = this;
      setInterval(() => {
        that.sessionLength = Math.floor((new Date() - that.sessionStart) / 1000);
      }, 1000);

      // Hot reloading messages
      setInterval(() => {
        this.loadMessages();
      }, 2000);

      // Hot reloading rooms
      setInterval(() => {
        this.loadRooms();
      }, 2000);
    },
  
    computed: {
      // Computed prop that calculates a user formatted string of the session length
      sessionLengthString() {
        const hours = Math.floor(this.sessionLength / 3600);
        const minutes = Math.floor((this.sessionLength - (hours * 3600)) / 60);
        const seconds = this.sessionLength - (hours * 3600) - (minutes * 60);
  
        return `${hours}h ${minutes}m ${seconds}s`;
      }
    }
  }
  </script>
  
  <style scoped lang="scss">
  #main-app {
    display: grid;
    grid-template-columns: 400px auto;
  
    /*
    =====================
       Navigation bar
    =====================
    */
    #navigation {
      display: block;
      background-color: #f1f1f1;
      height: 100vh;
      position: relative;
  
      .nav-label {
        display: block;
        font-size: 1.2rem;
        font-weight: 600;
        padding-left: 10px;
        padding-top: 10px;
      }
  
      #logout-btn {
        display: block;
        width: 100%;
        height: 50px;
        background-color: #b0b0b0;
        border: none;
        font-size: 1.2rem;
        font-weight: 600;
        cursor: pointer;
  
        &:hover {
          background-color: #a0a0a0;
        }
      }
  
      #profile {
        display: grid;
        grid-template-columns: 120px auto;
        align-items: center;
  
        img {
          padding-right: 20px;
        }
      }
  
      hr {
        margin: 0;
        border: 1px solid #b0b0b0;
      }
  
      #offices {
        overflow: auto;
        height: calc(100vh - 550px);

        &.full-height {
          height: calc(100vh - 160px);
        }
  
        .office-name {
          color: #202020;
          font-weight: 600;
          padding-left: 5px;
          font-size: 18px;
          padding-top: 10px;

          &.full {
            color: red;
          }
  
          &:hover:not(.full) {
            color: #404040;
            cursor: pointer;
            text-decoration: underline;
          }
  
          .office-occupancy {
            font-size: 0.8rem;
            color: #202020;
            font-weight: normal;
          }
        }
  
        .worker {
          display: flex;
          align-items: center;
          padding-left: 10px;
          padding-top: 5px;
          padding-bottom: 5px;
  
          img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            padding-right: 10px;
          }
  
          .worker-name {
            font-size: 0.8rem;
            color: #202020;
            font-weight: normal;
          }
        }
      }
  
      #office-chat {
        position: absolute;
        bottom: 10px;
        width: 100%;
        background-color: #f1f1f1;
        font-size: 1.2rem;
  
        #chat-window {
          margin: 0;
          background: white;
          margin: 10px;
          padding: 5px;
          height: 200px;
          overflow: auto;
          
          .msg {
            margin-bottom: 10px;
  
            .username {
              font-weight: 600;
              overflow: hidden;
              display: block;
              display: flex;
              white-space: nowrap;
              text-overflow: ellipsis;
              margin-right: 10px;
            }
          }
        }
  
        #typing-bar {
          margin: 0;
          background: white;
          margin: 10px;
          padding: 10px;
          display: block;
          width: 360px;
          border: none;
          font-size: 1.2rem;
        }
  
        #send-button {
          display: inline-block;
          position: absolute;
          width: 10px;
          height: 10px;
          background-color: none;
          right: 20px;
          bottom: 22px;
          border-top: 10px solid #a0a0a0;
          border-right: 10px solid #a0a0a0;
          transform: rotate(45deg);
        }
      }
    }
  
    /*
    =====================
       Map
    =====================
    */
    #map {
      img {
        width: 100%;
        height: 100%;
        object-fit: contain;
      }
    }

    // #map-office {
    //   position: absolute;
    //   visibility: hidden;
    //   display: none;
    // }
  }

  #map-indicators {
    position: absolute;
    top: 0;
    left: 400px;

    img {
      width: 20px;
      height: 20px;
    }
  }
  </style>
  