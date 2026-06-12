<template>
  <transition
    enter-active-class="transition duration-300 ease-out"
    enter-from-class="opacity-0"
    enter-to-class="opacity-100"
    leave-active-class="transition duration-200 ease-in"
    leave-from-class="opacity-100"
    leave-to-class="opacity-0"
  >
    <div 
      v-if="show" 
      class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
      @click.self="$emit('close')"
    >
      <div class="relative max-w-4xl w-full bg-white rounded-2xl overflow-hidden shadow-2xl flex flex-col h-[80vh] border border-[#d1c5b5]/30">
        
        <div class="p-6 border-b border-[#d1c5b5]/20 flex items-center justify-between bg-[#FAF9F6]">
          <div>
            <h3 class="font-serif text-[20px] text-[#1a1c1a] font-bold">Pilih Media Gambar</h3>
            <p class="text-[12px] text-[#605e58] mt-0.5">Pilih gambar yang ada atau unggah gambar baru.</p>
          </div>
          <button 
            type="button" 
            @click="$emit('close')"
            class="text-[#605e58] hover:text-[#1a1c1a] transition-colors"
          >
            <span class="material-symbols-outlined text-[24px]">close</span>
          </button>
        </div>

        
        <div class="p-6 border-b border-[#d1c5b5]/15 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4 bg-white">
          
          <div class="relative flex-grow max-w-md">
            <input 
              type="text" 
              v-model="searchQuery"
              @input="fetchMedia"
              placeholder="Cari gambar berdasarkan nama berkas..."
              class="w-full bg-white border-b border-[#d1c5b5] focus:border-[#765a27] py-2 pl-9 pr-4 text-[12.5px] outline-none transition-colors duration-300 rounded-t shadow-sm"
            />
            <span class="material-symbols-outlined absolute left-2.5 top-1/2 -translate-y-1/2 text-[#605e58] text-[16px]">
              search
            </span>
          </div>

          
          <div class="flex items-center gap-2">
            <input 
              type="file" 
              ref="fileInput" 
              class="hidden" 
              accept="image/*"
              @change="handleUpload"
            />
            <button 
              type="button" 
              @click="triggerFileInput"
              :disabled="uploading"
              class="bg-[#765a27] text-white hover:bg-[#60491f] disabled:bg-gray-300 disabled:cursor-not-allowed px-4 py-2 rounded-lg text-[12px] font-semibold uppercase tracking-wider transition-all shadow flex items-center gap-1.5"
            >
              <span class="material-symbols-outlined text-[16px]">{{ uploading ? 'sync' : 'cloud_upload' }}</span>
              <span>{{ uploading ? 'Mengunggah...' : 'Unggah Baru' }}</span>
            </button>
          </div>
        </div>

        
        <div class="flex-grow overflow-y-auto p-6 bg-[#FAF9F6]/40 custom-scrollbar">
          <div v-if="loading" class="flex flex-col items-center justify-center py-20">
            <span class="material-symbols-outlined text-[#765a27] text-4xl animate-spin">sync</span>
            <p class="text-[13px] text-[#605e58] mt-2">Memuat pustaka media...</p>
          </div>

          <div v-else-if="mediaList.length > 0" class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-5 gap-4">
            <div 
              v-for="media in mediaList" 
              :key="media.id"
              @click="selectMedia(media)"
              class="bg-white border rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 group cursor-pointer relative flex flex-col justify-between"
              :class="selectedId === media.id ? 'border-[#765a27] ring-2 ring-[#765a27]/20 bg-[#FAF9F6]' : 'border-[#d1c5b5]/20 hover:border-[#765a27]/40'"
            >
              
              <div 
                v-if="selectedId === media.id"
                class="absolute top-2 right-2 z-10 w-6 h-6 rounded-full bg-[#765a27] text-white flex items-center justify-center shadow-md"
              >
                <span class="material-symbols-outlined text-[16px]">check</span>
              </div>

              
              <div class="aspect-square bg-[#FAF9F6] relative overflow-hidden flex items-center justify-center border-b border-[#d1c5b5]/10">
                <img 
                  :src="media.url" 
                  :alt="media.filename" 
                  class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                />
              </div>
              
              
              <div class="p-2.5 text-[11px] text-[#605e58] truncate">
                <p class="font-bold text-[#1a1c1a] truncate" :title="media.filename">
                  {{ media.filename }}
                </p>
                <p class="opacity-75 mt-0.5">
                  {{ formatSize(media.size) }}
                </p>
              </div>
            </div>
          </div>

          <div v-else class="text-center py-20 bg-white border border-[#d1c5b5]/15 rounded-xl shadow-sm">
            <span class="material-symbols-outlined text-[#d1c5b5] text-4xl mb-3">image</span>
            <p class="text-[#605e58] text-[13px] font-medium">Tidak ada gambar yang cocok.</p>
          </div>
        </div>

        
        <div class="p-6 border-t border-[#d1c5b5]/20 flex justify-end gap-3 bg-white">
          <button 
            type="button" 
            @click="$emit('close')"
            class="border border-[#d1c5b5] text-[#605e58] hover:bg-black/5 px-5 py-2.5 rounded-lg text-[12px] font-semibold uppercase tracking-wider transition-colors"
          >
            Batal
          </button>
          <button 
            type="button" 
            @click="confirmSelection"
            :disabled="!tempSelected"
            class="bg-[#765a27] text-white hover:bg-[#60491f] disabled:bg-gray-200 disabled:text-gray-400 disabled:cursor-not-allowed px-5 py-2.5 rounded-lg text-[12px] font-semibold uppercase tracking-wider transition-all shadow"
          >
            Pilih Gambar
          </button>
        </div>
      </div>
    </div>
  </transition>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';

