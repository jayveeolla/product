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
					<div class="col-lg-5 col-md-7">
						<div class="card bg-secondary border-0 mb-0">
							<div class="card-body px-lg-5 py-lg-5">
								<Form @submit="onSubmit" :validation-schema="schema">
									<base-input
										alternative
										name="email"
										v-model="form.email"
										addon-left-icon="ni ni-email-83"
										placeholder="Email"
                              			:error="form.errors.email"
									>
									</base-input>

									<base-input
										alternative
										name="password"
										addon-left-icon="ni ni-lock-circle-open"
										type="password"
										v-model="form.password"
										placeholder="Password"
                              			:error="form.errors.password"
									>
									</base-input>

									<base-checkbox v-model="form.rememberMe"
										>Remember me</base-checkbox
									>
									<div class="text-center">
										<base-button
											type="primary"
											native-type="submit"
											class="my-4"
											>Sign in</base-button
										>
									</div>
								</Form>
							</div>
						</div>
						<div class="row mt-3">
							<div class="col-6">
								<inertia-link :href="route('password.request')" class="text-light"
									><small>Forgot password?</small></inertia-link
								>
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
	import AuthLayout from "@/Layouts/AuthLayout";
	import Notification from "@/Argon/components/Notification";
	import { runToast } from "@/Utils/notification";

	export default {
		components: {
			Form,
			AuthLayout,
		},
		data() {
			return {
				form: this.$inertia.form({
					email: "admin@admin.com",
					password: "password",
					rememberMe: false,
				}),
			};
		},
		methods: {
			runToast,
			onSubmit: function (value) {
				this.form.post(route("login"), {
					preserveScroll: true,
					onSuccess: (success) => {
						this.runToast('top-right', 'info', "Welcome back!")
					},
					onError: (errors) => {
						if(errors.email)
						{
							this.runToast('top-right', 'warning', errors.email)
						}
					},
				});
			},
		},
		setup() {
			const schema = Yup.object().shape({
				fullName: Yup.string().required().label("The Full Name"),
				email: Yup.string().email().required().label("The Email"),
				password: Yup.string().min(5).required().label("The Password"),
			});

			return {
				schema,
			};
		},
	};
</script>