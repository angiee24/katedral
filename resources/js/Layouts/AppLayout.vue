<template>
  <div class="min-h-screen flex flex-col bg-surface text-on-surface font-body-md antialiased">
    
    <nav class="fixed top-0 w-full z-50 glass-nav bg-surface/80 backdrop-blur-md shadow-sm transition-all duration-300 ease-in-out border-none">
      <div class="flex justify-between items-center px-margin-mobile md:px-margin-desktop py-4 max-w-container-max mx-auto w-full">
        
        <Link href="/" class="flex items-center gap-3 hover:opacity-90 transition-opacity">
          <img v-if="settings.church_logo" :src="settings.church_logo" alt="Logo Katedral" class="h-10 w-auto">
          <span class="font-display-lg text-headline-md text-primary tracking-tight">
            {{ settings.church_name || 'Katedral Samarinda' }}
          </span>
        </Link>
        
        
        <div class="hidden md:flex items-center gap-8 font-body-md text-body-md">
          <Link 
            v-for="link in navLinks" 
            :key="link.path"
            :href="link.path"
            class="transition-colors duration-300 relative py-1"
            :class="isRouteActive(link.path) 
              ? 'text-primary after:content-[\'\'] after:absolute after:-bottom-1 after:left-1/2 after:-translate-x-1/2 after:w-1 after:h-1 after:bg-primary after:rounded-full' 
              : 'text-on-surface-variant hover:text-primary'"
          >
            {{ link.label }}
          </Link>
        </div>



        
        <button 
          @click="mobileMenuOpen = !mobileMenuOpen"
          aria-label="Menu" 
          class="md:hidden text-on-surface p-2 hover:bg-surface-variant/50 rounded-full transition-colors"
        >
          <span class="material-symbols-outlined block">
            {{ mobileMenuOpen ? 'close' : 'menu' }}
          </span>
        </button>
      </div>

      
      <transition
        enter-active-class="transition duration-200 ease-out"
        enter-from-class="opacity-0 -translate-y-4"
        enter-to-class="opacity-100 translate-y-0"
        leave-active-class="transition duration-150 ease-in"
        leave-from-class="opacity-100 translate-y-0"
        leave-to-class="opacity-0 -translate-y-4"
      >
        <div 
          v-if="mobileMenuOpen" 
          class="md:hidden bg-surface border-t border-outline-variant/10 px-margin-mobile py-4 flex flex-col gap-4 shadow-lg"
        >
          <Link 
            v-for="link in navLinks" 
            :key="link.path"
            :href="link.path" 
            @click="mobileMenuOpen = false"
            class="py-2 font-body-md text-body-md transition-colors"
            :class="isRouteActive(link.path) ? 'text-primary font-semibold' : 'text-on-surface-variant hover:text-primary'"
          >
            {{ link.label }}
          </Link>
        </div>
      </transition>
    </nav>

    
    <main :class="['flex-grow', page.component === 'Public/Home' ? 'pt-0' : 'pt-[72px]']">
      <slot />
    </main>
  
    
    <footer class="w-full bg-surface-container-low border-t border-outline-variant/10 mt-auto">
      <div class="flex flex-col md:flex-row justify-between items-center px-margin-mobile md:px-margin-desktop py-stack-md gap-4 max-w-container-max mx-auto w-full">
        <div class="font-display-lg text-headline-md text-primary">
          {{ settings.church_name || 'Katedral Samarinda' }}
        </div>
        <div class="font-caption text-caption text-on-surface-variant text-center md:text-left">
          © {{ new Date().getFullYear() }} Paroki Gereja Katedral Samarinda. Silent Elegance.
        </div>
        <div class="flex gap-6 font-caption text-caption opacity-90 hover:opacity-100 transition-all duration-300">
          <a class="text-on-secondary-fixed-variant hover:text-primary transition-colors" href="#">Kebijakan Privasi</a>
          <a class="text-on-secondary-fixed-variant hover:text-primary transition-colors" href="#">Ketentuan Layanan</a>
          <a class="text-on-secondary-fixed-variant hover:text-primary transition-colors" href="#">Peta Situs</a>
        </div>
      </div>
    </footer>

    
    <div class="fixed bottom-5 right-5 z-50 flex flex-col gap-3 max-w-sm w-full">
      <transition-group
        enter-active-class="transform transition duration-300 ease-out"
        enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
        enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
        leave-active-class="transition duration-200 ease-in"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
      >
        <div 
          v-for="toast in toasts" 
          :key="toast.id"
          class="flex items-center gap-3 px-6 py-4 rounded-xl shadow-lg border text-[14px] w-full bg-white"
          :class="toast.type === 'success' ? 'border-primary/30 text-primary' : 'border-error/30 text-on-error-container bg-error-container'"
        >
          <span class="material-symbols-outlined flex-shrink-0">
            {{ toast.type === 'success' ? 'check_circle' : 'error' }}
          </span>
          <span>{{ toast.message }}</span>
          <button 
            @click="removeToast(toast.id)" 
            class="ml-auto text-current opacity-70 hover:opacity-100 transition-opacity p-1"
          >
            <span class="material-symbols-outlined text-[18px] block">close</span>
          </button>
        </div>
      </transition-group>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

const page = usePage();
const mobileMenuOpen = ref(false);

const settings = computed(() => page.props.settings || {});
const flash = computed(() => page.props.flash || {});

const navLinks = [
  { label: 'Beranda', path: '/' },
  { label: 'Warta', path: '/warta' },
  { label: 'Liturgi', path: '/liturgi' },
  { label: 'Sejarah', path: '/sejarah' },
  { label: 'Kontak', path: '/kontak' },
];

const isRouteActive = (path) => {
  const currentPath = page.url.split('?')[0];
  if (path === '/') {
    return currentPath === '/';
  }
  return currentPath.startsWith(path);
};


const toasts = ref([]);

const addToast = (message, type = 'success') => {
  const id = Date.now();
  toasts.value.push({ id, message, type });
  setTimeout(() => {
    removeToast(id);
  }, 4000);
};

const removeToast = (id) => {
  toasts.value = toasts.value.filter(t => t.id !== id);
};


watch(() => flash.value.success, (newVal) => {
  if (newVal) {
    addToast(newVal, 'success');
  }
}, { immediate: true });

watch(() => flash.value.error, (newVal) => {
  if (newVal) {
    addToast(newVal, 'error');
  }
}, { immediate: true });
</script>
