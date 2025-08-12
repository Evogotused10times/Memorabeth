<script setup>
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";
import AppLayout from "../../Components/AppLayout.vue";

const props = defineProps(["records", "searchQuery"]);
const searchQuery = ref(props.searchQuery || "");
</script>

<template>
  <AppLayout>
    <div class="space-y-6">
      <h2 class="text-3xl font-display font-bold text-primary dark:text-white">
        Public Portal
      </h2>
      <Link
        href="/"
        class="inline-block text-blue-500 dark:text-blue-300 hover:underline animate-fade-in"
        >Back to Welcome</Link
      >
      <div
        class="bg-white/50 dark:bg-gray-800/50 backdrop-blur-xs p-6 rounded-xl shadow-neumorphic animate-fade-in"
      >
        <h3
          class="text-xl font-display font-semibold text-gray-800 dark:text-gray-200 mb-4"
        >
          Search Graves
        </h3>
        <input
          v-model="searchQuery"
          @input="
            $inertia.get('/public/search', { q: searchQuery }, { preserveState: true })
          "
          placeholder="Search by name"
          class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-accent"
        />
        <ul class="mt-4 space-y-2">
          <li
            v-for="record in records"
            :key="record.id"
            class="p-3 bg-white/30 dark:bg-gray-700/30 backdrop-blur-xs rounded-lg flex justify-between items-center"
          >
            <span>{{ record.name }} - Plot {{ record.plot_id }}</span>
            <Link
              :href="`/public/memorial/${record.id}`"
              class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-accent transition-all duration-300"
              >View Memorial</Link
            >
          </li>
        </ul>
      </div>
      <div class="text-center">
        <Link
          href="/public/application"
          class="inline-block px-6 py-3 bg-primary text-white rounded-lg shadow-neumorphic hover:bg-accent transition-all duration-300 animate-scale-up"
          >Apply for Burial Services</Link
        >
      </div>
    </div>
  </AppLayout>
</template>
