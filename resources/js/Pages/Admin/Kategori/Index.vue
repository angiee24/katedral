<template>
  <AdminLayout title="Kelola Kategori Warta">
    
    <div class="flex justify-between items-center mb-8">
      <p class="text-[13.5px] text-[#605e58]">Atur kategori pengelompokan berita dan warta paroki.</p>
      <button 
        @click="openAddModal"
        class="bg-[#765a27] text-white hover:bg-[#b5935b] px-5 py-2.5 rounded-lg text-[13px] font-semibold uppercase tracking-wider shadow-sm transition-colors flex items-center gap-1.5"
      >
        <span class="material-symbols-outlined text-[18px]">add</span>
        Tambah Kategori
      </button>
    </div>

    
    <div class="bg-white rounded-xl border border-[#d1c5b5]/30 shadow-sm overflow-hidden mb-8">
      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-[13px]">
          <thead>
            <tr class="bg-[#FAF9F6] border-b border-[#d1c5b5]/20 text-[#605e58]">
              <th class="py-4 px-6 font-semibold uppercase tracking-wider text-[11px]">Nama Kategori</th>
              <th class="py-4 px-6 font-semibold uppercase tracking-wider text-[11px]">Slug / URL</th>
              <th class="py-4 px-6 font-semibold uppercase tracking-wider text-[11px]">Deskripsi</th>
              <th class="py-4 px-6 font-semibold uppercase tracking-wider text-[11px] text-center">Jumlah Warta</th>
              <th class="py-4 px-6 font-semibold uppercase tracking-wider text-[11px] text-right">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-[#d1c5b5]/10">
            <tr 
              v-for="cat in categories.data" 
              :key="cat.id"
              class="hover:bg-[#FAF9F6]/30 transition-colors"
            >
              <td class="py-4 px-6 font-semibold text-[#1a1c1a]">{{ cat.name }}</td>
              <td class="py-4 px-6 font-mono text-[#605e58] text-[12px]">{{ cat.slug }}</td>
              <td class="py-4 px-6 text-[#605e58] max-w-xs truncate">{{ cat.description || 'Tidak ada deskripsi' }}</td>
              <td class="py-4 px-6 text-center font-bold text-[#765a27]">{{ cat.posts_count }}</td>
              <td class="py-4 px-6 text-right space-x-2">
                <button 
                  @click="openEditModal(cat)"
                  class="text-[#765a27] hover:text-[#b5935b] transition-colors p-1.5"
                  title="Ubah Kategori"
                >
                  <span class="material-symbols-outlined text-[20px] block">edit</span>
                </button>
                <button 
                  @click="confirmDelete(cat)"
                  class="text-[#ba1a1a] hover:text-[#ffdad6] transition-colors p-1.5 rounded-full hover:bg-[#ffdad6]/20"
                  title="Hapus Kategori"
                >
                  <span class="material-symbols-outlined text-[20px] block">delete</span>
                </button>
              </td>
            </tr>
            <tr v-if="categories.data.length === 0">
              <td colspan="5" class="py-8 text-center text-[#605e58]">Belum ada kategori yang dibuat.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    
    <div class="flex justify-center items-center gap-2" v-if="categories.links && categories.links.length > 3">
      <template v-for="(link, i) in categories.links" :key="i">
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

    
    <transition
      enter-active-class="transition duration-300 ease-out"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition duration-200 ease-in"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div 
        v-if="showFormModal" 
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
        @click.self="closeFormModal"
      >
        <div class="relative max-w-md w-full bg-white rounded-2xl overflow-hidden shadow-2xl p-8">
          <h3 class="font-serif text-[22px] text-[#1a1c1a] font-bold mb-6">
            {{ isEditMode ? 'Ubah Kategori' : 'Tambah Kategori Baru' }}
          </h3>
          
          <form @submit.prevent="submitForm" class="space-y-6">
            
            <div class="flex flex-col">
              <label for="cat-name" class="text-[11px] font-bold text-[#1a1c1a] uppercase tracking-wider mb-2">Nama Kategori</label>
              <input 
                type="text" 
                id="cat-name" 
                v-model="form.name"
                class="bg-[#FAF9F6] border-b border-[#d1c5b5] focus:border-[#765a27] py-3 px-4 text-[14px] outline-none transition-colors rounded-t-lg"
                :class="{ 'border-red-500': form.errors.name }"
                placeholder="Misal: Komunitas"
                required
              />
              <span v-if="form.errors.name" class="text-red-500 text-[11px] mt-1">{{ form.errors.name }}</span>
            </div>

            
            <div class="flex flex-col">
              <label for="cat-desc" class="text-[11px] font-bold text-[#1a1c1a] uppercase tracking-wider mb-2">Deskripsi</label>
              <textarea 
                id="cat-desc" 
                v-model="form.description"
                rows="3"
                class="bg-[#FAF9F6] border-b border-[#d1c5b5] focus:border-[#765a27] py-3 px-4 text-[14px] outline-none transition-colors rounded-t-lg resize-none"
                :class="{ 'border-red-500': form.errors.description }"
                placeholder="Penjelasan singkat mengenai kategori ini..."
              ></textarea>
              <span v-if="form.errors.description" class="text-red-500 text-[11px] mt-1">{{ form.errors.description }}</span>
            </div>

            
            <div class="flex justify-end gap-3.5 pt-4">
              <button 
                type="button" 
                @click="closeFormModal"
                class="border border-[#d1c5b5] text-[#605e58] hover:bg-black/5 px-5 py-2.5 rounded-lg text-[13px] font-semibold uppercase tracking-wider transition-colors"
              >
                Batal
              </button>
              <button 
                type="submit" 
                :disabled="form.processing"
                class="bg-[#765a27] text-white hover:bg-[#b5935b] disabled:bg-gray-400 px-5 py-2.5 rounded-lg text-[13px] font-semibold uppercase tracking-wider transition-colors shadow-sm"
              >
                {{ form.processing ? 'Menyimpan...' : 'Simpan' }}
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
          <h3 class="font-serif text-[22px] text-[#1a1c1a] font-bold mb-2">Hapus Kategori?</h3>
          <p class="text-[#605e58] text-[13.5px] leading-relaxed mb-8">
            Apakah Anda yakin ingin menghapus kategori <strong>{{ activeCat?.name }}</strong>? Tindakan ini tidak dapat dibatalkan.
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
              @click="deleteCategory"
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
import { Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

defineProps({
  categories: Object,
});

const showFormModal = ref(false);
const showDeleteModal = ref(false);
const isEditMode = ref(false);
const activeCat = ref(null);

const form = useForm({
  name: '',
  description: '',
});

const openAddModal = () => {
  isEditMode.value = false;
  activeCat.value = null;
  form.reset();
  form.clearErrors();
  showFormModal.value = true;
};

const openEditModal = (cat) => {
  isEditMode.value = true;
  activeCat.value = cat;
  form.name = cat.name;
  form.description = cat.description || '';
  form.clearErrors();
  showFormModal.value = true;
};

const closeFormModal = () => {
  showFormModal.value = false;
  form.reset();
};

const submitForm = () => {
  if (isEditMode.value && activeCat.value) {
    form.put(`/admin/kategori/${activeCat.value.id}`, {
      onSuccess: () => closeFormModal(),
    });
  } else {
    form.post('/admin/kategori', {
      onSuccess: () => closeFormModal(),
    });
  }
};

const confirmDelete = (cat) => {
  activeCat.value = cat;
  showDeleteModal.value = true;
};

const deleteCategory = () => {
  if (!activeCat.value) return;
  
  
  form.delete(`/admin/kategori/${activeCat.value.id}`, {
    onSuccess: () => {
      showDeleteModal.value = false;
      activeCat.value = null;
    },
    onError: () => {
      showDeleteModal.value = false;
    }
  });
};
</script>
