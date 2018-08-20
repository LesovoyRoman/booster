<template>
  <li class="dropdown" :class="{open:isOpen}" @click="toggleDropDown" data-toggle="dropdown">
    <a class="dropdown-toggle btn-rotate"  >
      <slot name="title">
        <i :class="icon"></i>
        <p class="notification">{{title}}
          <b class="caret"></b>
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
      title: this.title,
      icon: String,
    },
    data () {
      return {
        isOpen: false,
      }
    },
    methods: {
      toggleDropDown () {
          this.isOpen = !this.isOpen
      },
      closeDropDown () {
        this.isOpen = false
      },
    },
  }
</script>
