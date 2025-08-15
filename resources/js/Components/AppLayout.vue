<script setup>
import { Link, usePage, router } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

const { auth = { user: null } } = usePage().props; 
const isDarkMode = ref(localStorage.getItem('theme') === 'dark');
const showToast = ref(false);
const toastMessage = ref('');
const toastType = ref('success');

const toggleDarkMode = () => {
    isDarkMode.value = !isDarkMode.value;
    document.documentElement.classList.toggle('dark', isDarkMode.value);
    localStorage.setItem('theme', isDarkMode.value ? 'dark' : 'light');
};

const closeToast = () => {
    showToast.value = false;
};

onMounted(() => {
    console.log('Auth state:', usePage().props.auth); // Debug auth prop
    if (
        localStorage.getItem('theme') === 'dark' ||
        (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)
    ) {
        isDarkMode.value = true;
        document.documentElement.classList.add('dark');
    }
    if (usePage().props.flash?.success) {
        toastMessage.value = usePage().props.flash.success;
        toastType.value = 'success';
        showToast.value = true;
        setTimeout(() => (showToast.value = false), 4000);
    }
    if (usePage().props.flash?.error) {
        toastMessage.value = usePage().props.flash.error;
        toastType.value = 'error';
        showToast.value = true;
        setTimeout(() => (showToast.value = false), 4000);
    }

    router.on('error', (errors) => {
        toastMessage.value = 'An error occurred. Please try again.';
        toastType.value = 'error';
        showToast.value = true;
        setTimeout(() => (showToast.value = false), 4000);
    });
});
</script>

<template>
    <div class="min-h-screen bg-secondary-light dark:bg-secondary-dark font-sans flex flex-col">
        <nav class="bg-primary text-white p-4 shadow-neumorphic">
            <div class="container mx-auto flex justify-between items-center">
                <h1 class="text-2xl font-display font-bold">MemoraBeth</h1>
                <div class="flex items-center space-x-4">
                    <Link
                        v-if="auth.user"
                        href="/admin"
                        class="hover:text-accent transition-colors"
                        :aria-current="$page.url === '/admin' ? 'page' : undefined"
                    >
                        Admin Dashboard
                    </Link>
                    <Link
                        href="/public"
                        class="hover:text-accent transition-colors"
                        :aria-current="$page.url === '/public' ? 'page' : undefined"
                    >
                        Public Portal
                    </Link>
                    <Link
                        v-if="!auth.user"
                        href="/login"
                        class="hover:text-accent transition-colors"
                        :aria-current="$page.url === '/login' ? 'page' : undefined"
                    >
                        Log in
                    </Link>
                    <Link
                        v-if="auth.user"
                        href="/logout"
                        method="post"
                        as="button"
                        class="hover:text-accent transition-colors"
                    >
                        Logout
                    </Link>
                    <button
                        @click="toggleDarkMode"
                        class="p-2 rounded-full hover:bg-white/20 transition"
                        aria-label="Toggle dark mode"
                    >
                        <svg v-if="isDarkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </button>
                </div>
            </div>
        </nav>
        <main class="container mx-auto p-4 flex-grow bg-white/50 dark:bg-gray-800/50 backdrop-blur-xs">
            <div
                v-if="showToast"
                :class="{ 'bg-success': toastType === 'success', 'bg-error': toastType === 'error' }"
                class="fixed top-4 right-4 px-4 py-2 rounded-lg shadow-lg animate-fade-in flex items-center text-white"
                role="alert"
                aria-live="assertive"
            >
                {{ toastMessage }}
                <button @click="closeToast" class="ml-4 text-white hover:text-accent" aria-label="Close notification">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <slot />
        </main>
        <footer class="bg-primary text-white p-4">
            <div class="container mx-auto flex justify-center space-x-6">
                <a href="https://facebook.com/bethanymemorialpark" target="_blank" class="hover:text-accent transition-colors" aria-label="Visit MemoraBeth on Facebook">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.879v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.989C18.343 21.129 22 16.992 22 12z" />
                    </svg>
                </a>
                <a href="mailto:info@bethanymemorialpark.com" class="hover:text-accent transition-colors" aria-label="Email MemoraBeth">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </a>
                <a href="tel:+639123456789" class="hover:text-accent transition-colors" aria-label="Call MemoraBeth">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                </a>
            </div>
            <p class="text-center text-sm mt-4">In loving memory, MemoraBeth honors those who rest in peace.</p>
        </footer>
    </div>
</template>