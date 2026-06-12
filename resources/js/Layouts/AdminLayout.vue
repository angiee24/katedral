<template>
  <div class="h-screen overflow-hidden flex bg-[#FAF9F6] text-[#1a1c1a] font-sans antialiased">
    
    <aside 
      class="w-64 bg-white border-r border-[#d1c5b5]/30 flex flex-col z-20 flex-shrink-0 transition-transform duration-300 md:translate-x-0 fixed md:relative h-full"
      :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    >
      
      <div class="h-20 flex items-center justify-between px-8 border-b border-[#d1c5b5]/10 flex-shrink-0">
        <div class="flex items-center">
          <span class="font-serif text-[24px] text-[#765a27] font-bold">Katedral</span>
          <span class="font-serif text-[24px] text-[#605e58] ml-2 opacity-60 font-bold">Portal</span>
        </div>
        <button class="md:hidden text-[#605e58]" @click="sidebarOpen = false">
          <span class="material-symbols-outlined block">close</span>
        </button>
      </div>
      
      
      <nav class="flex-grow py-8 px-4 flex flex-col gap-2 overflow-y-auto custom-scrollbar">
        
        <Link 
          href="/admin" 
          class="flex items-center gap-4 px-4 py-3 rounded-lg transition-colors duration-300 text-[14px] font-semibold"
          :class="isRouteActive('/admin', true) ? 'bg-[#f4f3f1] text-[#765a27]' : 'text-[#605e58] hover:bg-[#f4f3f1]/50 hover:text-[#765a27]'"
        >
          <span class="material-symbols-outlined text-[20px]" :style="{ fontVariationSettings: `'FILL' ${isRouteActive('/admin', true) ? 1 : 0}` }">dashboard</span>
          <span>Dashboard</span>
        </Link>

        
        <Link 
          v-if="hasPermission('manage-posts') || hasRole('author')"
          href="/admin/berita" 
          class="flex items-center gap-4 px-4 py-3 rounded-lg transition-colors duration-300 text-[14px] font-semibold"
          :class="isRouteActive('/admin/berita') ? 'bg-[#f4f3f1] text-[#765a27]' : 'text-[#605e58] hover:bg-[#f4f3f1]/50 hover:text-[#765a27]'"
        >
          <span class="material-symbols-outlined text-[20px]" :style="{ fontVariationSettings: `'FILL' ${isRouteActive('/admin/berita') ? 1 : 0}` }">article</span>
          <span>Kelola Berita</span>
        </Link>

        
        <Link 
          v-if="hasPermission('manage-liturgies')"
          href="/admin/liturgi" 
          class="flex items-center gap-4 px-4 py-3 rounded-lg transition-colors duration-300 text-[14px] font-semibold"
          :class="isRouteActive('/admin/liturgi') ? 'bg-[#f4f3f1] text-[#765a27]' : 'text-[#605e58] hover:bg-[#f4f3f1]/50 hover:text-[#765a27]'"
        >
          <span class="material-symbols-outlined text-[20px]" :style="{ fontVariationSettings: `'FILL' ${isRouteActive('/admin/liturgi') ? 1 : 0}` }">event</span>
          <span>Kelola Liturgi</span>
        </Link>

        
        <Link 
          v-if="hasPermission('manage-categories')"
          href="/admin/kategori" 
          class="flex items-center gap-4 px-4 py-3 rounded-lg transition-colors duration-300 text-[14px] font-semibold"
          :class="isRouteActive('/admin/kategori') ? 'bg-[#f4f3f1] text-[#765a27]' : 'text-[#605e58] hover:bg-[#f4f3f1]/50 hover:text-[#765a27]'"
        >
          <span class="material-symbols-outlined text-[20px]" :style="{ fontVariationSettings: `'FILL' ${isRouteActive('/admin/kategori') ? 1 : 0}` }">category</span>
          <span>Kelola Kategori</span>
        </Link>

        
        <Link 
          v-if="hasPermission('manage-media')"
          href="/admin/media" 
          class="flex items-center gap-4 px-4 py-3 rounded-lg transition-colors duration-300 text-[14px] font-semibold"
          :class="isRouteActive('/admin/media') ? 'bg-[#f4f3f1] text-[#765a27]' : 'text-[#605e58] hover:bg-[#f4f3f1]/50 hover:text-[#765a27]'"
        >
          <span class="material-symbols-outlined text-[20px]" :style="{ fontVariationSettings: `'FILL' ${isRouteActive('/admin/media') ? 1 : 0}` }">photo_library</span>
          <span>Kelola Media</span>
        </Link>

        
        <Link 
          v-if="hasPermission('manage-users')"
          href="/admin/users" 
          class="flex items-center gap-4 px-4 py-3 rounded-lg transition-colors duration-300 text-[14px] font-semibold"
          :class="isRouteActive('/admin/users') ? 'bg-[#f4f3f1] text-[#765a27]' : 'text-[#605e58] hover:bg-[#f4f3f1]/50 hover:text-[#765a27]'"
        >
          <span class="material-symbols-outlined text-[20px]" :style="{ fontVariationSettings: `'FILL' ${isRouteActive('/admin/users') ? 1 : 0}` }">group</span>
          <span>Kelola User</span>
        </Link>

        
        <Link 
          v-if="hasPermission('manage-settings')"
          href="/admin/settings" 
          class="flex items-center gap-4 px-4 py-3 rounded-lg transition-colors duration-300 text-[14px] font-semibold"
          :class="isRouteActive('/admin/settings') ? 'bg-[#f4f3f1] text-[#765a27]' : 'text-[#605e58] hover:bg-[#f4f3f1]/50 hover:text-[#765a27]'"
        >
          <span class="material-symbols-outlined text-[20px]" :style="{ fontVariationSettings: `'FILL' ${isRouteActive('/admin/settings') ? 1 : 0}` }">settings</span>
          <span>Pengaturan</span>
        </Link>
      </nav>
      
      
      <div class="p-4 border-t border-[#d1c5b5]/10 flex-shrink-0">
        <button 
          @click="logout"
          class="flex items-center gap-4 px-4 py-3 w-full rounded-lg text-[#605e58] hover:bg-[#ffdad6] hover:text-[#ba1a1a] transition-colors text-left text-[14px] font-semibold"
        >
          <span class="material-symbols-outlined text-[20px] block">logout</span>
          <span>Keluar</span>
        </button>
      </div>
    </aside>

    
    <div 
      v-if="sidebarOpen" 
      class="fixed inset-0 bg-black/40 z-10 md:hidden" 
      @click="sidebarOpen = false"
    ></div>

    
    <div class="flex-1 flex flex-col min-w-0 bg-[#FAF9F6] relative overflow-hidden h-full">
      
      <header class="h-20 flex items-center justify-between px-6 md:px-10 bg-white/60 backdrop-blur-md z-10 sticky top-0 border-b border-[#d1c5b5]/10 flex-shrink-0">
        <div class="flex items-center gap-4">
          <button 
            class="md:hidden text-[#605e58] p-2 rounded-full hover:bg-black/5 transition-colors" 
            @click="sidebarOpen = true"
          >
            <span class="material-symbols-outlined block">menu</span>
          </button>
          <div>
            <h1 class="font-serif text-[20px] md:text-[24px] text-[#1a1c1a] font-bold leading-tight">
              {{ title }}
            </h1>
            <p class="text-[11px] text-[#605e58] mt-0.5 font-medium">
              {{ formattedDate }}
            </p>
          </div>
        </div>

        <div class="flex items-center gap-6">
          <button class="text-[#605e58] hover:text-[#765a27] transition-colors">
            <span class="material-symbols-outlined block">notifications</span>
          </button>
          <div class="w-px h-6 bg-[#d1c5b5]/30"></div>
          
          
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-[#765a27]/10 text-[#765a27] flex items-center justify-center font-bold text-[14px] border border-[#d1c5b5]/20">
              {{ getInitials(user.name) }}
            </div>
            <div class="hidden md:block text-right">
              <p class="text-[13px] font-semibold text-[#1a1c1a]">{{ user.name }}</p>
              <p class="text-[11px] text-[#605e58] capitalize font-medium">{{ user.roles?.[0] }}</p>
            </div>
          </div>
        </div>
      </header>

      
      <div class="flex-grow overflow-y-auto custom-scrollbar p-6 md:p-10">
        <slot />
      </div>
    </div>

    
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
          class="flex items-center gap-3 px-6 py-4 rounded-xl shadow-lg border text-[14px] w-full bg-white animate-fade-in"
          :class="toast.type === 'success' ? 'border-[#765a27]/30 text-[#765a27]' : 'border-[#ba1a1a]/30 text-[#93000a]'"
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
import { Link, usePage, router } from '@inertiajs/vue3';

defineProps({
  title: {
    type: String,
    default: 'CMS Overview'
  }
});

const page = usePage();
const sidebarOpen = ref(false);

const user = computed(() => page.props.auth?.user || {});
const flash = computed(() => page.props.flash || {});

const formattedDate = computed(() => {
  return new Date().toLocaleDateString('id-ID', {
    weekday: 'long',
    day: 'numeric',
    month: 'long',
    year: 'numeric'
  });
});

const isRouteActive = (path, exact = false) => {
  if (exact) {
    return page.url === path;
  }
  return page.url.startsWith(path);
};

const hasRole = (roleName) => user.value.roles?.includes(roleName);
const hasPermission = (permName) => {
  if (hasRole('admin')) return true;
  return user.value.permissions?.includes(permName);
};

const getInitials = (name) => {
  if (!name) return 'A';
  return name.trim().split(' ').map(n => n[0]).slice(0, 2).join('');
};

const logout = () => {
  router.post('/logout');
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

<style scoped>
.custom-scrollbar::-webkit-scrollbar {
  width: 5px;
}
.custom-scrollbar::-webkit-scrollbar-track {
  background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
  background-color: #d1c5b5;
  border-radius: 10px;
}
</style>
