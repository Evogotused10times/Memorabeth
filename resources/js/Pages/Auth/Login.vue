<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import AppLayout from '@/Components/AppLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { route } from '@inertiajs/inertia'; // Ensure this import works
import { ref, watch } from 'vue';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    // Debug: Check if route is available
    if (typeof route !== 'function') {
        console.error('Route helper is not a function. Using fallback URL: /login');
        form.post('/login', {
            onSuccess: () => {
                window.location.href = '/admin';
            },
            onFinish: () => form.reset('password'),
            onError: (errors) => {
                console.log('Login error:', errors);
            },
        });
    } else {
        form.post(route('login'), {
            onSuccess: () => {
                window.location.href = route('admin.dashboard');
            },
            onFinish: () => form.reset('password'),
            onError: (errors) => {
                console.log('Login error:', errors);
            },
        });
    }
};

// Watch for status prop changes to show toast
watch(
    () => usePage().props.status,
    (newStatus) => {
        if (newStatus) {
            toastMessage.value = newStatus;
            showToast.value = true;
            setTimeout(() => (showToast.value = false), 3000);
        }
    }
);

const showToast = ref(false);
const toastMessage = ref('');
</script>

<template>
    <AppLayout>
        <Head title="Log in to MemoraBeth" />

        <div v-if="showToast" class="mb-4 bg-success text-white px-4 py-2 rounded-lg shadow-lg animate-fade-in">
            {{ toastMessage }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="email" value="Email" class="text-gray-800 dark:text-gray-200" />
                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-accent"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                    autocapitalize="none"
                    aria-label="Email address"
                    aria-describedby="email-error"
                />
                <InputError id="email-error" class="mt-2 text-error" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" class="text-gray-800 dark:text-gray-200" />
                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-accent"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                    aria-label="Password"
                    aria-describedby="password-error"
                />
                <InputError id="password-error" class="mt-2 text-error" :message="form.errors.password" />
            </div>

            <div class="mt-4 block">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Remember me</span>
                </label>
            </div>

            <div class="mt-4 flex items-center justify-end">
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="text-sm text-gray-600 dark:text-gray-400 underline hover:text-accent dark:hover:text-accent focus:outline-none focus:ring-2 focus:ring-accent"
                >
                    Forgot your password?
                </Link>

                <PrimaryButton
                    class="ml-4 px-6 py-3 bg-primary text-white rounded-lg shadow-neumorphic hover:bg-accent transition-all duration-300"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Log In
                </PrimaryButton>
            </div>
        </form>
    </AppLayout>
</template>