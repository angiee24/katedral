<template>
  <AdminLayout title="Kelola Pustaka Media">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
      <p class="text-[13.5px] text-[#605e58]">Unggah dan kelola aset gambar paroki untuk sampul berita dan banner.</p>
      
      
      <div class="relative w-full md:w-80">
        <input 
          type="text" 
          v-model="searchQuery"
          @input="handleSearch"
          placeholder="Cari berkas gambar..."
          class="w-full bg-white border-b border-[#d1c5b5] focus:border-[#765a27] py-2.5 pl-11 pr-4 text-[13px] outline-none transition-colors duration-300 rounded-t-lg shadow-sm"
        />
        <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-[#605e58] text-[18px]">
          search
        </span>
      </div>
    </div>

    
    <div 
      class="bg-white border-2 border-dashed border-[#d1c5b5]/60 hover:border-[#765a27]/60 rounded-2xl p-8 mb-8 text-center flex flex-col items-center justify-center cursor-pointer transition-colors"
      @dragover.prevent="dragover = true"
      @dragleave.prevent="dragover = false"
      @drop.prevent="handleFileDrop"
      @click="triggerFileSelect"
      :class="{ 'bg-[#765a27]/5 border-[#765a27]': dragover }"
    >
      <input 
        type="file" 
        ref="fileInput" 
        class="hidden" 
        accept="image/*"
        @change="handleFileSelect"
      />
      <span class="material-symbols-outlined text-[#765a27] text-4xl mb-3">cloud_upload</span>
      <h3 class="font-serif text-[16px] text-[#1a1c1a] font-bold">
        {{ uploadForm.processing ? 'Sedang mengunggah...' : 'Seret dan lepas gambar di sini, atau klik untuk memilih' }}
      </h3>
      <p class="text-[11px] text-[#605e58] mt-1.5 uppercase tracking-wider">Format: JPEG, PNG, JPG, WEBP • Maksimal 2MB</p>
      
      
      <div v-if="uploadForm.processing" class="w-full max-w-xs bg-[#f4f3f1] h-1.5 rounded-full overflow-hidden mt-4">
        <div class="bg-[#765a27] h-full animate-pulse w-full"></div>
      </div>
    </div>

    
    <div v-if="mediaFiles.data.length > 0">
      <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6 mb-12">
        <div 
          v-for="media in mediaFiles.data" 
          :key="media.id"
          class="bg-white border border-[#d1c5b5]/20 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 group relative flex flex-col justify-between"
        >
          
          <div class="aspect-square bg-[#FAF9F6] relative overflow-hidden flex items-center justify-center border-b border-[#d1c5b5]/10">
            <img 
              :src="media.url" 
              :alt="media.filename" 
              class="w-full h-full object-cover"
            />
            
            
            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
              <button 
                @click="copyUrl(media.url)"
                class="bg-white hover:bg-[#FAF9F6] text-[#765a27] rounded-full p-2.5 transition-colors shadow"
                title="Salin Tautan"
              >
                <span class="material-symbols-outlined text-[18px] block">link</span>
              </button>
              <button 
                @click="confirmDelete(media)"
                class="bg-[#ba1a1a] hover:bg-[#93000a] text-white rounded-full p-2.5 transition-colors shadow"
                title="Hapus Gambar"
              >
                <span class="material-symbols-outlined text-[18px] block">delete</span>
              </button>
            </div>
          </div>
          
          
          <div class="p-3 text-[11px] text-[#605e58] flex flex-col gap-0.5 truncate">
            <p class="font-bold text-[#1a1c1a] truncate" :title="media.filename">
              {{ media.filename }}
            </p>
            <p class="opacity-75">
              {{ formatSize(media.size) }}
            </p>
          </div>
        </div>
      </div>

      
      <div class="flex justify-center items-center gap-2" v-if="mediaFiles.links && mediaFiles.links.length > 3">
        <template v-for="(link, i) in mediaFiles.links" :key="i">
          <span 
            v-if="link.url === null" 
            class="px-4 py-2 text-[13px] text-[#605e58] opacity-50 cursor-not-allowed select-none"
            v-html="link.label"
          ></span>
          <Link 
            v-else
            :href="link.url"
            class="px-4 py-2 rounded-lg text-[13px] font-semibold transition-all duration-300 border"
            :class="link.active 
              ? 'bg-[#765a27] text-white border-[#765a27] shadow-sm' 
              : 'bg-white text-[#605e58] border-[#d1c5b5]/40 hover:border-[#765a27] hover:text-[#765a27]'"
            v-html="link.label"
          ></Link>
        </template>
      </div>
    </div>

    
    <div v-else class="text-center py-20 bg-white border border-[#d1c5b5]/20 rounded-2xl shadow-sm">
      <span class="material-symbols-outlined text-[#d1c5b5] text-5xl mb-4">image</span>
      <p class="text-[#605e58] font-medium">Belum ada berkas media yang diunggah.</p>
    </div>

    
    <transition
      enter-active-class="transition duration-300 ease-out"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition duration-200 ease-in"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div 
        v-if="showDeleteModal" 
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
        @click.self="showDeleteModal = false"
      >
        <div class="relative max-w-md w-full bg-white rounded-2xl overflow-hidden shadow-2xl p-8 text-center flex flex-col items-center">
          <div class="w-16 h-16 rounded-full bg-red-50 text-[#ba1a1a] flex items-center justify-center mb-6">
            <span class="material-symbols-outlined text-[36px]">warning</span>
          </div>
          <h3 class="font-serif text-[22px] text-[#1a1c1a] font-bold mb-2">Hapus Gambar?</h3>
          <p class="text-[#605e58] text-[13.5px] leading-relaxed mb-8">
            Apakah Anda yakin ingin menghapus gambar <strong>{{ activeMedia?.filename }}</strong>? Tindakan ini akan menghapusnya secara permanen dari server penyimpanan.
          </p>
          
          <div class="flex gap-4 w-full justify-center">
            <button 
              type="button" 
              @click="showDeleteModal = false"
              class="border border-[#d1c5b5] text-[#605e58] hover:bg-black/5 px-6 py-3 rounded-lg text-[13px] font-semibold uppercase tracking-wider transition-colors w-1/2"
            >
              Batal
            </button>
            <button 
              type="button" 
              @click="deleteMedia"
              class="bg-[#ba1a1a] text-white hover:bg-[#93000a] px-6 py-3 rounded-lg text-[13px] font-semibold uppercase tracking-wider transition-colors w-1/2 shadow-sm"
            >
              Hapus
            </button>
          </div>
        </div>
      </div>
    </transition>
  </AdminLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Link, useForm, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
  mediaFiles: Object,
  filters: Object,
});

