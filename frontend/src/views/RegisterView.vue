<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import AuthLayout from '../layouts/AuthLayout.vue';
import AuthForm from '../components/auth/AuthForm.vue';
import BrandLogo from '../components/common/BrandLogo.vue';
import { useAuthStore } from '../store/auth';

const router = useRouter();
const authStore = useAuthStore();
const submitting = ref(false);
const errors = ref({});

async function register(payload) {
  submitting.value = true;
  errors.value = {};

  try {
    await authStore.register(payload);
    await router.push({ name: 'dashboard' });
  } catch (error) {
    if (error.validationErrors) {
      errors.value = error.validationErrors;
    }
  } finally {
    submitting.value = false;
  }
}
</script>

<template>
  <AuthLayout>
    <div class="auth-heading">
      <BrandLogo />
      <p>Start posting, saving, and finding your people.</p>
    </div>
    <AuthForm mode="register" :submitting="submitting" :errors="errors" @submit="register" />
    <p class="auth-footnote">
      Already have an account?
      <RouterLink to="/login">Login</RouterLink>
    </p>
  </AuthLayout>
</template>

<style scoped>
.auth-heading {
  display: grid;
  gap: 10px;
  justify-items: center;
  margin-bottom: 24px;
  text-align: center;
}

.auth-heading p,
.auth-footnote {
  color: var(--on-surface-muted);
}

.auth-footnote {
  text-align: center;
}

.auth-footnote a {
  color: var(--primary);
  font-weight: 800;
}
</style>
