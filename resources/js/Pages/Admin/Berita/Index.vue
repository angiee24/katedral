<template>
  <AdminLayout title="Kelola Warta Gereja">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
      <div>
        <p class="text-[13.5px] text-[#605e58]">Tulis, sunting, dan jadwalkan warta mingguan, pengumuman, atau artikel rohani paroki.</p>
      </div>
      <div>
        <Link 
          href="/admin/berita/create"
          class="bg-[#765a27] text-white hover:bg-[#60491f] px-5 py-3 rounded-lg text-[12px] font-semibold uppercase tracking-wider transition-all shadow flex items-center gap-1.5"
        >
          <span class="material-symbols-outlined text-[16px]">add</span>
          <span>Tulis Warta Baru</span>
        </Link>
      </div>
    </div>

    
    <div class="bg-white rounded-xl p-6 border border-[#d1c5b5]/30 shadow-sm mb-8 flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4">
      
      <div class="relative w-full md:max-w-xs">
        <input 
          type="text" 
          v-model="filters.q"
          @input="handleFilterChange"
          placeholder="Cari judul atau kutipan warta..."
          class="w-full bg-white border-b border-[#d1c5b5] focus:border-[#765a27] py-2 pl-9 pr-4 text-[12.5px] outline-none transition-colors duration-300 rounded-t shadow-sm"
        />
        <span class="material-symbols-outlined absolute left-2.5 top-1/2 -translate-y-1/2 text-[#605e58] text-[16px]">
          search
        </span>
      </div>

      
      <div class="flex flex-wrap gap-4 items-center">
        
        <select 
          v-model="filters.category"
          @change="handleFilterChange"
          class="bg-white border-b border-[#d1c5b5] focus:border-[#765a27] py-2 px-3 text-[12.5px] outline-none transition-colors duration-300 rounded shadow-sm"
        >
          <option value="">Semua Kategori</option>
          <option 
            v-for="cat in categories" 
            :key="cat.id" 
            :value="cat.id"
          >
            {{ cat.name }}
          </option>
        </select>

        
        <select 
          v-model="filters.status"
          @change="handleFilterChange"
          class="bg-white border-b border-[#d1c5b5] focus:border-[#765a27] py-2 px-3 text-[12.5px] outline-none transition-colors duration-300 rounded shadow-sm"
        >
          <option value="">Semua Status</option>
          <option value="published">Diterbitkan</option>
          <option value="draft">Draf</option>
          <option value="scheduled">Dijadwalkan</option>
        </select>

        
        <button 
          v-if="hasActiveFilters"
          type="button"
          @click="resetFilters"
          class="text-[#765a27] hover:text-[#ba1a1a] text-[12px] font-semibold transition-colors flex items-center gap-1"
        >
          <span class="material-symbols-outlined text-[14px]">refresh</span>
          <span>Atur Ulang</span>
        </button>
      </div>
    </div>

    
    <div class="bg-white rounded-xl border border-[#d1c5b5]/30 shadow-sm overflow-hidden mb-8">
      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-[13px]">
          <thead>
            <tr class="bg-[#FAF9F6] border-b border-[#d1c5b5]/20 text-[#605e58]">
              <th class="py-4 px-6 font-semibold uppercase tracking-wider text-[11px] w-16">Info</th>
              <th class="py-4 px-6 font-semibold uppercase tracking-wider text-[11px]">Judul Artikel</th>
              <th class="py-4 px-6 font-semibold uppercase tracking-wider text-[11px]">Kategori</th>
              <th class="py-4 px-6 font-semibold uppercase tracking-wider text-[11px]">Penulis</th>
              <th class="py-4 px-6 font-semibold uppercase tracking-wider text-[11px]">Status</th>
              <th class="py-4 px-6 font-semibold uppercase tracking-wider text-[11px]">Tanggal Terbit</th>
              <th class="py-4 px-6 font-semibold uppercase tracking-wider text-[11px] text-right">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-[#d1c5b5]/10">
            <tr 
              v-for="post in posts.data" 
              :key="post.id"
              class="hover:bg-[#FAF9F6]/40 transition-colors"
            >
              
              <td class="py-4 px-6">
                <div class="w-12 h-12 rounded-lg bg-[#f4f3f1] border border-[#d1c5b5]/20 overflow-hidden flex items-center justify-center flex-shrink-0">
                  <img 
                    :src="post.media ? post.media.url : 'https://images.unsplash.com/photo-1548625361-155de0c7b57a?q=80&w=150'" 
                    :alt="post.title"
                    class="w-full h-full object-cover"
                  />
                </div>
              </td>
              
              
              <td class="py-4 px-6 max-w-xs md:max-w-sm">
                <div class="flex items-center gap-2 mb-1">
                  <span 
                    v-if="post.is_featured" 
                    class="bg-[#765a27]/10 text-[#765a27] border border-[#765a27]/20 rounded px-1.5 py-0.5 text-[9px] font-bold uppercase tracking-wider"
                  >
                    Unggulan
                  </span>
                </div>
                <a 
                  :href="`/warta/${post.slug}`"
                  target="_blank"
                  class="font-bold text-[#1a1c1a] hover:text-[#765a27] transition-colors leading-tight line-clamp-2"
                >
                  {{ post.title }}
                </a>
              </td>

              
              <td class="py-4 px-6 font-medium text-[#605e58]">
                {{ post.category?.name }}
              </td>

              
              <td class="py-4 px-6 text-[#605e58]">
                {{ post.author?.name || 'Sistem' }}
              </td>

              
              <td class="py-4 px-6">
                <span 
                  class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border"
                  :class="getStatusClasses(post.status)"
                >
                  {{ formatStatus(post.status) }}
                </span>
              </td>

              
              <td class="py-4 px-6 text-[#605e58]">
                {{ post.published_at ? formatDate(post.published_at) : 'Draf (Belum Terbit)' }}
              </td>

              
              <td class="py-4 px-6 text-right space-x-1.5 whitespace-nowrap">
                <Link 
                  :href="`/admin/berita/${post.id}/edit`"
                  class="inline-flex items-center justify-center w-8 h-8 rounded-full border border-[#d1c5b5] hover:border-[#765a27] text-[#605e58] hover:text-[#765a27] transition-all bg-white shadow-sm"
                  title="Sunting Artikel"
                >
                  <span class="material-symbols-outlined text-[16px]">edit</span>
                </Link>
                <button 
                  @click="confirmDelete(post)"
                  class="inline-flex items-center justify-center w-8 h-8 rounded-full border border-red-200 hover:border-red-500 text-red-500 hover:bg-red-50 transition-all bg-white shadow-sm"
                  title="Hapus Artikel"
                >
                  <span class="material-symbols-outlined text-[16px]">delete</span>
                </button>
              </td>
            </tr>
            
            <tr v-if="posts.data.length === 0">
              <td colspan="7" class="py-12 px-6 text-center text-[#605e58]">
                <span class="material-symbols-outlined text-[#d1c5b5] text-5xl mb-3 block">description</span>
                Belum ada warta gereja yang tersedia.
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      
      <div class="bg-[#FAF9F6] border-t border-[#d1c5b5]/20 py-4 px-6 flex justify-center items-center" v-if="posts.links && posts.links.length > 3">
        <div class="flex gap-2">
          <template v-for="(link, i) in posts.links" :key="i">
            <span 
              v-if="link.url === null" 
              class="px-3 py-1.5 text-[12.5px] text-[#605e58] opacity-50 cursor-not-allowed select-none"
              v-html="link.label"
            ></span>
            <Link 
              v-else
              :href="link.url"
              class="px-3 py-1.5 rounded-lg text-[12.5px] font-semibold transition-all duration-300 border"
              :class="link.active 
                ? 'bg-[#765a27] text-white border-[#765a27] shadow-sm' 
                : 'bg-white text-[#605e58] border-[#d1c5b5]/40 hover:border-[#765a27] hover:text-[#765a27]'"
              v-html="link.label"
            ></Link>
          </template>
        </div>
      </div>
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
          <h3 class="font-serif text-[22px] text-[#1a1c1a] font-bold mb-2">Hapus Artikel?</h3>
          <p class="text-[#605e58] text-[13.5px] leading-relaxed mb-8">
            Apakah Anda yakin ingin menghapus warta <strong>{{ activePost?.title }}</strong>? Tindakan ini akan menghapusnya secara permanen.
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
              @click="deletePost"
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
import { ref, reactive, computed } from 'vue';
import { Link, router, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
  posts: Object,
  categories: Array,
  filters: Object,
});

