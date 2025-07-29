<script setup>
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";
import AppLayout from "../../Components/AppLayout.vue";

const props = defineProps(["record"]);
const candleLit = ref(false);
</script>

<template>
  <AppLayout>
    <div class="space-y-6">
      <h2 class="text-3xl font-display font-bold text-primary dark:text-white">
        {{ record.name }}'s Memorial
      </h2>
      <Link
        href="/public"
        class="inline-block text-blue-500 dark:text-blue-300 hover:underline animate-fade-in"
        >Back to Public Portal</Link
      >
      <div
        class="bg-white/50 dark:bg-gray-800/50 backdrop-blur-xs p-6 rounded-xl shadow-neumorphic animate-fade-in"
      >
        <p class="text-gray-800 dark:text-gray-200">Plot: {{ record.plot_id }}</p>
        <p class="text-gray-800 dark:text-gray-200">
          Dates: {{ record.dates || "Unknown" }}
        </p>
        <button
          @click="candleLit = !candleLit"
          class="mt-4 flex items-center px-6 py-3 bg-primary text-white rounded-lg shadow-neumorphic hover:bg-accent transition-all duration-300 animate-scale-up"
        >
          <span :class="['candle mr-2', candleLit ? 'opacity-100' : 'opacity-50']"
            >🕯️</span
          >
          <span>{{ candleLit ? "Candle Lit" : "Light a Candle" }}</span>
        </button>
      </div>
    </div>
  </AppLayout>
</template>
