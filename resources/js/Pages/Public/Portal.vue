<script setup>
import { ref } from "vue";
import { Link, useForm } from "@inertiajs/vue3";
import AppLayout from "../../Components/AppLayout.vue";

const props = defineProps(["records", "searchQuery"]);
const searchQuery = ref(props.searchQuery || "");
const applicationForm = useForm({
  applicant_name: "",
  applicant_email: "",
  applicant_phone: "",
  deceased_name: "",
  file: null,
});
const errors = ref({});

const submitApplication = () => {
  applicationForm.post("/applications", {
    onSuccess: () => {
      applicationForm.reset();
    },
    onError: (err) => {
      errors.value = err;
    },
  });
};
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
      <div
        class="bg-white/50 dark:bg-gray-800/50 backdrop-blur-xs p-6 rounded-xl shadow-neumorphic animate-fade-in"
      >
        <h3
          class="text-xl font-display font-semibold text-gray-800 dark:text-gray-200 mb-4"
        >
          Apply for Burial Services
        </h3>
        <div class="space-y-4">
          <div>
            <input
              v-model="applicationForm.applicant_name"
              placeholder="Your Name"
              class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-accent"
            />
            <p v-if="errors.applicant_name" class="text-error text-sm mt-1">
              {{ errors.applicant_name }}
            </p>
          </div>
          <div>
            <input
              v-model="applicationForm.applicant_email"
              placeholder="Your Email"
              class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-accent"
            />
            <p v-if="errors.applicant_email" class="text-error text-sm mt-1">
              {{ errors.applicant_email }}
            </p>
          </div>
          <input
            v-model="applicationForm.applicant_phone"
            placeholder="Your Phone (optional)"
            class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-accent"
          />
          <div>
            <input
              v-model="applicationForm.deceased_name"
              placeholder="Deceased Name"
              class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-accent"
            />
            <p v-if="errors.deceased_name" class="text-error text-sm mt-1">
              {{ errors.deceased_name }}
            </p>
          </div>
          <div>
            <input
              type="file"
              @change="applicationForm.file = $event.target.files[0]"
              accept=".pdf,.jpg,.png"
              class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-accent"
            />
            <p v-if="errors.file" class="text-error text-sm mt-1">{{ errors.file }}</p>
          </div>
          <button
            @click="submitApplication"
            class="w-full px-6 py-3 bg-primary text-white rounded-lg shadow-neumorphic hover:bg-accent transition-all duration-300 animate-scale-up"
          >
            Submit Application
          </button>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
