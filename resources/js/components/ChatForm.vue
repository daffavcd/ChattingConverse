<template>
  <input type="text" placeholder="Write your message..." />
  <i class="fa fa-paperclip attachment" aria-hidden="true"></i>
  <button class="submit" @click="sendMessage">
    <i class="fa fa-paper-plane" aria-hidden="true"></i>
  </button>
</template>
<script>
export default {
  props: ["user"],

  data() {
    return {
      newMessage: "",
    };
  },

  methods: {
    sendMessage() {
      this.$emit("messagesent", {
        user: this.user,
        message: this.newMessage,
      });

      this.newMessage = "";
    },
  },
};
</script>