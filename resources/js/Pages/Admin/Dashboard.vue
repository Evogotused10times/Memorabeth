<script setup>
import { ref, onMounted } from "vue";
import { Link, usePage } from "@inertiajs/vue3";
import L from "leaflet";
import AppLayout from "../../Components/AppLayout.vue";

const props = defineProps(["records"]);
const newRecord = ref({ name: "", plot_id: "", dates: "", latitude: "", longitude: "" });
const errors = ref({});
let map;

const validateForm = () => {
  errors.value = {};
  if (!newRecord.value.name) errors.value.name = "Name is required";
  if (!newRecord.value.plot_id) errors.value.plot_id = "Plot ID is required";
  return Object.keys(errors.value).length === 0;
};

const addRecord = () => {
  if (validateForm()) {
    $inertia.post("/records", newRecord.value, {
      onSuccess: () => {
        newRecord.value = {
          name: "",
          plot_id: "",
          dates: "",
          latitude: "",
          longitude: "",
        };
      },
      onError: (err) => {
        errors.value = err;
      },
    });
  }
};

const deleteRecord = (id, name) => {
  if (confirm(`Are you sure you want to delete ${name}'s record?`)) {
    $inertia.delete(`/records/${id}`);
  }
};

onMounted(() => {
  map = L.map("map").setView([9.9519, 123.9654], 15);
  L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    attribution: "© OpenStreetMap contributors",
  }).addTo(map);

  props.records.forEach((record) => {
    if (record.latitude && record.longitude) {
      L.marker([record.latitude, record.longitude])
        .addTo(map)
        .bindPopup(`${record.name} - Plot ${record.plot_id}`);
    }
  });
});
</script>

<template>
  <AppLayout>
    <div class="space-y-6">
      <h2 class="text-3xl font-display font-bold text-primary dark:text-white">
        Admin Dashboard
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
          Manage Burial Records
        </h3>
        <div class="space-y-4">
          <div>
            <input
              v-model="newRecord.name"
              placeholder="Deceased Name"
              class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-accent"
            />
            <p v-if="errors.name" class="text-error text-sm mt-1">{{ errors.name }}</p>
          </div>
          <div>
            <input
              v-model="newRecord.plot_id"
              placeholder="Plot ID"
              class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-accent"
            />
            <p v-if="errors.plot_id" class="text-error text-sm mt-1">
              {{ errors.plot_id }}
            </p>
          </div>
          <input
            v-model="newRecord.dates"
            placeholder="Dates (e.g., 1950-2020)"
            class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-accent"
          />
          <input
            v-model="newRecord.latitude"
            placeholder="Latitude"
            class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-accent"
          />
          <input
            v-model="newRecord.longitude"
            placeholder="Longitude"
            class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-accent"
          />
          <button
            @click="addRecord"
            class="w-full px-6 py-3 bg-primary text-white rounded-lg shadow-neumorphic hover:bg-accent transition-all duration-300 animate-scale-up"
          >
            Add Record
          </button>
          <ul class="mt-4 space-y-2">
            <li
              v-for="record in records"
              :key="record.id"
              class="p-3 bg-white/30 dark:bg-gray-700/30 backdrop-blur-xs rounded-lg flex justify-between items-center"
            >
              <span>{{ record.name }} - Plot {{ record.plot_id }}</span>
              <button
                @click="deleteRecord(record.id, record.name)"
                class="px-4 py-2 bg-error text-white rounded-lg hover:bg-red-600 transition-all duration-300"
              >
                Delete
              </button>
            </li>
          </ul>
        </div>
      </div>
      <div
        class="bg-white/50 dark:bg-gray-800/50 backdrop-blur-xs p-6 rounded-xl shadow-neumorphic animate-fade-in"
      >
        <h3
          class="text-xl font-display font-semibold text-gray-800 dark:text-gray-200 mb-4"
        >
          Cemetery Map
        </h3>
        <div id="map" class="rounded-lg h-96"></div>
      </div>
    </div>
  </AppLayout>
</template>
