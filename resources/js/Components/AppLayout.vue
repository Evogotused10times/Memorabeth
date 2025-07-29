<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";

const { auth, flash } = usePage().props;
const isDarkMode = ref(localStorage.getItem("theme") === "dark");
const showToast = ref(false);
const toastMessage = ref("");

const toggleDarkMode = () => {
  isDarkMode.value = !isDarkMode.value;
  document.documentElement.classList.toggle("dark", isDarkMode.value);
  localStorage.setItem("theme", isDarkMode.value ? "dark" : "light");
};

onMounted(() => {
  if (
    localStorage.getItem("theme") === "dark" ||
    (!localStorage.getItem("theme") &&
      window.matchMedia("(prefers-color-scheme: dark)").matches)
  ) {
    isDarkMode.value = true;
    document.documentElement.classList.add("dark");
  }
  if (flash.success) {
    toastMessage.value = flash.success;
    showToast.value = true;
    setTimeout(() => (showToast.value = false), 3000);
  }
});
</script>

<template>
  <div class="min-h-screen bg-secondary-light dark:bg-secondary-dark font-sans">
    <nav class="bg-primary text-white p-4 shadow-lg">
      <div class="container mx-auto flex justify-between items-center">
        <h1 class="text-2xl font-display font-bold">MemoraBeth</h1>
        <div class="flex items-center space-x-4">
          <Link v-if="auth.user" href="/admin" class="hover:text-accent transition-colors"
            >Admin</Link
          >
          <Link href="/public" class="hover:text-accent transition-colors"
            >Public Portal</Link
          >
          <Link
            v-if="!auth.user"
            href="/login"
            class="hover:text-accent transition-colors"
            >Login</Link
          >
          <Link
            v-if="auth.user"
            href="/logout"
            method="post"
            as="button"
            class="hover:text-accent transition-colors"
            >Logout</Link
          >
          <button
            @click="toggleDarkMode"
            class="p-2 rounded-full hover:bg-white/20 transition"
          >
            <svg
              v-if="isDarkMode"
              class="w-5 h-5"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"
              />
            </svg>
            <svg
              v-else
              class="w-5 h-5"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"
              />
            </svg>
          </button>
        </div>
      </div>
    </nav>
    <main class="container mx-auto p-4">
      <div
        v-if="showToast"
        class="fixed top-4 right-4 bg-success text-white px-4 py-2 rounded-lg shadow-lg animate-fade-in"
      >
        {{ toastMessage }}
      </div>
      <slot />
    </main>
  </div>
</template>
