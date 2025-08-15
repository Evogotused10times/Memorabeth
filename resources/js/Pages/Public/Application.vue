<script setup>
import { ref } from "vue";
import { Link, useForm } from "@inertiajs/vue3";
import AppLayout from "../../Components/AppLayout.vue";

const applicationForm = useForm({
  applicant_name: "",
  address: "",
  cellphone_no: "",
  email: "",
  facebook_messenger: "",
  next_of_kin: "",
  lots: [{ niche_lot: "", block_level: "", desc: "", price: "" }],
  terms: "",
  remarks: "",
  purchaser_name: "",
  agent_name: "",
  date: new Date().toISOString().slice(0, 10),
  signature_agreement: false,
  file: null,
});
const errors = ref({});

const addLot = () => {
  applicationForm.lots.push({ niche_lot: "", block_level: "", desc: "", price: "" });
};

const removeLot = (index) => {
  applicationForm.lots.splice(index, 1);
};

const validateForm = () => {
  errors.value = {};
  if (!applicationForm.applicant_name)
    errors.value.applicant_name = "Applicant name is required";
  if (!applicationForm.address) errors.value.address = "Address is required";
  if (!applicationForm.cellphone_no && !applicationForm.email)
    errors.value.contact = "At least one of cellphone number or email is required for contact purposes";
  if (!applicationForm.next_of_kin) errors.value.next_of_kin = "Next of kin is required";
  if (applicationForm.lots.length === 0 || applicationForm.lots.some(lot => !lot.niche_lot))
    errors.value.lots = "At least one memorial lot with niche/lot # is required";
  if (!applicationForm.terms) errors.value.terms = "Terms are required";
  if (!applicationForm.remarks) errors.value.remarks = "Remarks are required";
  if (!applicationForm.purchaser_name) errors.value.purchaser_name = "Purchaser name is required";
  if (!applicationForm.agent_name) errors.value.agent_name = "Agent name is required";
  if (!applicationForm.date) errors.value.date = "Date is required";
  if (!applicationForm.signature_agreement) errors.value.signature_agreement = "You must agree to the signature terms";
  if (!applicationForm.file) errors.value.file = "File is required";
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
          method (cellphone number or email) is required for follow-up.
        </p>
        <div class="space-y-4">
          <div>
            <label class="block text-gray-600 dark:text-gray-300 mb-1">Name</label>
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
            <label class="block text-gray-600 dark:text-gray-300 mb-1">Address</label>
            <input
              v-model="applicationForm.address"
              placeholder="Your Address"
              class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-accent"
            />
            <p v-if="errors.address" class="text-error text-sm mt-1">
              {{ errors.address }}
            </p>
          </div>
          <div>
            <label class="block text-gray-600 dark:text-gray-300 mb-1">Cellphone No.</label>
            <input
              v-model="applicationForm.cellphone_no"
              placeholder="Your Cellphone No."
              class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-accent"
            />
          </div>
          <div>
            <label class="block text-gray-600 dark:text-gray-300 mb-1">E-Mail</label>
            <input
              v-model="applicationForm.email"
              placeholder="Your E-Mail"
              class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-accent"
            />
            <p v-if="errors.email" class="text-error text-sm mt-1">
              {{ errors.email }}
            </p>
          </div>
          <div>
            <label class="block text-gray-600 dark:text-gray-300 mb-1">Facebook Messenger</label>
            <input
              v-model="applicationForm.facebook_messenger"
              placeholder="Your Facebook Messenger"
              class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-accent"
            />
          </div>
          <div>
            <label class="block text-gray-600 dark:text-gray-300 mb-1">Next of Kin</label>
            <input
              v-model="applicationForm.next_of_kin"
              placeholder="Next of Kin"
              class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-accent"
            />
            <p v-if="errors.next_of_kin" class="text-error text-sm mt-1">
              {{ errors.next_of_kin }}
            </p>
          </div>
          <div class="space-y-4">
            <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Memorial Lot(s) Applied For</h4>
            <div v-for="(lot, index) in applicationForm.lots" :key="index" class="grid grid-cols-4 gap-4">
              <input
                v-model="lot.niche_lot"
                placeholder="Niche/Lot #"
                class="p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-accent"
              />
              <input
                v-model="lot.block_level"
                placeholder="Block/Level #"
                class="p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-accent"
              />
              <input
                v-model="lot.desc"
                placeholder="Desc"
                class="p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-accent"
              />
              <input
                v-model="lot.price"
                placeholder="Price"
                class="p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-accent"
              />
              <button v-if="index > 0" @click="removeLot(index)" class="text-error">Remove</button>
            </div>
            <button @click="addLot" class="text-blue-500 hover:underline">Add Another Lot</button>
            <p v-if="errors.lots" class="text-error text-sm mt-1">
              {{ errors.lots }}
            </p>
          </div>
          <div>
            <label class="block text-gray-600 dark:text-gray-300 mb-1">Terms</label>
            <textarea
              v-model="applicationForm.terms"
              placeholder="Terms"
              class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-accent"
            />
            <p v-if="errors.terms" class="text-error text-sm mt-1">
              {{ errors.terms }}
            </p>
          </div>
          <div>
            <label class="block text-gray-600 dark:text-gray-300 mb-1">Remarks</label>
            <textarea
              v-model="applicationForm.remarks"
              placeholder="Remarks"
              class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-accent"
            />
            <p v-if="errors.remarks" class="text-error text-sm mt-1">
              {{ errors.remarks }}
            </p>
          </div>
          <div>
            <label class="block text-gray-600 dark:text-gray-300 mb-1">Printed Name and Signature of Purchaser</label>
            <input
              v-model="applicationForm.purchaser_name"
              placeholder="Purchaser Name"
              class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-accent"
            />
            <p v-if="errors.purchaser_name" class="text-error text-sm mt-1">
              {{ errors.purchaser_name }}
            </p>
            <label class="flex items-center mt-2">
              <input
                type="checkbox"
                v-model="applicationForm.signature_agreement"
                class="form-checkbox"
              />
              <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">I agree to the terms and provide my digital signature</span>
            </label>
            <p v-if="errors.signature_agreement" class="text-error text-sm mt-1">
              {{ errors.signature_agreement }}
            </p>
          </div>
          <div>
            <label class="block text-gray-600 dark:text-gray-300 mb-1">Name of Agent</label>
            <input
              v-model="applicationForm.agent_name"
              placeholder="Agent Name"
              class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-accent"
            />
            <p v-if="errors.agent_name" class="text-error text-sm mt-1">
              {{ errors.agent_name }}
            </p>
          </div>
          <div>
            <label class="block text-gray-600 dark:text-gray-300 mb-1">Date</label>
            <input
              v-model="applicationForm.date"
              type="date"
              class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-accent"
            />
            <p v-if="errors.date" class="text-error text-sm mt-1">
              {{ errors.date }}
            </p>
          </div>
          <div>
            <label class="block text-gray-600 dark:text-gray-300 mb-1">Upload Document</label>
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