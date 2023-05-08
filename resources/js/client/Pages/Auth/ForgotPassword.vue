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
                                <h3>Forgot your password?</h3>
                                <p class="mb-0 text-muted small">No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.</p>
                            </div>
							<div class="card-body  px-lg-5 pb-lg-5">
                                <base-alert v-if="form.wasSuccessful" type="success" >
                                    <strong>Success</strong> We have emailed your password reset link!
                                </base-alert>
                                <form @submit.prevent="submit">
									<base-input
										alternative
										name="email"
										v-model="form.email"
										addon-left-icon="ni ni-email-83"
										placeholder="Email"
                              			:error="form.errors.email"
									>
									</base-input>
                                    <base-button :disabled="form.processing" native-type="submit" block type="primary">
                                        <i v-if="form.processing"  class="fas fa-spinner fa-spin"></i>
                                        Email Password Reset Link
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
            status: String
        },

        data() {
            return {
                form: this.$inertia.form({
                    email: ''
                })
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('password.email'))
            }
        }
    }
</script>
