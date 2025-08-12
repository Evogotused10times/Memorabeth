<script setup>
import { ref } from "vue";
import { Link, useForm } from "@inertiajs/vue3";
import AppLayout from "../../Components/AppLayout.vue";

const applicationForm = useForm({
  applicant_name: "",
  applicant_email: "",
  applicant_phone: "",
  deceased_name: "",
  file: null,
});
const errors = ref({});

const validateForm = () => {
  errors.value = {};
  if (!applicationForm.applicant_name)
    errors.value.applicant_name = "Applicant name is required";
  if (!applicationForm.deceased_name)
    errors.value.deceased_name = "Deceased name is required";
  if (!applicationForm.file) errors.value.file = "File is required";
  if (!applicationForm.applicant_email && !applicationForm.applicant_phone)
    errors.value.contact =
      "At least one of email or phone is required for contact purposes";
  return Object.keys(errors.value).length === 0;
};

const submitApplication = () => {
  if (validateForm()) {
    applicationForm.post("/applications", {
      onSuccess: () => {
        applicationForm.reset();
      },
      onError: (err) => {
        errors.value = err;
      },
    });
  }
};
</script>

<template>
  <AppLayout>
    <div class="space-y-6">
      <h2 class="text-3xl font-display font-bold text-primary dark:text-white">
        Burial Service Application
      </h2>
      <Link
        href="/public"
        class="inline-block text-blue-500 dark:text-blue-300 hover:underline animate-fade-in"
        >Back to Public Portal</Link
      >
      <div
        class="bg-white/50 dark:bg-gray-800/50 backdrop-blur-xs p-6 rounded-xl shadow-neumorphic animate-fade-in"
      >
        <h3
          class="text-xl font-display font-semibold text-gray-800 dark:text-gray-200 mb-4"
        >
          Submit Your Application
        </h3>
        <p class="text-gray-600 dark:text-gray-300 mb-4">
          Please provide the required details and upload a document (PDF, JPG, or PNG, max
          2MB) to apply for burial services at Bethany Memorial Park. At least one contact
          method (email or phone) is required for follow-up.
        </p>
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
            placeholder="Your Phone"
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
          <p v-if="errors.contact" class="text-error text-sm mt-1">
            {{ errors.contact }}
          </p>
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
