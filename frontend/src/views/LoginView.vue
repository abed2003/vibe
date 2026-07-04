<script setup>
import { ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import AuthLayout from '../layouts/AuthLayout.vue';
import AuthForm from '../components/auth/AuthForm.vue';
import BrandLogo from '../components/common/BrandLogo.vue';
import { useAuthStore } from '../store/auth';

const route = useRoute();
const router = useRouter();
const authStore = useAuthStore();
const submitting = ref(false);

async function login(payload) {
  submitting.value = true;
  try {
    await authStore.login(payload);
    await router.push(route.query.redirect || { name: 'dashboard' });
  } finally {
    submitting.value = false;
  }
}
</script>

<template>
  <AuthLayout>
    <div class="auth-heading">
      <BrandLogo />
      <p>Welcome back to the vibe.</p>
    </div>
    <AuthForm mode="login" :submitting="submitting" @submit="login" />
    <p class="auth-footnote">
      Do not have an account?
      <RouterLink to="/register">Sign up</RouterLink>
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
