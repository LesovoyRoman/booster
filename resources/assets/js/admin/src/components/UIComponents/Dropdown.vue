<template>
  <li class="dropdown" :class="{open:isOpen}" @click="toggleDropDown" data-toggle="dropdown">
    <a class="dropdown-toggle btn-rotate"  >
      <slot name="title">
        <i :class="icon"></i>
        <p class="notification">{{ownTitle}}
          <b class="caret" v-if="notCaret == undefined"></b>
        </p>
      </slot>
    </a>
    <ul class="dropdown-menu">
      <slot></slot>
    </ul>
  </li>
</template>
<script>
  export default{
    props: {
      icon: String,
      title: String,
      notCaret: this.notCaret
    },
    data () {
      return {
        isOpen: false,
        ownTitle: ''
      }
    },
    methods: {
      toggleDropDown () {
          this.isOpen = !this.isOpen
      },
      closeDropDown () {
        this.isOpen = false
      },
      clickDropDown(newTitle) {
          this.ownTitle = newTitle;
      },
    },
    created() {
        this.ownTitle = this.title;
    }
  }
</script>