const filters = reactive({
  q: props.filters?.q || '',
  category: props.filters?.category || '',
  status: props.filters?.status || '',
});

const showDeleteModal = ref(false);
const activePost = ref(null);

let filterTimeout = null;

const handleFilterChange = () => {
  clearTimeout(filterTimeout);
  filterTimeout = setTimeout(() => {
    router.get('/admin/berita', {
      q: filters.q,
      category: filters.category,
      status: filters.status,
    }, {
      preserveState: true,
      replace: true,
    });
  }, 400);
};

const resetFilters = () => {
  filters.q = '';
  filters.category = '';
  filters.status = '';
  handleFilterChange();
};

const hasActiveFilters = computed(() => {
  return filters.q !== '' || filters.category !== '' || filters.status !== '';
});

const getStatusClasses = (status) => {
  if (status === 'published') return 'bg-green-50 text-green-700 border-green-200';
  if (status === 'draft') return 'bg-gray-50 text-gray-600 border-gray-200';
  return 'bg-amber-50 text-amber-700 border-amber-200'; 
};

const formatStatus = (status) => {
  if (status === 'published') return 'Terbit';
  if (status === 'draft') return 'Draf';
  return 'Jadwal';
};

const formatDate = (dateStr) => {
  if (!dateStr) return '';
  const date = new Date(dateStr);
  return date.toLocaleDateString('id-ID', {
    day: 'numeric',
    month: 'short',
    year: 'numeric'
  });
};

const confirmDelete = (post) => {
  activePost.value = post;
  showDeleteModal.value = true;
};

const deleteForm = useForm({});

const deletePost = () => {
  if (!activePost.value) return;

  deleteForm.delete(`/admin/berita/${activePost.value.id}`, {
    onSuccess: () => {
      showDeleteModal.value = false;
      activePost.value = null;
    },
    onError: () => {
      showDeleteModal.value = false;
    }
  });
};
</script>
