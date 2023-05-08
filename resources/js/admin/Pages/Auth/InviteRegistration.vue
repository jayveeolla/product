<template>
  <AuthLayout>
    <div>
      <!-- Header -->
      <div class="header bg-gradient-success py-7 py-lg-8 pt-lg-9">
        <div class="separator separator-bottom separator-skew zindex-100">
          <svg
            x="0"
            y="0"
            viewBox="0 0 2560 100"
            preserveAspectRatio="none"
            version="1.1"
            xmlns="http://www.w3.org/2000/svg"
          >
            <polygon
              class="fill-default"
              points="2560 0 2560 100 0 100"
            ></polygon>
          </svg>
        </div>
      </div>
      <!-- Page content -->
      <div class="container mt--8 pb-5">
        <div class="row justify-content-center">
          <div class="col-lg-8 col-md-7">
            <div class="card bg-secondary border-0 mb-0">
              <div class="card-body px-lg-5 py-lg-5">
                <form @submit.prevent="submit">
                  <base-input
                    label="Invite Code"
                    disabled
                    name="invite_code"
                    v-model="form.invite_code"
                    :error="form.errors.invite_code"
                  >
                  </base-input>
                  <div class="row">
                    <div class="col-md">
                      <base-input
                        label="First Name"
                        name="first_name"
                        v-model="form.first_name"
                        :error="form.errors.first_name"
                      >
                      </base-input>
                    </div>
                    <div class="col-md">
                      <base-input
                        label="Last Name"
                        name="last_name"
                        v-model="form.last_name"
                        :error="form.errors.last_name"
                      >
                      </base-input>
                    </div>
                  </div>
                  <base-input
                    name="email"
                    label="Email"
                    :error="form.errors.email"
                    v-model="form.email"
                  >
                  </base-input>
                  <base-input
                    name="mobile_number"
                    label="Mobile Number"
                    v-model="form.mobile_number"
                    :error="form.errors.mobile_number"
                  >
                  </base-input>
                  <div class="row">
                    <div class="col-md">
                      <base-input
                        label="Password"
                        type="password"
                        name="password"
                        v-model="form.password"
                        :error="form.errors.password"
                      >
                      </base-input>
                    </div>
                    <div class="col-md">
                      <base-input
                        type="password"
                        name="password_confirmation"
                        label="Password Confirmation"
                        v-model="form.password_confirmation"
                        :error="form.errors.password_confirmation"
                      >
                      </base-input>
                    </div>
                  </div>
                  <div class="text-center mt-4">
                    <base-input class="mb-1" name="Privacy Policy">
                      <base-checkbox v-model="form.agree">
                        <span class="text-muted"
                          >I agree with the <a href="#!">Privacy Policy</a> and
                          <a href="#!">Terms & Conditions</a></span
                        >
                      </base-checkbox>
                    </base-input>
                    <button
                      type="submit"
                      :disabled="!form.agree"
                      class="btn btn-primary mt-4"
                    >
                      Create account
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthLayout>
</template>
<script>
import AuthLayout from "@admin/Layouts/AuthLayout";
import { runToast } from "@admin/Utils/notification";

export default {
  components: {
    AuthLayout,
  },
  props: ["invite"],
  data() {
    return {
      form: this.$inertia.form({}),
    };
  },
  methods: {
    runToast,
  },
  mounted: function () {
    this.form = this.$inertia.form({
      agree: false,
      password: null,
      password_confirmation: null,
      mobile_number: null,
      ...this.invite,
    });
  },
  methods: {
    submit: function () {
      var vm = this;
      axios
        .post(route("api.invites.registerInvite"), this.form)
        .then((data) => {
          this.$inertia.visit("/login");
        })
        .catch((error) => {
          vm.form.errors = error.response.data.errors;
        });
    },
  },
};
</script>