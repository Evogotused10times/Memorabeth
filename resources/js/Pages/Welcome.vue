/** * File: resources/js/Pages/Welcome.vue */
<script setup>
import AppLayout from "../Components/AppLayout.vue";
import { Link } from "@inertiajs/vue3";
</script>

<template>
  <AppLayout>
    <div class="text-center space-y-6 animate-fade-in">
      <h2 class="text-3xl font-display font-bold text-primary dark:text-white">
        Welcome to MemoraBeth
      </h2>
      <p class="text-lg text-gray-600 dark:text-gray-300">
        A Cemetery Management System for Bethany Memorial Park
      </p>
      <div class="mt-6">
        <Link
          href="/public"
          class="inline-block px-6 py-3 bg-primary text-white rounded-lg shadow-neumorphic hover:bg-accent transition-all duration-300 animate-scale-up"
          >Go to Public Portal</Link
        >
      </div>
    </div>
  </AppLayout>
</template>