const props = defineProps({
  show: Boolean,
  selectedId: [Number, String],
});

const emit = defineEmits(['close', 'select']);

const mediaList = ref([]);
const loading = ref(false);
const uploading = ref(false);
const searchQuery = ref('');
const fileInput = ref(null);
const tempSelected = ref(null);

let searchTimeout = null;


watch(() => props.show, (newVal) => {
  if (newVal) {
    fetchMedia();
    tempSelected.value = null;
    searchQuery.value = '';
  }
});

const fetchMedia = () => {
  loading.value = true;
  clearTimeout(searchTimeout);
  
  searchTimeout = setTimeout(async () => {
    try {
      const response = await fetch(`/admin/media?json=1&q=${encodeURIComponent(searchQuery.value)}`);
      if (response.ok) {
        const data = await response.json();
        mediaList.value = data;
        
        
        if (props.selectedId) {
          const matched = data.find(m => m.id === props.selectedId);
          if (matched) tempSelected.value = matched;
        }
      }
    } catch (err) {
      console.error('Error fetching media:', err);
    } finally {
      loading.value = false;
    }
  }, 300);
};

const triggerFileInput = () => {
  if (fileInput.value) fileInput.value.click();
};

const handleUpload = async (event) => {
  const file = event.target.files[0];
  if (!file) return;

  const formData = new FormData();
  formData.append('file', file);
  formData.append('json', '1');

  uploading.value = true;
  
  try {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    const response = await fetch('/admin/media', {
      method: 'POST',
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': csrfToken
      },
      body: formData
    });

    if (response.ok) {
      const newMedia = await response.json();
      mediaList.value.unshift(newMedia);
      selectMedia(newMedia);
    } else {
      const errData = await response.json();
      alert(errData.message || 'Gagal mengunggah berkas.');
    }
  } catch (err) {
    console.error('Upload error:', err);
    alert('Terjadi kesalahan saat mengunggah gambar.');
  } finally {
    uploading.value = false;
    if (fileInput.value) fileInput.value.value = '';
  }
};

const selectMedia = (media) => {
  tempSelected.value = media;
  emit('select', media); 
};

const confirmSelection = () => {
  if (tempSelected.value) {
    emit('select', tempSelected.value);
    emit('close');
  }
};

const formatSize = (bytes) => {
  if (!bytes) return '0 B';
  const k = 1024;
  const sizes = ['B', 'KB', 'MB', 'GB'];
  const i = Math.floor(Math.log(bytes) / Math.log(k));
  return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + ' ' + sizes[i];
};

onMounted(() => {
  if (props.show) {
    fetchMedia();
  }
});
</script>

<script>

export default {
  name: 'MediaSelector'
}
</script>

<style scoped>
.custom-scrollbar::-webkit-scrollbar {
  width: 5px;
  height: 5px;
}
.custom-scrollbar::-webkit-scrollbar-track {
  background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
  background-color: #d1c5b5;
  border-radius: 10px;
}
</style>
