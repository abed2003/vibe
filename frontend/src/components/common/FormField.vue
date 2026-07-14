<script setup>
defineProps({
  id: {
    type: String,
    required: true
  },
  label: {
    type: String,
    required: true
  },
  icon: {
    type: String,
    default: ''
  },
  modelValue: {
    type: String,
    default: ''
  },
  type: {
    type: String,
    default: 'text'
  },
  placeholder: {
    type: String,
    default: ''
  },
  required: {
    type: Boolean,
    default: false
  },
  autocomplete: {
    type: String,
    default: 'off'
  },
  minlength: {
    type: [String, Number],
    default: undefined
  },
  maxlength: {
    type: [String, Number],
    default: undefined
  }
});

defineEmits(['update:modelValue']);
</script>

<template>
  <div class="field">
    <label :for="id">{{ label }}</label>
    <div class="input-wrap">
      <span v-if="icon" class="material-symbols-outlined">{{ icon }}</span>
      <input
        :id="id"
        :type="type"
        :value="modelValue"
        :placeholder="placeholder"
        :required="required"
        :autocomplete="autocomplete"
        :minlength="minlength"
        :maxlength="maxlength"
        @input="$emit('update:modelValue', $event.target.value)"
      />
      <slot name="trailing" />
    </div>
  </div>
</template>
