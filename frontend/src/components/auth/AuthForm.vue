<script setup>
import { reactive, ref } from 'vue';

const props = defineProps({
  mode: {
    type: String,
    required: true,
    validator: (value) => ['login', 'register'].includes(value)
  },
  submitting: {
    type: Boolean,
    default: false
  }
});

const emit = defineEmits(['submit']);
const showPassword = ref(false);
const form = reactive({
  name: '',
  email: '',
  password: ''
});

function submit() {
  emit('submit', { ...form });
}
</script>

<template>
  <form class="auth-form glass" @submit.prevent="submit">
    <div v-if="props.mode === 'register'" class="field">
      <label for="name">Display name</label>
      <div class="input-wrap">
        <span class="material-symbols-outlined">badge</span>
        <input id="name" v-model.trim="form.name" type="text" required autocomplete="name" placeholder="Your name" />
      </div>
    </div>

    <div class="field">
      <label for="email">Email address</label>
      <div class="input-wrap">
        <span class="material-symbols-outlined">mail</span>
        <input id="email" v-model.trim="form.email" type="email" required autocomplete="email" placeholder="you@example.com" />
      </div>
    </div>

    <div class="field">
      <label for="password">Password</label>
      <div class="input-wrap">
        <span class="material-symbols-outlined">lock</span>
        <input
          id="password"
          v-model="form.password"
          :type="showPassword ? 'text' : 'password'"
          required
          autocomplete="current-password"
          placeholder="Enter your password"
          minlength="8"
        />
        <button class="auth-form__icon" type="button" :aria-label="showPassword ? 'Hide password' : 'Show password'" @click="showPassword = !showPassword">
          <span class="material-symbols-outlined">{{ showPassword ? 'visibility_off' : 'visibility' }}</span>
        </button>
      </div>
    </div>

    <div v-if="props.mode === 'login'" class="auth-form__row">
      <label class="auth-form__remember">
        <input type="checkbox" />
        <span>Remember me</span>
      </label>
      <a href="#">Forgot password?</a>
    </div>

    <button class="app-button primary auth-form__submit" type="submit" :disabled="props.submitting">
      {{ props.mode === 'login' ? 'Login to VIBE' : 'Create account' }}
    </button>
  </form>
</template>

<style scoped>
.auth-form {
  border-radius: var(--radius-xl);
  display: grid;
  gap: 22px;
  padding: 24px;
}

.auth-form__icon {
  align-items: center;
  background: transparent;
  border: 0;
  color: var(--on-surface-muted);
  cursor: pointer;
  display: inline-flex;
  padding: 0;
}

.auth-form__row {
  align-items: center;
  display: flex;
  font-size: 14px;
  font-weight: 700;
  justify-content: space-between;
}

.auth-form__remember {
  align-items: center;
  color: var(--on-surface-muted);
  display: flex;
  gap: 8px;
}

.auth-form__row a {
  color: var(--primary);
}

.auth-form__submit {
  border: 0;
  width: 100%;
}
</style>
