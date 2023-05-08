<template>
  <div>
    <base-nav
      :show="showMenu"
      @change="showMenu = $event"
      type="secondary"
      :transparent="!hasBackground"
      menu-classes="justify-content-end"
      class="navbar-horizontal navbar-main p-lg-0"
      :class="hasBackground ? 'navbar-dark' : ''"
      expand="lg"
    >
      <template v-slot:brand>
        <div class="navbar-wrapper">
          <inertia-link class="navbar-brand" href="/">
            <!-- <img src="/img/brand/white.png" /> -->
          </inertia-link>
        </div>
      </template>

      <div class="navbar-collapse-header">
        <div class="row">
          <div class="col-6 collapse-brand">
            <inertia-link href="/">
              <!-- <img src="/img/brand/green.png" /> -->
            </inertia-link>
          </div>
          <div class="col-6 collapse-close">
            <button
              type="button"
              class="navbar-toggler"
              @click="showMenu = false"
            >
              <span></span>
              <span></span>
            </button>
          </div>
        </div>
      </div>
      <ul class="navbar-nav align-items-lg-center ml-lg-auto">
        <template v-if="$page.props.user">
          <li class="nav-item">
            <inertia-link href="/admin" class="nav-link">
              <span class="nav-link-inner--text">Admin Dashboard</span>
            </inertia-link>
          </li>
        </template>
      </ul>
      <UserDropDown v-if="$page.props.user" is-public />
    </base-nav>

    <div class="main-content">
      <slot></slot>
    </div>
  </div>
</template>
<script>
import UserDropDown from "./Components/UserDropdown";
export default {
  components: { UserDropDown },
  props: {
    backgroundColor: {
      type: String,
      default: "black",
    },
    hasBackground: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      showMenu: false,
      menuTransitionDuration: 250,
      pageTransitionDuration: 200,
      year: new Date().getFullYear(),
      pageClass: "login-page",
    };
  },
  computed: {
    title() {
      //   return `${this.$route.name} Page`;
    },
  },
  methods: {
    toggleNavbar() {
      document.body.classList.toggle("nav-open");
      this.showMenu = !this.showMenu;
    },
    closeMenu() {
      document.body.classList.remove("nav-open");
      this.showMenu = false;
    },
    setBackgroundColor() {
      document.body.classList.add("bg-primary");
    },
    removeBackgroundColor() {
      document.body.classList.remove("bg-primary");
    },
    updateBackground() {
      if (!this.hasBackground) {
        this.setBackgroundColor();
      } else {
        this.removeBackgroundColor();
      }
    },
    logout() {
      this.$inertia.post(route("logout"));
    },
  },
  beforeUnmount() {
    this.removeBackgroundColor();
  },
  beforeRouteUpdate(to, from, next) {
    // Close the mobile menu first then transition to next page
    if (this.showMenu) {
      this.closeMenu();
      setTimeout(() => {
        next();
      }, this.menuTransitionDuration);
    } else {
      next();
    }
  },
  watch: {
    $route: {
      immediate: true,
      handler: function () {
        this.updateBackground();
      },
    },
  },
};
</script>
<style lang="scss">
$scaleSize: 0.8;
@keyframes zoomIn8 {
  from {
    opacity: 0;
    transform: scale3d($scaleSize, $scaleSize, $scaleSize);
  }
  100% {
    opacity: 1;
  }
}

.main-content .zoomIn {
  animation-name: zoomIn8;
}

@keyframes zoomOut8 {
  from {
    opacity: 1;
  }
  to {
    opacity: 0;
    transform: scale3d($scaleSize, $scaleSize, $scaleSize);
  }
}

.main-content .zoomOut {
  animation-name: zoomOut8;
}
</style>
