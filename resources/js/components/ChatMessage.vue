<template>
  <ul>
    <li class="replies">
      <img src="http://emilcarlsson.se/assets/harveyspecter.png" alt="" />
      <p>{{ message.message }}</p>
    </li>
  </ul>
</template>
<script>
export default {
  props: ["messages"],
};
</script>