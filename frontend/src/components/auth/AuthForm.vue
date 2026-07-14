<script setup>
import { reactive, ref } from 'vue';
import FormField from '../common/FormField.vue';
import IconButton from '../common/IconButton.vue';

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
    <FormField
      v-if="props.mode === 'register'"
      id="name"
      v-model="form.name"
      label="Display name"
      icon="badge"
      required
      autocomplete="name"
      placeholder="Your name"
    />

    <FormField
      id="email"
      v-model="form.email"
      label="Email address"
      icon="mail"
      type="email"
      required
      autocomplete="email"
      placeholder="you@example.com"
    />

    <FormField
      id="password"
      v-model="form.password"
      label="Password"
      icon="lock"
      :type="showPassword ? 'text' : 'password'"
      required
      autocomplete="current-password"
      placeholder="Enter your password"
      minlength="8"
    >
      <template #trailing>
        <IconButton
          :icon="showPassword ? 'visibility_off' : 'visibility'"
          :label="showPassword ? 'Hide password' : 'Show password'"
          class="auth-form__visibility"
          @click="showPassword = !showPassword"
        />
      </template>
    </FormField>

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
  gap: var(--space-6);
  padding: var(--space-6);
}

.auth-form__visibility {
  background: transparent;
  border: 0;
  height: 32px;
  margin-right: calc(var(--space-2) * -1);
  width: 32px;
}

.auth-form__row {
  align-items: center;
  display: flex;
  font-size: var(--text-sm);
  font-weight: var(--weight-bold);
  justify-content: space-between;
}

.auth-form__remember {
  align-items: center;
  color: var(--on-surface-muted);
  display: flex;
  gap: var(--space-2);
}

.auth-form__row a {
  color: var(--primary);
}

.auth-form__submit {
  border: 0;
  width: 100%;
}
</style>
