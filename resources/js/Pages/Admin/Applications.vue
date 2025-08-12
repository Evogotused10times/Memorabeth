<script setup>
import { ref } from "vue";
import { Link, usePage } from "@inertiajs/vue3";
import AppLayout from "../../Components/AppLayout.vue";

const props = defineProps(["applications"]);
const updateStatus = (id, status) => {
  $inertia.patch(`/applications/${id}/status`, { status });
};
</script>

<template>
  <AppLayout>
    <div class="space-y-6">
      <h2 class="text-3xl font-display font-bold text-primary dark:text-white">
        Manage Applications
      </h2>
      <Link
        href="/admin"
        class="inline-block text-blue-500 dark:text-blue-300 hover:underline animate-fade-in"
        >Back to Dashboard</Link
      >
      <div
        class="bg-white/50 dark:bg-gray-800/50 backdrop-blur-xs p-6 rounded-xl shadow-neumorphic animate-fade-in"
      >
        <h3
          class="text-xl font-display font-semibold text-gray-800 dark:text-gray-200 mb-4"
        >
          Burial Service Applications
        </h3>
        <ul class="space-y-4">
          <li
            v-for="application in applications"
            :key="application.id"
            class="p-4 bg-white/30 dark:bg-gray-700/30 backdrop-blur-xs rounded-lg"
          >
            <p>
              <strong>Applicant:</strong> {{ application.applicant_name }} (Email:
              {{ application.applicant_email }}, Phone: {{ application.applicant_phone }})
            </p>
            <p><strong>Deceased:</strong> {{ application.deceased_name }}</p>
            <p><strong>Status:</strong> {{ application.status }}</p>
            <p>
              <strong>File:</strong>
              <a
                :href="`/storage/${application.file_path}`"
                target="_blank"
                class="text-blue-500 dark:text-blue-300 hover:underline"
                >View Document</a
              >
            </p>
            <div class="mt-2 space-x-2">
              <button
                @click="updateStatus(application.id, 'approved')"
                class="px-4 py-2 bg-success text-white rounded-lg hover:bg-green-600 transition-all duration-300"
                :disabled="application.status !== 'pending'"
              >
                Approve
              </button>
              <button
                @click="updateStatus(application.id, 'denied')"
                class="px-4 py-2 bg-error text-white rounded-lg hover:bg-red-600 transition-all duration-300"
                :disabled="application.status !== 'pending'"
              >
                Deny
              </button>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </AppLayout>
</template>
