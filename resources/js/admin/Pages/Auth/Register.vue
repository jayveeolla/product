<template>
  <AuthLayout>
    <div>
      <!-- Header -->
      <div
        class="header py-7 py-lg-8 pt-lg-9"
        style="background-color: #f3ac89"
      ></div>
      <!-- Page content -->
      <div class="container mt--8 pb-5">
        <!-- Table -->
        <div class="row justify-content-center">
          <div class="col-lg-6 col-md-8">
            <div class="card bg-secondary border-0">
              <div class="card-header bg-transparent pb-5">
                <div class="text-muted text-center mt-2 mb-4">
                  <small>Sign up with</small>
                </div>
                <div class="text-center">
                  <a href="#" class="btn btn-neutral btn-icon mr-4">
                    <span class="btn-inner--icon"
                      ><img src="img/icons/common/github.svg"
                    /></span>
                    <span class="btn-inner--text">Github</span>
                  </a>
                  <a href="#" class="btn btn-neutral btn-icon">
                    <span class="btn-inner--icon"
                      ><img src="img/icons/common/google.svg"
                    /></span>
                    <span class="btn-inner--text">Google</span>
                  </a>
                </div>
              </div>
              <div class="card-body px-lg-5 py-lg-5">
                <div class="text-center text-muted mb-4">
                  <small>Or sign up with credentials</small>
                </div>
                <Form @submit="onSubmit" :validation-schema="schema">
                  <base-input
                    alternative
                    class="mb-3"
                    addon-left-icon="ni ni-hat-3"
                    placeholder="Name"
                    name="fullName"
                  >
                  </base-input>

                  <base-input
                    alternative
                    class="mb-3"
                    addon-left-icon="ni ni-email-83"
                    placeholder="Email"
                    name="email"
                  >
                  </base-input>

                  <base-input
                    alternative
                    class="mb-3"
                    addon-left-icon="ni ni-lock-circle-open"
                    placeholder="Password"
                    type="password"
                    name="password"
                  >
                  </base-input>
                  <div class="text-muted font-italic">
                    <small
                      >password strength:
                      <span class="text-success font-weight-700"
                        >strong</span
                      ></small
                    >
                  </div>
                  <div class="row my-4">
                    <div class="col-12">
                      <base-input name="Privacy Policy">
                        <base-checkbox v-model="model.agree">
                          <span class="text-muted"
                            >I agree with the
                            <a href="#!">Privacy Policy</a></span
                          >
                        </base-checkbox>
                      </base-input>
                    </div>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary mt-4">
                      Create account
                    </button>
                  </div>
                </Form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthLayout>
</template>
<script>
import { Form } from "vee-validate";
import * as Yup from "yup";
import AuthLayout from "@admin/Layouts/AuthLayout";

export default {
  name: "register",
  components: {
    Form,
    AuthLayout,
  },
  data() {
    return {
      model: {
        name: "",
        email: "",
        password: "",
        agree: false,
      },
    };
  },
  setup() {
    function onSubmit(values) {
      alert(JSON.stringify(values, null, 2));
    }

    const schema = Yup.object().shape({
      fullName: Yup.string().required().label("The Full Name"),
      email: Yup.string().email().required().label("The Email"),
      password: Yup.string().min(5).required().label("The Password"),
    });

    return {
      onSubmit,
      schema,
    };
  },
};
</script>
<style></style>
