<template>
  <div class="hold-transition login-page">
    <div class="login-box">
      <div class="card card-outline card-primary">
        <div class="card-header text-center">
          <a href="#" class="h1"><b>NPC</b>Bangladesh</a>
        </div>
        <div class="card-body">
          <p class="login-box-msg">Sign in to start your session</p>

          <form @submit.prevent="login">
            <div class="input-group mb-3">
              <input v-model="email" type="email" class="form-control" placeholder="Email" required />
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input v-model="password" type="password" class="form-control" placeholder="Password" required />
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-8">
                <div class="icheck-primary">
                  <input type="checkbox" id="remember" v-model="remember">
                  <label for="remember">
                    Remember Me
                  </label>
                </div>
              </div>
            </div>
            <div>
              <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'
import { useToast } from '@/composables/useToast'

// Toast helper for notifications
const toast = useToast()

// Form fields
const email = ref('')
const password = ref('')
const remember = ref(false) // "Remember me" checkbox state

// Router instance for navigation
const router = useRouter()

/**
 * Handle admin login process
 */
const login = async () => {
  try {
    // Fetch CSRF cookie required by Laravel Sanctum
    await axios.get('/sanctum/csrf-cookie')

    // Submit login credentials
    const { data } = await axios.post('/api/admin/login', {
      email: email.value,
      password: password.value,
      remember: remember.value // Optional: persist login if supported by backend
    })

    // Store authentication data
    localStorage.setItem('token', data.data.token)
    localStorage.setItem('role', 'admin')

    // Set default Authorization header for future requests
    axios.defaults.headers.common['Authorization'] = `Bearer ${data.data.token}`

    // Redirect to admin dashboard on success
    router.push({ name: 'Dashboard' })
  } catch (error) {
    console.error('Login failed:', error)
    // Display appropriate error messages via toast
    toast.validationError(error)
  }
}
</script>
