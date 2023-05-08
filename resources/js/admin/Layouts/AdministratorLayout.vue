<template>
  <div class="wrapper">
    <!-- <notifications></notifications>  -->
    <side-bar   :logo="'/images/template/product.jfif'">
      <template v-slot:links>
        <sidebar-item
          :link="{
            icon: 'ni ni-chart-bar-32 text-primary',
            name: 'Dashboard',
            path: route('admin.dashboard'),
          }"
        >
          <template #icon>
            <feather-icon class="feather-18 mr-2" icon="home"></feather-icon>
          </template>
        </sidebar-item>
        <sidebar-item
          :link="{
            name: 'Product',
            path: route('admin.product.index'),
          }"
        >
          <template #icon>
            <feather-icon
              class="feather-18 mr-2"
              icon="calendar"
            ></feather-icon>
          </template>
        </sidebar-item>

      </template>
      <template v-slot:links-after> </template>
    </side-bar>
    <div class="main-content">
      <dashboard-navbar></dashboard-navbar>
      <div @click="$sidebar.displaySidebar(false)">
        <div class="content">
          <slot></slot>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
/* eslint-disable no-new */
import PerfectScrollbar from "perfect-scrollbar";
import "perfect-scrollbar/css/perfect-scrollbar.css";

function hasElement(className) {
  return document.getElementsByClassName(className).length > 0;
}

function initScrollbar(className) {
  if (hasElement(className)) {
    new PerfectScrollbar(`.${className}`);
  } else {
    // try to init it later in case this component is loaded async
    setTimeout(() => {
      initScrollbar(className);
    }, 100);
  }
}

import DashboardNavbar from "./DashboardNavbar.vue";
import ContentFooter from "./ContentFooter.vue";

export default {
  components: {
    DashboardNavbar,
    ContentFooter,
  },
  methods: {
    initScrollbar() {
      let isWindows = navigator.platform.startsWith("Win");
      if (isWindows) {
        initScrollbar("sidenav");
      }
    },
    logout() {
      this.$inertia.post(route("logout"));
    },
  },
  mounted() {
    this.initScrollbar();
  },
};
</script>
<style lang="scss">
.navbar-vertical .navbar-brand-img, .navbar-vertical .navbar-brand > img {
    max-width: 53% !important;
    max-height: 2rem;
}</style>
