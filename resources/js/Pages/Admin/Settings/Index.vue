<template>
  <AdminLayout title="Pengaturan Website">
    <div class="max-w-6xl mx-auto">
      
      <div class="flex border-b border-[#d1c5b5]/30 mb-8 gap-6">
        <button 
          @click="activeTab = 'profile'"
          class="pb-4 text-[13.5px] font-bold uppercase tracking-wider border-b-2 transition-all duration-300"
          :class="activeTab === 'profile' ? 'border-[#765a27] text-[#765a27]' : 'border-transparent text-[#605e58] hover:text-[#1a1c1a]'"
        >
          Profil Paroki & Tampilan
        </button>
        <button 
          @click="activeTab = 'timeline'"
          class="pb-4 text-[13.5px] font-bold uppercase tracking-wider border-b-2 transition-all duration-300"
          :class="activeTab === 'timeline' ? 'border-[#765a27] text-[#765a27]' : 'border-transparent text-[#605e58] hover:text-[#1a1c1a]'"
        >
          Linimasa Sejarah
        </button>
      </div>

      
      <div v-show="activeTab === 'profile'">
        <form @submit.prevent="submitProfile" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
          
          <div class="lg:col-span-2 flex flex-col gap-6">
            
            <div class="bg-white rounded-xl border border-[#d1c5b5]/30 shadow-sm p-6 flex flex-col gap-5">
              <h3 class="font-serif text-[18px] text-[#1a1c1a] font-bold border-b border-[#d1c5b5]/20 pb-3 flex items-center gap-2">
                <span class="material-symbols-outlined text-[#765a27]">church</span>
                Informasi Umum Paroki
              </h3>
              
              <div>
                <label class="block text-[11.5px] font-bold text-[#605e58] uppercase tracking-widest mb-1.5">Nama Gereja *</label>
                <input 
                  type="text" 
                  v-model="form.church_name"
                  class="w-full bg-white border border-[#d1c5b5] focus:border-[#765a27] rounded-lg px-3.5 py-2.5 text-[13px] outline-none transition-colors"
                  :class="{ 'border-red-500': form.errors.church_name }"
                />
                <span v-if="form.errors.church_name" class="text-red-500 text-[11px] mt-1 block">{{ form.errors.church_name }}</span>
              </div>

              <div>
                <label class="block text-[11.5px] font-bold text-[#605e58] uppercase tracking-widest mb-1.5">Alamat Lengkap *</label>
                <input 
                  type="text" 
                  v-model="form.church_address"
                  class="w-full bg-white border border-[#d1c5b5] focus:border-[#765a27] rounded-lg px-3.5 py-2.5 text-[13px] outline-none transition-colors"
                  :class="{ 'border-red-500': form.errors.church_address }"
                />
                <span v-if="form.errors.church_address" class="text-red-500 text-[11px] mt-1 block">{{ form.errors.church_address }}</span>
              </div>

              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                  <label class="block text-[11.5px] font-bold text-[#605e58] uppercase tracking-widest mb-1.5">No. Telepon *</label>
                  <input 
                    type="text" 
                    v-model="form.church_phone"
                    class="w-full bg-white border border-[#d1c5b5] focus:border-[#765a27] rounded-lg px-3.5 py-2.5 text-[13px] outline-none transition-colors"
                    :class="{ 'border-red-500': form.errors.church_phone }"
                  />
                  <span v-if="form.errors.church_phone" class="text-red-500 text-[11px] mt-1 block">{{ form.errors.church_phone }}</span>
                </div>

                <div>
                  <label class="block text-[11.5px] font-bold text-[#605e58] uppercase tracking-widest mb-1.5">Email Paroki *</label>
                  <input 
                    type="email" 
                    v-model="form.church_email"
                    class="w-full bg-white border border-[#d1c5b5] focus:border-[#765a27] rounded-lg px-3.5 py-2.5 text-[13px] outline-none transition-colors"
                    :class="{ 'border-red-500': form.errors.church_email }"
                  />
                  <span v-if="form.errors.church_email" class="text-red-500 text-[11px] mt-1 block">{{ form.errors.church_email }}</span>
                </div>
              </div>

              <div>
                <label class="block text-[11.5px] font-bold text-[#605e58] uppercase tracking-widest mb-1.5">Embed Link Google Maps</label>
                <input 
                  type="text" 
                  v-model="form.maps_embed_url"
                  placeholder="URL src iframe Google Maps..."
                  class="w-full bg-white border border-[#d1c5b5] focus:border-[#765a27] rounded-lg px-3.5 py-2.5 text-[13px] outline-none transition-colors"
                />
              </div>

              <div>
                <label class="block text-[11.5px] font-bold text-[#605e58] uppercase tracking-widest mb-1.5">Link Peta (Google Maps Direct Link)</label>
                <input 
                  type="text" 
                  v-model="form.church_maps_link"
                  placeholder="https://maps.app.goo.gl/..."
                  class="w-full bg-white border border-[#d1c5b5] focus:border-[#765a27] rounded-lg px-3.5 py-2.5 text-[13px] outline-none transition-colors"
                />
              </div>
            </div>

            
            <div class="bg-white rounded-xl border border-[#d1c5b5]/30 shadow-sm p-6 flex flex-col gap-5">
              <h3 class="font-serif text-[18px] text-[#1a1c1a] font-bold border-b border-[#d1c5b5]/20 pb-3 flex items-center gap-2">
                <span class="material-symbols-outlined text-[#765a27]">flag</span>
                Visi & Misi Paroki
              </h3>
              
              <div>
                <label class="block text-[11.5px] font-bold text-[#605e58] uppercase tracking-widest mb-1.5">Visi Paroki *</label>
                <textarea 
                  v-model="form.church_vision"
                  rows="2"
                  class="w-full bg-white border border-[#d1c5b5] focus:border-[#765a27] rounded-lg px-3.5 py-2.5 text-[13px] outline-none transition-colors resize-none"
                  :class="{ 'border-red-500': form.errors.church_vision }"
                ></textarea>
                <span v-if="form.errors.church_vision" class="text-red-500 text-[11px] mt-1 block">{{ form.errors.church_vision }}</span>
              </div>

              <div>
                <label class="block text-[11.5px] font-bold text-[#605e58] uppercase tracking-widest mb-1.5">Misi Paroki (Teks Bebas / Poin) *</label>
                <textarea 
                  v-model="form.church_mission"
                  rows="5"
                  placeholder="Tuliskan misi paroki (gunakan baris baru untuk setiap poin)..."
                  class="w-full bg-white border border-[#d1c5b5] focus:border-[#765a27] rounded-lg px-3.5 py-2.5 text-[13px] outline-none transition-colors"
                  :class="{ 'border-red-500': form.errors.church_mission }"
                ></textarea>
                <span v-if="form.errors.church_mission" class="text-red-500 text-[11px] mt-1 block">{{ form.errors.church_mission }}</span>
              </div>
            </div>
          </div>

          
          <div class="flex flex-col gap-6">
            
            <div class="bg-white rounded-xl border border-[#d1c5b5]/30 shadow-sm p-6 flex flex-col gap-5">
              <h3 class="font-serif text-[18px] text-[#1a1c1a] font-bold border-b border-[#d1c5b5]/20 pb-3 flex items-center gap-2">
                <span class="material-symbols-outlined text-[#765a27]">image</span>
                Tampilan Depan (Hero Banner)
              </h3>
              
              <div>
                <label class="block text-[11.5px] font-bold text-[#605e58] uppercase tracking-widest mb-1.5">Judul Banner *</label>
                <input 
                  type="text" 
                  v-model="form.banner_title"
                  class="w-full bg-white border border-[#d1c5b5] focus:border-[#765a27] rounded-lg px-3.5 py-2.5 text-[13px] outline-none transition-colors"
                  :class="{ 'border-red-500': form.errors.banner_title }"
                />
              </div>

              <div>
                <label class="block text-[11.5px] font-bold text-[#605e58] uppercase tracking-widest mb-1.5">Sub-judul Banner *</label>
                <textarea 
                  v-model="form.banner_subtitle"
                  rows="2"
                  class="w-full bg-white border border-[#d1c5b5] focus:border-[#765a27] rounded-lg px-3.5 py-2.5 text-[13px] outline-none transition-colors resize-none"
                  :class="{ 'border-red-500': form.errors.banner_subtitle }"
                ></textarea>
              </div>

              
              <div>
                <label class="block text-[11.5px] font-bold text-[#605e58] uppercase tracking-widest mb-1.5">Gambar Hero *</label>
                <div class="border border-[#d1c5b5]/50 rounded-xl overflow-hidden shadow-sm relative group bg-[#FAF9F6] aspect-video flex items-center justify-center">
                  <img 
                    v-if="form.banner_image" 
                    :src="form.banner_image" 
                    class="w-full h-full object-cover"
                  />
                  <span v-else class="material-symbols-outlined text-[#d1c5b5] text-5xl">image</span>
                  
                  <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                    <button 
                      type="button" 
                      @click="openMediaSelector('banner')"
                      class="bg-white hover:bg-[#FAF9F6] text-[#765a27] rounded-lg px-4 py-2.5 text-[11.5px] font-bold uppercase tracking-wider transition-colors shadow flex items-center gap-1.5"
                    >
                      <span class="material-symbols-outlined text-[16px]">photo_library</span>
                      <span>Pilih Gambar</span>
                    </button>
                  </div>
                </div>
                <span v-if="form.errors.banner_image" class="text-red-500 text-[11px] mt-1.5 block">{{ form.errors.banner_image }}</span>
              </div>
            </div>

            
            <div class="bg-white rounded-xl border border-[#d1c5b5]/30 shadow-sm p-6 flex flex-col gap-5">
              <h3 class="font-serif text-[18px] text-[#1a1c1a] font-bold border-b border-[#d1c5b5]/20 pb-3 flex items-center gap-2">
                <span class="material-symbols-outlined text-[#765a27]">schedule</span>
                Jam Kerja Sekretariat
              </h3>
              
              <div>
                <label class="block text-[11.5px] font-bold text-[#605e58] uppercase tracking-widest mb-1.5">Senin - Jumat *</label>
                <input 
                  type="text" 
                  v-model="form.church_work_hours_mon_fri"
                  class="w-full bg-white border border-[#d1c5b5] focus:border-[#765a27] rounded-lg px-3.5 py-2.5 text-[13px] outline-none transition-colors"
                  :class="{ 'border-red-500': form.errors.church_work_hours_mon_fri }"
                />
              </div>

              <div>
                <label class="block text-[11.5px] font-bold text-[#605e58] uppercase tracking-widest mb-1.5">Sabtu *</label>
                <input 
                  type="text" 
                  v-model="form.church_work_hours_sat"
                  class="w-full bg-white border border-[#d1c5b5] focus:border-[#765a27] rounded-lg px-3.5 py-2.5 text-[13px] outline-none transition-colors"
                  :class="{ 'border-red-500': form.errors.church_work_hours_sat }"
                />
              </div>

              <div>
                <label class="block text-[11.5px] font-bold text-[#605e58] uppercase tracking-widest mb-1.5">Minggu *</label>
                <input 
                  type="text" 
                  v-model="form.church_work_hours_sun"
                  class="w-full bg-white border border-[#d1c5b5] focus:border-[#765a27] rounded-lg px-3.5 py-2.5 text-[13px] outline-none transition-colors"
                  :class="{ 'border-red-500': form.errors.church_work_hours_sun }"
                />
              </div>
            </div>

            
            <button 
              type="submit"
              :disabled="form.processing"
              class="bg-[#765a27] text-white hover:bg-[#60491f] disabled:bg-gray-300 disabled:cursor-not-allowed py-3 rounded-lg text-[13px] font-bold uppercase tracking-wider transition-all shadow-md flex items-center justify-center gap-1.5 w-full"
            >
              <span class="material-symbols-outlined text-[18px]">{{ form.processing ? 'sync' : 'save' }}</span>
              <span>{{ form.processing ? 'Menyimpan...' : 'Simpan Pengaturan' }}</span>
            </button>
          </div>
        </form>
      </div>

      
      <div v-show="activeTab === 'timeline'">
        
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 mb-8 bg-white p-6 border border-[#d1c5b5]/30 rounded-xl shadow-sm">
          <div>
            <h3 class="font-serif text-[18px] text-[#1a1c1a] font-bold">Tonggak Linimasa Sejarah</h3>
            <p class="text-[12.5px] text-[#605e58] mt-0.5">Kelola data tonggak sejarah gereja yang ditampilkan pada halaman sejarah.</p>
          </div>
          <button 
            type="button"
            @click="openAddTimelineModal"
            class="bg-[#765a27] text-white hover:bg-[#60491f] px-4 py-2.5 rounded-lg text-[12px] font-semibold uppercase tracking-wider transition-all shadow flex items-center gap-1.5 self-start sm:self-auto"
          >
            <span class="material-symbols-outlined text-[16px]">add_circle</span>
            <span>Tambah Tonggak Sejarah</span>
          </button>
        </div>

        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
          <div 
            v-for="time in timelines" 
            :key="time.id"
            class="bg-white border border-[#d1c5b5]/30 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 group flex flex-col justify-between"
          >
            
            <div class="p-5 flex-grow relative">
              
              <span class="absolute top-5 right-5 bg-[#765a27] text-white font-bold text-[11px] w-6 h-6 rounded-full flex items-center justify-center shadow">
                {{ time.order }}
              </span>
              <span class="text-[#765a27] font-serif text-[20px] font-bold">{{ time.year }}</span>
              <h4 class="font-bold text-[#1a1c1a] text-[14px] mt-1 line-clamp-1">{{ time.title }}</h4>
              <p class="text-[12.5px] text-[#605e58] mt-2 line-clamp-3 leading-relaxed">{{ time.description }}</p>
            </div>

            
            <div class="bg-[#FAF9F6] border-t border-[#d1c5b5]/15 py-3 px-5 flex justify-end gap-2">
              <button 
                @click="openEditTimelineModal(time)"
                class="text-[11.5px] font-bold text-[#765a27] hover:text-[#60491f] flex items-center gap-1 bg-white border border-[#d1c5b5]/30 px-3 py-1.5 rounded-lg shadow-sm"
              >
                <span class="material-symbols-outlined text-[15px]">edit</span>
                <span>Sunting</span>
              </button>
              <button 
                @click="confirmTimelineDelete(time)"
                class="text-[11.5px] font-bold text-[#ba1a1a] hover:text-[#93000a] flex items-center gap-1 bg-white border border-red-200 px-3 py-1.5 rounded-lg shadow-sm"
              >
                <span class="material-symbols-outlined text-[15px]">delete</span>
                <span>Hapus</span>
              </button>
            </div>
          </div>

          <div v-if="timelines.length === 0" class="col-span-full text-center py-20 bg-white border border-[#d1c5b5]/30 rounded-xl shadow-sm">
            <span class="material-symbols-outlined text-[#d1c5b5] text-5xl mb-3 block">history_toggle_off</span>
            Belum ada data linimasa sejarah paroki.
          </div>
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
        v-if="showTimelineModal" 
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
        @click.self="showTimelineModal = false"
      >
        <div class="relative max-w-lg w-full bg-white rounded-2xl overflow-hidden shadow-2xl flex flex-col border border-[#d1c5b5]/30">
          <div class="p-6 border-b border-[#d1c5b5]/20 flex items-center justify-between bg-[#FAF9F6]">
            <h3 class="font-serif text-[20px] text-[#1a1c1a] font-bold">
              {{ isEditingTimeline ? 'Sunting Tonggak Sejarah' : 'Tambah Tonggak Sejarah' }}
            </h3>
            <button @click="showTimelineModal = false" class="text-[#605e58] hover:text-[#1a1c1a]">
              <span class="material-symbols-outlined text-[24px]">close</span>
            </button>
          </div>

          <form @submit.prevent="submitTimeline" class="p-6 flex flex-col gap-4">
            
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-[11.5px] font-bold text-[#605e58] uppercase tracking-widest mb-1.5">Tahun / Periode *</label>
                <input 
                  type="text" 
                  v-model="timelineForm.year"
                  placeholder="Contoh: 1953 atau 1953 - 1960"
                  class="w-full bg-white border border-[#d1c5b5] focus:border-[#765a27] rounded-lg px-3.5 py-2.5 text-[13px] outline-none transition-colors"
                  :class="{ 'border-red-500': timelineForm.errors.year }"
                />
              </div>

              <div>
                <label class="block text-[11.5px] font-bold text-[#605e58] uppercase tracking-widest mb-1.5">Urutan (Sort Order) *</label>
                <input 
                  type="number" 
                  v-model="timelineForm.order"
                  placeholder="Contoh: 1"
                  class="w-full bg-white border border-[#d1c5b5] focus:border-[#765a27] rounded-lg px-3.5 py-2.5 text-[13px] outline-none transition-colors"
                  :class="{ 'border-red-500': timelineForm.errors.order }"
                />
              </div>
            </div>

            
            <div>
              <label class="block text-[11.5px] font-bold text-[#605e58] uppercase tracking-widest mb-1.5">Judul Peristiwa *</label>
              <input 
                type="text" 
                v-model="timelineForm.title"
                placeholder="Contoh: Peletakan Batu Pertama"
                class="w-full bg-white border border-[#d1c5b5] focus:border-[#765a27] rounded-lg px-3.5 py-2.5 text-[13px] outline-none transition-colors"
                :class="{ 'border-red-500': timelineForm.errors.title }"
              />
            </div>

            
            <div>
              <label class="block text-[11.5px] font-bold text-[#605e58] uppercase tracking-widest mb-1.5">Deskripsi Peristiwa *</label>
              <textarea 
                v-model="timelineForm.description"
                rows="4"
                placeholder="Ceritakan detail peristiwa sejarah gereja pada tahun tersebut..."
                class="w-full bg-white border border-[#d1c5b5] focus:border-[#765a27] rounded-lg px-3.5 py-2.5 text-[13px] outline-none transition-colors"
                :class="{ 'border-red-500': timelineForm.errors.description }"
              ></textarea>
            </div>



            <div class="flex justify-end gap-3 border-t border-[#d1c5b5]/20 pt-5 mt-2">
              <button 
                type="button" 
                @click="showTimelineModal = false"
                class="border border-[#d1c5b5] text-[#605e58] hover:bg-black/5 px-4.5 py-2 rounded-lg text-[12px] font-semibold uppercase tracking-wider transition-colors"
              >
                Batal
              </button>
              <button 
                type="submit" 
                :disabled="timelineForm.processing"
                class="bg-[#765a27] text-white hover:bg-[#60491f] disabled:bg-gray-300 disabled:cursor-not-allowed px-5 py-2 rounded-lg text-[12px] font-semibold uppercase tracking-wider transition-all shadow flex items-center gap-1"
              >
                <span class="material-symbols-outlined text-[16px]">{{ timelineForm.processing ? 'sync' : 'save' }}</span>
                <span>Simpan</span>
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
        v-if="showTimelineDeleteModal" 
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
        @click.self="showTimelineDeleteModal = false"
      >
        <div class="relative max-w-md w-full bg-white rounded-2xl overflow-hidden shadow-2xl p-8 text-center flex flex-col items-center">
          <div class="w-16 h-16 rounded-full bg-red-50 text-[#ba1a1a] flex items-center justify-center mb-6">
            <span class="material-symbols-outlined text-[36px]">warning</span>
          </div>
          <h3 class="font-serif text-[22px] text-[#1a1c1a] font-bold mb-2">Hapus Tonggak Sejarah?</h3>
          <p class="text-[#605e58] text-[13.5px] leading-relaxed mb-8">
            Apakah Anda yakin ingin menghapus tonggak sejarah tahun <strong>{{ activeTimeline?.year }}</strong>? Peristiwa ini tidak dapat dipulihkan.
          </p>
          
          <div class="flex gap-4 w-full justify-center">
            <button 
              type="button" 
              @click="showTimelineDeleteModal = false"
              class="border border-[#d1c5b5] text-[#605e58] hover:bg-black/5 px-6 py-3 rounded-lg text-[13px] font-semibold uppercase tracking-wider transition-colors w-1/2"
            >
              Batal
            </button>
            <button 
              type="button" 
              @click="deleteTimeline"
              class="bg-[#ba1a1a] text-white hover:bg-[#93000a] px-6 py-3 rounded-lg text-[13px] font-semibold uppercase tracking-wider transition-colors w-1/2 shadow-sm"
            >
              Hapus
            </button>
          </div>
        </div>
      </div>
    </transition>

    
    <MediaSelector 
      :show="showMediaSelector" 
      :selectedId="null"
      @close="showMediaSelector = false"
      @select="onMediaSelect"
    />
  </AdminLayout>
</template>

<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import MediaSelector from '@/Components/MediaSelector.vue';

const props = defineProps({
  settings: Object,
  timelines: Array,
  mediaFiles: Array,
});

const activeTab = ref('profile');


const form = useForm({
  church_name: props.settings.church_name || '',
  church_address: props.settings.church_address || '',
  church_phone: props.settings.church_phone || '',
  church_email: props.settings.church_email || '',
  church_work_hours_mon_fri: props.settings.church_work_hours_mon_fri || '',
  church_work_hours_sat: props.settings.church_work_hours_sat || '',
  church_work_hours_sun: props.settings.church_work_hours_sun || '',
  church_vision: props.settings.church_vision || '',
  church_mission: props.settings.church_mission || '',
  banner_title: props.settings.banner_title || '',
  banner_subtitle: props.settings.banner_subtitle || '',
  banner_image: props.settings.banner_image || '',
  maps_embed_url: props.settings.maps_embed_url || '',
  church_maps_link: props.settings.church_maps_link || '',
});

const submitProfile = () => {
  form.post('/admin/settings', {
    onSuccess: () => {
      
    }
  });
};


const showTimelineModal = ref(false);
const isEditingTimeline = ref(false);
const showTimelineDeleteModal = ref(false);
const activeTimeline = ref(null);

const timelineForm = useForm({
  year: '',
  title: '',
  description: '',
  image_url: '',
  order: 1,
});

const openAddTimelineModal = () => {
  isEditingTimeline.value = false;
  timelineForm.reset();
  timelineForm.order = props.timelines.length + 1;
  timelineForm.clearErrors();
  showTimelineModal.value = true;
};

const openEditTimelineModal = (time) => {
  isEditingTimeline.value = true;
  activeTimeline.value = time;
  
  timelineForm.year = time.year;
  timelineForm.title = time.title;
  timelineForm.description = time.description;
  timelineForm.image_url = time.image_url || '';
  timelineForm.order = time.order;
  
  timelineForm.clearErrors();
  showTimelineModal.value = true;
};

const submitTimeline = () => {
  if (isEditingTimeline.value) {
    timelineForm.put(`/admin/settings/timeline/${activeTimeline.value.id}`, {
      onSuccess: () => {
        showTimelineModal.value = false;
        activeTimeline.value = null;
      }
    });
  } else {
    timelineForm.post('/admin/settings/timeline', {
      onSuccess: () => {
        showTimelineModal.value = false;
      }
    });
  }
};

const confirmTimelineDelete = (time) => {
  activeTimeline.value = time;
  showTimelineDeleteModal.value = true;
};

const deleteForm = useForm({});

const deleteTimeline = () => {
  if (!activeTimeline.value) return;

  deleteForm.delete(`/admin/settings/timeline/${activeTimeline.value.id}`, {
    onSuccess: () => {
      showTimelineDeleteModal.value = false;
      activeTimeline.value = null;
    }
  });
};


const showMediaSelector = ref(false);
const mediaTarget = ref(null); 

const openMediaSelector = (target) => {
  mediaTarget.value = target;
  showMediaSelector.value = true;
};

const onMediaSelect = (media) => {
  if (mediaTarget.value === 'banner') {
    form.banner_image = media.url;
  } else if (mediaTarget.value === 'timeline') {
    timelineForm.image_url = media.url;
  }
};
</script>