const searchQuery = ref(props.filters.q || '');
const dragover = ref(false);
const fileInput = ref(null);
const showDeleteModal = ref(false);
const activeMedia = ref(null);

let searchTimeout = null;

const handleSearch = () => {
  clearTimeout(searchTimeout);
  searchTimeout = setTimeout(() => {
    router.get('/admin/media', {
      q: searchQuery.value,
    }, {
      preserveState: true,
      replace: true,
    });
  }, 400);
};

const triggerFileSelect = () => {
  fileInput.value.click();
};

const uploadForm = useForm({
  file: null,
});

const handleFileSelect = (event) => {
  const file = event.target.files[0];
  if (file) {
    uploadFile(file);
  }
};

const handleFileDrop = (event) => {
  dragover.value = false;
  const file = event.dataTransfer.files[0];
  if (file && file.type.startsWith('image/')) {
    uploadFile(file);
  }
};

const uploadFile = (file) => {
  uploadForm.file = file;
  uploadForm.post('/admin/media', {
    onSuccess: () => {
      uploadForm.reset();
      
      if (fileInput.value) fileInput.value.value = '';
    },
    onError: (errors) => {
      
    }
  });
};

const copyUrl = (url) => {
  const absoluteUrl = window.location.origin + url;
  navigator.clipboard.writeText(absoluteUrl)
    .then(() => {
      
      
      
      alert('Tautan gambar disalin ke clipboard!');
    })
    .catch((err) => {
      console.error('Gagal menyalin tautan: ', err);
    });
};

const confirmDelete = (media) => {
  activeMedia.value = media;
  showDeleteModal.value = true;
};

const deleteForm = useForm({});

const deleteMedia = () => {
  if (!activeMedia.value) return;

  deleteForm.delete(`/admin/media/${activeMedia.value.id}`, {
    onSuccess: () => {
      showDeleteModal.value = false;
      activeMedia.value = null;
    },
    onError: () => {
      showDeleteModal.value = false;
    }
  });
};

const formatSize = (bytes) => {
  if (bytes === 0) return '0 B';
  const k = 1024;
  const sizes = ['B', 'KB', 'MB', 'GB'];
  const i = Math.floor(Math.log(bytes) / Math.log(k));
  return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + ' ' + sizes[i];
};
</script>
