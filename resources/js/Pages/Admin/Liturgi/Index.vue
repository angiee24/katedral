<template>
  <AdminLayout title="Kelola Jadwal & Liturgi">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
      <p class="text-[13.5px] text-[#605e58]">Kelola jadwal Misa Mingguan, Perayaan Khusus, dan agenda liturgi Gereja Katedral Samarinda.</p>
      
      <button 
        type="button"
        @click="openAddModal"
        class="bg-[#765a27] text-white hover:bg-[#60491f] px-5 py-3 rounded-lg text-[12px] font-semibold uppercase tracking-wider transition-all shadow flex items-center gap-1.5 self-start md:self-auto"
      >
        <span class="material-symbols-outlined text-[16px]">add</span>
        <span>Tambah Agenda Liturgi</span>
      </button>
    </div>

    
    <div class="bg-white rounded-xl p-6 border border-[#d1c5b5]/30 shadow-sm mb-8 flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4">
      
      <div class="relative w-full md:max-w-xs">
        <input 
          type="text" 
          v-model="filters.q"
          @input="handleFilterChange"
          placeholder="Cari agenda liturgi..."
          class="w-full bg-white border-b border-[#d1c5b5] focus:border-[#765a27] py-2 pl-9 pr-4 text-[12.5px] outline-none transition-colors duration-300 rounded-t shadow-sm"
        />
        <span class="material-symbols-outlined absolute left-2.5 top-1/2 -translate-y-1/2 text-[#605e58] text-[16px]">
          search
        </span>
      </div>

      
      <div class="flex flex-wrap gap-4 items-center">
        
        <select 
          v-model="filters.type"
          @change="handleFilterChange"
          class="bg-white border-b border-[#d1c5b5] focus:border-[#765a27] py-2 px-3 text-[12.5px] outline-none transition-colors duration-300 rounded shadow-sm"
        >
          <option value="">Semua Tipe</option>
          <option value="misa">Misa Mingguan/Harian</option>
          <option value="pengumuman">Kalender Liturgi</option>
          <option value="kalender">Acara Paroki</option>
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
              <th class="py-4 px-6 font-semibold uppercase tracking-wider text-[11px] w-24">Tipe</th>
              <th class="py-4 px-6 font-semibold uppercase tracking-wider text-[11px]">Nama Perayaan / Agenda</th>
              <th class="py-4 px-6 font-semibold uppercase tracking-wider text-[11px]">Tanggal</th>
              <th class="py-4 px-6 font-semibold uppercase tracking-wider text-[11px]">Waktu</th>
              <th class="py-4 px-6 font-semibold uppercase tracking-wider text-[11px]">Lokasi</th>
              <th class="py-4 px-6 font-semibold uppercase tracking-wider text-[11px]">Status</th>
              <th class="py-4 px-6 font-semibold uppercase tracking-wider text-[11px] text-right">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-[#d1c5b5]/10">
            <tr 
              v-for="liturgy in liturgies.data" 
              :key="liturgy.id"
              class="hover:bg-[#FAF9F6]/40 transition-colors"
            >
              
              <td class="py-4 px-6">
                <span 
                  class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider"
                  :class="getTypeBadgeClasses(liturgy.type)"
                >
                  {{ formatType(liturgy.type) }}
                </span>
              </td>
              
              
              <td class="py-4 px-6 font-bold text-[#1a1c1a]">
                {{ liturgy.title }}
                <p v-if="liturgy.content" class="text-[11.5px] font-normal text-[#605e58] mt-0.5 line-clamp-1">
                  {{ liturgy.content }}
                </p>
              </td>

              
              <td class="py-4 px-6 text-[#605e58]">
                {{ formatDate(liturgy.event_date) }}
              </td>

              
              <td class="py-4 px-6 text-[#605e58]">
                {{ liturgy.event_time || '-' }}
              </td>

              
              <td class="py-4 px-6 text-[#605e58] font-medium">
                {{ liturgy.location || 'Gereja Katedral' }}
              </td>

              
              <td class="py-4 px-6">
                <span 
                  class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider border"
                  :class="liturgy.status === 'published' ? 'bg-green-50 text-green-700 border-green-200' : 'bg-gray-50 text-gray-600 border-gray-200'"
                >
                  {{ liturgy.status === 'published' ? 'Terbit' : 'Draf' }}
                </span>
              </td>

              
              <td class="py-4 px-6 text-right space-x-1.5 whitespace-nowrap">
                <button 
                  @click="openEditModal(liturgy)"
                  class="inline-flex items-center justify-center w-8 h-8 rounded-full border border-[#d1c5b5] hover:border-[#765a27] text-[#605e58] hover:text-[#765a27] transition-all bg-white shadow-sm"
                  title="Sunting Agenda"
                >
                  <span class="material-symbols-outlined text-[16px]">edit</span>
                </button>
                <button 
                  @click="confirmDelete(liturgy)"
                  class="inline-flex items-center justify-center w-8 h-8 rounded-full border border-red-200 hover:border-red-500 text-red-500 hover:bg-red-50 transition-all bg-white shadow-sm"
                  title="Hapus Agenda"
                >
                  <span class="material-symbols-outlined text-[16px]">delete</span>
                </button>
              </td>
            </tr>
            
            <tr v-if="liturgies.data.length === 0">
              <td colspan="7" class="py-12 px-6 text-center text-[#605e58]">
                <span class="material-symbols-outlined text-[#d1c5b5] text-5xl mb-3 block">calendar_today</span>
                Belum ada jadwal liturgi yang tersedia.
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      
      <div class="bg-[#FAF9F6] border-t border-[#d1c5b5]/20 py-4 px-6 flex justify-center items-center" v-if="liturgies.links && liturgies.links.length > 3">
        <div class="flex gap-2">
          <template v-for="(link, i) in liturgies.links" :key="i">
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
        v-if="showModal" 
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
        @click.self="closeModal"
      >
        <div class="relative max-w-lg w-full bg-white rounded-2xl overflow-hidden shadow-2xl flex flex-col border border-[#d1c5b5]/30">
          
          <div class="p-6 border-b border-[#d1c5b5]/20 flex items-center justify-between bg-[#FAF9F6]">
            <h3 class="font-serif text-[20px] text-[#1a1c1a] font-bold">
              {{ isEditing ? 'Sunting Agenda Liturgi' : 'Tambah Agenda Liturgi' }}
            </h3>
            <button @click="closeModal" class="text-[#605e58] hover:text-[#1a1c1a]">
              <span class="material-symbols-outlined text-[24px]">close</span>
            </button>
          </div>

          
          <form @submit.prevent="submitForm" class="p-6 flex flex-col gap-5 overflow-y-auto max-h-[70vh]">
            
            <div>
              <label class="block text-[11.5px] font-bold text-[#605e58] uppercase tracking-widest mb-1.5">Tipe Agenda *</label>
              <select 
                v-model="form.type"
                class="w-full bg-white border border-[#d1c5b5] focus:border-[#765a27] rounded-lg px-3.5 py-2.5 text-[13px] outline-none transition-colors"
                :class="{ 'border-red-500': form.errors.type }"
              >
                <option value="misa">Misa Mingguan/Harian</option>
                <option value="pengumuman">Kalender Liturgi</option>
                <option value="kalender">Acara Paroki</option>
              </select>
              <span v-if="form.errors.type" class="text-red-500 text-[11px] mt-1 block">{{ form.errors.type }}</span>
            </div>

            
            <div>
              <label class="block text-[11.5px] font-bold text-[#605e58] uppercase tracking-widest mb-1.5">Nama Perayaan / Agenda *</label>
              <input 
                type="text" 
                v-model="form.title"
                placeholder="Contoh: Misa Hari Raya Pentakosta"
                class="w-full bg-white border border-[#d1c5b5] focus:border-[#765a27] rounded-lg px-3.5 py-2.5 text-[13px] outline-none transition-colors"
                :class="{ 'border-red-500': form.errors.title }"
              />
              <span v-if="form.errors.title" class="text-red-500 text-[11px] mt-1 block">{{ form.errors.title }}</span>
            </div>

            
            <div>
              <label class="block text-[11.5px] font-bold text-[#605e58] uppercase tracking-widest mb-1.5">Keterangan Tambahan</label>
              <textarea 
                v-model="form.content"
                rows="3"
                placeholder="Keterangan liturgi, petugas, atau catatan khusus..."
                class="w-full bg-white border border-[#d1c5b5] focus:border-[#765a27] rounded-lg px-3.5 py-2.5 text-[13px] outline-none transition-colors resize-none"
                :class="{ 'border-red-500': form.errors.content }"
              ></textarea>
              <span v-if="form.errors.content" class="text-red-500 text-[11px] mt-1 block">{{ form.errors.content }}</span>
            </div>

            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-[11.5px] font-bold text-[#605e58] uppercase tracking-widest mb-1.5">Tanggal Pelaksanaan *</label>
                <input 
                  type="date" 
                  v-model="form.event_date"
                  class="w-full bg-white border border-[#d1c5b5] focus:border-[#765a27] rounded-lg px-3.5 py-2.5 text-[13px] outline-none transition-colors"
                  :class="{ 'border-red-500': form.errors.event_date }"
                />
                <span v-if="form.errors.event_date" class="text-red-500 text-[11px] mt-1 block">{{ form.errors.event_date }}</span>
              </div>

              <div>
                <label class="block text-[11.5px] font-bold text-[#605e58] uppercase tracking-widest mb-1.5">Waktu / Jam *</label>
                <div class="flex gap-4 items-center h-[46px] border border-[#d1c5b5]/50 rounded-lg px-4 bg-[#FAF9F6]/40">
                  <label class="inline-flex items-center gap-1.5 text-[13px] cursor-pointer">
                    <input type="radio" v-model="timeOption" value="no-time" class="text-[#765a27] focus:ring-[#765a27] cursor-pointer" />
                    <span class="text-[#1a1c1a] font-medium">Tidak Ada (-)</span>
                  </label>
                  <label class="inline-flex items-center gap-1.5 text-[13px] cursor-pointer">
                    <input type="radio" v-model="timeOption" value="has-time" class="text-[#765a27] focus:ring-[#765a27] cursor-pointer" />
                    <span class="text-[#1a1c1a] font-medium">Ada Waktu</span>
                  </label>
                </div>
                <div v-if="timeOption === 'has-time'" class="mt-2 flex items-center gap-2">
                  <input 
                    type="time" 
                    v-model="selectedTimeVal"
                    class="bg-white border border-[#d1c5b5] focus:border-[#765a27] rounded-lg px-3.5 py-2 text-[13px] outline-none"
                    required
                  />
                  <span class="text-[13px] font-bold text-[#605e58]">WITA</span>
                </div>
                <span v-if="form.errors.event_time" class="text-red-500 text-[11px] mt-1 block">{{ form.errors.event_time }}</span>
              </div>
            </div>

            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-[11.5px] font-bold text-[#605e58] uppercase tracking-widest mb-1.5">Lokasi</label>
                <input 
                  type="text" 
                  v-model="form.location"
                  placeholder="Contoh: Gereja Katedral"
                  class="w-full bg-white border border-[#d1c5b5] focus:border-[#765a27] rounded-lg px-3.5 py-2.5 text-[13px] outline-none transition-colors"
                  :class="{ 'border-red-500': form.errors.location }"
                />
                <span v-if="form.errors.location" class="text-red-500 text-[11px] mt-1 block">{{ form.errors.location }}</span>
              </div>

              <div>
                <label class="block text-[11.5px] font-bold text-[#605e58] uppercase tracking-widest mb-1.5">Status Publikasi</label>
                <select 
                  v-model="form.status"
                  class="w-full bg-white border border-[#d1c5b5] focus:border-[#765a27] rounded-lg px-3.5 py-2.5 text-[13px] outline-none transition-colors"
                  :class="{ 'border-red-500': form.errors.status }"
                >
                  <option value="published">Terbitkan</option>
                  <option value="draft">Draf</option>
                </select>
                <span v-if="form.errors.status" class="text-red-500 text-[11px] mt-1 block">{{ form.errors.status }}</span>
              </div>
            </div>

            
            <div class="flex justify-end gap-3 border-t border-[#d1c5b5]/20 pt-5 mt-2">
              <button 
                type="button" 
                @click="closeModal"
                class="border border-[#d1c5b5] text-[#605e58] hover:bg-black/5 px-4.5 py-2 rounded-lg text-[12px] font-semibold uppercase tracking-wider transition-colors"
              >
                Batal
              </button>
              <button 
                type="submit" 
                :disabled="form.processing"
                class="bg-[#765a27] text-white hover:bg-[#60491f] disabled:bg-gray-300 disabled:cursor-not-allowed px-5 py-2 rounded-lg text-[12px] font-semibold uppercase tracking-wider transition-all shadow flex items-center gap-1"
              >
                <span class="material-symbols-outlined text-[16px]">{{ form.processing ? 'sync' : 'save' }}</span>
                <span>{{ form.processing ? 'Menyimpan...' : 'Simpan' }}</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </transition>

    
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
          <h3 class="font-serif text-[22px] text-[#1a1c1a] font-bold mb-2">Hapus Agenda Liturgi?</h3>
          <p class="text-[#605e58] text-[13.5px] leading-relaxed mb-8">
            Apakah Anda yakin ingin menghapus agenda <strong>{{ activeLiturgy?.title }}</strong>? Tindakan ini tidak dapat dibatalkan.
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
              @click="deleteLiturgy"
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
import { ref, reactive, computed, watch } from 'vue';
import { Link, router, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
  liturgies: Object,
  filters: Object,
});

const filters = reactive({
  q: props.filters?.q || '',
  type: props.filters?.type || '',
});

const showModal = ref(false);
const isEditing = ref(false);
const showDeleteModal = ref(false);
const activeLiturgy = ref(null);

const timeOption = ref('has-time'); 
const selectedTimeVal = ref('08:00');

const form = useForm({
  type: 'misa',
  title: '',
  content: '',
  event_date: '',
  event_time: '',
  location: '',
  status: 'published',
});


watch([timeOption, selectedTimeVal], () => {
  if (timeOption.value === 'no-time') {
    form.event_time = '-';
  } else {
    form.event_time = `${selectedTimeVal.value} WITA`;
  }
}, { immediate: true });

let filterTimeout = null;

const handleFilterChange = () => {
  clearTimeout(filterTimeout);
  filterTimeout = setTimeout(() => {
    router.get('/admin/liturgi', {
      q: filters.q,
      type: filters.type,
    }, {
      preserveState: true,
      replace: true,
    });
  }, 400);
};

const resetFilters = () => {
  filters.q = '';
  filters.type = '';
  handleFilterChange();
};

const hasActiveFilters = computed(() => {
  return filters.q !== '' || filters.type !== '';
});

const openAddModal = () => {
  isEditing.value = false;
  form.reset();
  timeOption.value = 'has-time';
  selectedTimeVal.value = '08:00';
  form.event_time = '08:00 WITA';
  form.clearErrors();
  showModal.value = true;
};

const openEditModal = (liturgy) => {
  isEditing.value = true;
  activeLiturgy.value = liturgy;
  
  form.type = liturgy.type;
  form.title = liturgy.title;
  form.content = liturgy.content || '';
  form.event_date = liturgy.event_date;
  form.location = liturgy.location || '';
  form.status = liturgy.status;
  
  if (!liturgy.event_time || liturgy.event_time === '-') {
    timeOption.value = 'no-time';
    selectedTimeVal.value = '08:00';
    form.event_time = '-';
  } else {
    timeOption.value = 'has-time';
    
    const cleanedTime = liturgy.event_time.replace(' WITA', '').trim();
    
    if (/^\d{2}:\d{2}$/.test(cleanedTime)) {
      selectedTimeVal.value = cleanedTime;
    } else {
      selectedTimeVal.value = '08:00';
    }
    form.event_time = liturgy.event_time;
  }
  
  form.clearErrors();
  showModal.value = true;
};

const closeModal = () => {
  showModal.value = false;
  activeLiturgy.value = null;
};

const submitForm = () => {
  if (isEditing.value) {
    form.put(`/admin/liturgi/${activeLiturgy.value.id}`, {
      onSuccess: () => {
        closeModal();
      }
    });
  } else {
    form.post('/admin/liturgi', {
      onSuccess: () => {
        closeModal();
      }
    });
  }
};

const confirmDelete = (liturgy) => {
  activeLiturgy.value = liturgy;
  showDeleteModal.value = true;
};

const deleteForm = useForm({});

const deleteLiturgy = () => {
  if (!activeLiturgy.value) return;

  deleteForm.delete(`/admin/liturgi/${activeLiturgy.value.id}`, {
    onSuccess: () => {
      showDeleteModal.value = false;
      activeLiturgy.value = null;
    },
    onError: () => {
      showDeleteModal.value = false;
    }
  });
};

const getTypeBadgeClasses = (type) => {
  if (type === 'misa') return 'bg-[#765a27]/10 text-[#765a27] border border-[#765a27]/20';
  if (type === 'pengumuman') return 'bg-[#5c6b73]/10 text-[#5c6b73] border border-[#5c6b73]/20';
  return 'bg-[#9e2a2b]/10 text-[#9e2a2b] border border-[#9e2a2b]/20'; 
};

const formatType = (type) => {
  if (type === 'misa') return 'Misa';
  if (type === 'pengumuman') return 'Kalender';
  return 'Acara';
};

const formatDate = (dateStr) => {
  if (!dateStr) return '';
  const date = new Date(dateStr);
  return date.toLocaleDateString('id-ID', {
    weekday: 'long',
    day: 'numeric',
    month: 'long',
    year: 'numeric'
  });
};
</script>
