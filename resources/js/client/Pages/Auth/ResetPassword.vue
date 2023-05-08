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
                            <div class="card-header bg-transparent px-lg-5 pt-lg-5 border-0">
                                <h3 class="mb-0">Reset your password</h3>
                                <p class="mb-0 text-muted small">Please enter your new password twice so we can verify you typed it in correctly.</p>
                            </div>
							<div class="card-body  px-lg-5 pb-lg-5">
                                <form @submit.prevent="submit">
									<base-input
										alternative
										name="email"
										v-model="form.email"
										addon-left-icon="ni ni-email-83"
										placeholder="Email"
                                        disabled
                              			:error="form.errors.password"
									>
									</base-input>
									<base-input
										alternative
										name="password"
										type="password"
										v-model="form.password"
										addon-left-icon="ni ni-lock-circle-open"
										placeholder="Password"
                              			:error="form.errors.password"
									>
									</base-input>
									<base-input
										alternative
										type="password"
										name="password_confirmation"
										v-model="form.password_confirmation"
										addon-left-icon="ni ni-lock-circle-open"
										placeholder="Password Confirmation"
                              			:error="form.errors.password_confirmation"
									>
									</base-input>
                                    <base-button :disabled="form.processing" native-type="submit" block type="primary">
                                        <i v-if="form.processing"  class="fas fa-spinner fa-spin"></i>
                                        SET NEW PASSWORD
                                    </base-button>
                                </form>
							</div>
						</div>
						<div class="row mt-3">
							<div class="col-6">
								<inertia-link :href="route('login')" class="text-light"
									><small>Sign in your account</small></inertia-link
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
	import AuthLayout from "@/Layouts/AuthLayout";
    import BaseAlert from '@/Argon/components/BaseAlert.vue'
    export default {
        components: {
			AuthLayout,
            BaseAlert
        },
        props: {
            email: String,
            token: String,
        },

        data() {
            return {
                form: this.$inertia.form({
                    token: this.token,
                    email: this.email,
                    password: '',
                    password_confirmation: '',
                })
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('password.update'), {
                    onFinish: () => this.form.reset('password', 'password_confirmation'),
                })
            }
        }
    }
</script>
