<template>
    <ul class="navbar-nav" :class="isPublic ? '' : 'align-items-center ml-auto ml-md-0'">
      <base-dropdown
        menu-on-right
        class="nav-item"
        tag="li"
        title-tag="a"
        title-classes="nav-link pr-0"
      >
        <template v-slot:title-container>
          <a href="#" class="nav-link pr-0" @click.prevent>
            <div class="media align-items-center">
              <span class="avatar avatar-sm rounded-circle">
                <img alt="Image placeholder" :src="$page.props.user.profile_photo_url" />
              </span>
              <div class="media-body ml-2 " :class="isPublic ? '' : 'd-none d-lg-block'">
                <span class="mb-0 text-sm font-weight-bold">{{$page.props.user.name}}</span>
              </div>
            </div>
          </a>
        </template>

        <div class="dropdown-header noti-title">
          <h6 class="text-overflow m-0">Welcome!</h6>
        </div>
        <inertia-link :href="route('profile.show')" class="dropdown-item">
          <i class="ni ni-single-02"></i>
          <span>My profile</span>
        </inertia-link>
        <div class="dropdown-divider"></div>
        <a href="#" @click="logout" class="dropdown-item">
          <i class="ni ni-user-run"></i>
          <span>Logout</span>
        </a>
      </base-dropdown>
    </ul>
</template>

<script>
export default {
    props: {
        isPublic: {
            type: Boolean,
            default: false,
        }
    },
  methods: {
    logout() {
        this.$inertia.post(route('logout'));
    },
  },
}
</script>

<style>

</style>