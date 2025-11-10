<template>
  <component
    :is="componentType"
    :to="to"
    :href="href"
    :class="[
      'inline-flex justify-center items-center align-middle px-3 py-1.5 rounded text-sm transition cursor-pointer',
      colorClass,
      hoverClass,
      customClasses
    ]"
    :type="componentType==='button' ? htmlType:undefined"
    :title="title"
    :target="href ? '_blank' : undefined"
  >
    <svg
      v-if="icon"
      xmlns="http://www.w3.org/2000/svg"
      class="h-5 w-5 mr-1"
      fill="none"
      viewBox="0 0 24 24"
      stroke="currentColor"
    >
      <path
        :d="icon"
        stroke-linecap="round"
        stroke-linejoin="round"
        stroke-width="2"
      />
    </svg>
    <span class="hidden md:inline"><slot>{{ label }}</slot></span>
  </component>
</template>

<script lang="ts">
export default {
  props: {
    label: String,
    icon: String,
    title: String,
    to: String,
    href: String,
    customClasses: {
      type: String,
      default: '',
    },
    type: {
      type: String,
      default: 'default',
    },
    htmlType:{
        type:String,
        default:'button',
    }
  },
  computed: {
    componentType(): string {
      if (this.to) return 'RouterLink';
      if (this.href) return 'a';
      return 'button';
    },
    colorClass(): string {
      switch (this.type) {
        case 'edit':
          return 'text-blue-600';
        case 'delete':
          return 'text-red-600';
        case 'update':
        case 'create':
          return 'text-green-600';
        case 'cancel':
          return 'btn--light';
        case 'generalDark':
            return 'btn--dark'
        default:
          return 'text-blue-600';
      }
    },
    hoverClass(): string {
      switch (this.type) {
        case 'edit':
          return 'hover:bg-blue-600 hover:text-white';
        case 'delete':
          return 'hover:bg-red-600 hover:text-white';
        case 'update':
        case 'create':
          return 'hover:bg-green-600 hover:text-white';
        case 'cancel':
          return 'hover:btn--light';
        case 'generalDark':
            return 'hover:btn--dark'
        default:
          return 'hover:underline';
      }
    },
  },
};
</script>