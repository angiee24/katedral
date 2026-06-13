<template>
  <AdminLayout title="Sunting Warta">
    <div class="max-w-4xl mx-auto">
      
      <div class="mb-6">
        <Link 
          href="/admin/berita"
          class="inline-flex items-center gap-1.5 text-[#605e58] hover:text-[#765a27] text-[13px] font-semibold transition-colors"
        >
          <span class="material-symbols-outlined text-[16px]">arrow_back</span>
          <span>Kembali ke Daftar Warta</span>
        </Link>
      </div>

      
      <form @submit.prevent="submit" class="bg-white rounded-xl border border-[#d1c5b5]/30 shadow-sm p-8 flex flex-col gap-6">
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div class="md:col-span-2">
            <label class="block text-[12px] font-bold text-[#605e58] uppercase tracking-widest mb-2">Judul Warta *</label>
            <input 
              type="text" 
              v-model="form.title"
              placeholder="Masukkan judul warta..."
              class="w-full bg-white border border-[#d1c5b5] focus:border-[#765a27] rounded-lg px-4 py-3 text-[13px] outline-none transition-colors shadow-sm"
              :class="{ 'border-red-500': form.errors.title }"
            />
            <span v-if="form.errors.title" class="text-red-500 text-[11px] mt-1 block">{{ form.errors.title }}</span>
          </div>

          <div>
            <label class="block text-[12px] font-bold text-[#605e58] uppercase tracking-widest mb-2">Pilihan Warta</label>
            <div class="flex items-center h-[46px] border border-[#d1c5b5]/50 rounded-lg px-4 bg-[#FAF9F6]/40">
              <label class="inline-flex items-center gap-2.5 cursor-pointer">
                <input 
                  type="checkbox" 
                  v-model="form.is_featured"
                  class="rounded border-[#d1c5b5] text-[#765a27] focus:ring-[#765a27] h-4.5 w-4.5 cursor-pointer"
                />
                <span class="text-[13px] text-[#1a1c1a] font-semibold">Warta Unggulan</span>
              </label>
            </div>
          </div>
        </div>

        
        <div>
          <label class="block text-[12px] font-bold text-[#605e58] uppercase tracking-widest mb-2">Kutipan Singkat (Excerpt)</label>
          <textarea 
            v-model="form.excerpt"
            rows="2"
            placeholder="Tulis ringkasan warta (maksimal 300 karakter)..."
            class="w-full bg-white border border-[#d1c5b5] focus:border-[#765a27] rounded-lg px-4 py-3 text-[13px] outline-none transition-colors shadow-sm resize-none"
            :class="{ 'border-red-500': form.errors.excerpt }"
          ></textarea>
          <span v-if="form.errors.excerpt" class="text-red-500 text-[11px] mt-1 block">{{ form.errors.excerpt }}</span>
        </div>

        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          
          <div>
            <label class="block text-[12px] font-bold text-[#605e58] uppercase tracking-widest mb-2">Kategori *</label>
            <select 
              v-model="form.category_id"
              class="w-full bg-white border border-[#d1c5b5] focus:border-[#765a27] rounded-lg px-4 py-3 text-[13px] outline-none transition-colors shadow-sm h-[46px]"
              :class="{ 'border-red-500': form.errors.category_id }"
            >
              <option value="">Pilih Kategori...</option>
              <option 
                v-for="cat in categories" 
                :key="cat.id" 
                :value="cat.id"
              >
                {{ cat.name }}
              </option>
            </select>
            <span v-if="form.errors.category_id" class="text-red-500 text-[11px] mt-1 block">{{ form.errors.category_id }}</span>
          </div>

          
          <div class="md:col-span-2">
            <label class="block text-[12px] font-bold text-[#605e58] uppercase tracking-widest mb-2">Gambar Sampul (Cover Image)</label>
            <div class="flex items-center gap-4 border border-[#d1c5b5] rounded-lg p-2.5 bg-[#FAF9F6]/20">
              <div class="w-16 h-16 rounded-lg bg-[#FAF9F6] border border-[#d1c5b5]/30 overflow-hidden flex items-center justify-center flex-shrink-0">
                <img 
                  v-if="selectedImage" 
                  :src="selectedImage.url" 
                  class="w-full h-full object-cover"
                />
                <span class="material-symbols-outlined text-[#d1c5b5] text-[32px]" v-else>image</span>
              </div>
              <div class="flex-grow">
                <p class="text-[12.5px] font-semibold text-[#1a1c1a] truncate" v-if="selectedImage">
                  {{ selectedImage.filename }}
                </p>
                <p class="text-[11.5px] text-[#605e58]" v-else>Belum ada gambar yang dipilih</p>
                <button 
                  type="button" 
                  @click="showMediaSelector = true"
                  class="text-[#765a27] hover:text-[#60491f] text-[12px] font-bold mt-1 inline-flex items-center gap-1"
                >
                  <span class="material-symbols-outlined text-[14px]">photo_library</span>
                  <span>{{ selectedImage ? 'Ubah Gambar' : 'Pilih Gambar' }}</span>
                </button>
              </div>
              <button 
                v-if="selectedImage"
                type="button" 
                @click="removeImage"
                class="text-[#ba1a1a] hover:text-[#93000a] text-sm p-2"
                title="Hapus gambar terpilih"
              >
                <span class="material-symbols-outlined text-[20px]">close</span>
              </button>
            </div>
          </div>
        </div>

        
        <div v-if="tags.length > 0">
          <label class="block text-[12px] font-bold text-[#605e58] uppercase tracking-widest mb-2">Label / Tags</label>
          <div class="flex flex-wrap gap-3 p-4 border border-[#d1c5b5]/30 rounded-lg bg-[#FAF9F6]/10">
            <label 
              v-for="tag in tags" 
              :key="tag.id"
              class="inline-flex items-center gap-2 border border-[#d1c5b5]/30 bg-white hover:border-[#765a27] rounded-lg px-3 py-1.5 cursor-pointer text-[12px] transition-colors"
            >
              <input 
                type="checkbox" 
                v-model="form.tags"
                :value="tag.id"
                class="rounded border-[#d1c5b5] text-[#765a27] focus:ring-[#765a27] h-4 w-4 cursor-pointer"
              />
              <span class="text-[#1a1c1a] font-medium">{{ tag.name }}</span>
            </label>
          </div>
        </div>

        
        <div>
          <label class="block text-[12px] font-bold text-[#605e58] uppercase tracking-widest mb-2">Isi Berita *</label>
          <div class="border border-[#d1c5b5] rounded-lg overflow-hidden shadow-sm">
            <textarea 
              v-model="form.content"
              rows="12"
              placeholder="Tulis detail isi warta di sini..."
              class="w-full bg-white px-4 py-3.5 text-[13px] outline-none resize-y"
              :class="{ 'border-red-500': form.errors.content }"
            ></textarea>
          </div>
          <span v-if="form.errors.content" class="text-red-500 text-[11px] mt-1 block">{{ form.errors.content }}</span>
        </div>

        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6 border border-[#d1c5b5]/30 rounded-lg bg-[#FAF9F6]/20">
          <div>
            <label class="block text-[12px] font-bold text-[#605e58] uppercase tracking-widest mb-2">Status Publikasi</label>
            <select 
              v-model="form.status"
              class="w-full bg-white border border-[#d1c5b5] focus:border-[#765a27] rounded-lg px-4 py-3 text-[13px] outline-none transition-colors shadow-sm h-[46px]"
            >
              <option value="draft">Draf</option>
              <option value="published">Diterbitkan Langsung</option>
              <option value="scheduled">Dijadwalkan</option>
            </select>
          </div>

          <div v-if="form.status === 'scheduled'">
            <label class="block text-[12px] font-bold text-[#605e58] uppercase tracking-widest mb-2">Waktu Terbit Terjadwal *</label>
            <input 
              type="datetime-local" 
              v-model="form.published_at"
              class="w-full bg-white border border-[#d1c5b5] focus:border-[#765a27] rounded-lg px-4 py-3 text-[13px] outline-none transition-colors shadow-sm h-[46px]"
              :class="{ 'border-red-500': form.errors.published_at }"
            />
            <span v-if="form.errors.published_at" class="text-red-500 text-[11px] mt-1 block">{{ form.errors.published_at }}</span>
          </div>
        </div>

        
        <div class="flex justify-end gap-4 border-t border-[#d1c5b5]/20 pt-6">
          <Link 
            href="/admin/berita"
            class="border border-[#d1c5b5] text-[#605e58] hover:bg-black/5 px-6 py-3 rounded-lg text-[12px] font-semibold uppercase tracking-wider transition-colors"
          >
            Batal
          </Link>
          <button 
            type="submit" 
            :disabled="form.processing"
            class="bg-[#765a27] text-white hover:bg-[#60491f] disabled:bg-gray-300 disabled:cursor-not-allowed px-6 py-3 rounded-lg text-[12px] font-semibold uppercase tracking-wider transition-all shadow flex items-center gap-1.5"
          >
            <span class="material-symbols-outlined text-[16px]">{{ form.processing ? 'sync' : 'save' }}</span>
            <span>{{ form.processing ? 'Menyimpan...' : 'Simpan Perubahan' }}</span>
          </button>
        </div>
      </form>

      
      <MediaSelector 
        :show="showMediaSelector" 
        :selectedId="form.media_id"
        @close="showMediaSelector = false"
        @select="onImageSelect"
      />
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import MediaSelector from '@/Components/MediaSelector.vue';

const props = defineProps({
  post: Object,
  categories: Array,
  tags: Array,
});

const showMediaSelector = ref(false);
const selectedImage = ref(props.post.media || null);


const formatForDateTimeLocal = (dateStr) => {
  if (!dateStr) return '';
  const date = new Date(dateStr);
  const tzoffset = date.getTimezoneOffset() * 60000; 
  const localISOTime = (new Date(date - tzoffset)).toISOString().slice(0, 16);
  return localISOTime;
};

const form = useForm({
  title: props.post.title || '',
  excerpt: props.post.excerpt || '',
  content: props.post.content || '',
  category_id: props.post.category_id || '',
  media_id: props.post.media_id || null,
  status: props.post.status || 'draft',
  published_at: formatForDateTimeLocal(props.post.published_at),
  is_featured: !!props.post.is_featured,
  tags: props.post.tags ? props.post.tags.map(t => t.id) : [],
});

const onImageSelect = (media) => {
  selectedImage.value = media;
  form.media_id = media.id;
};

const removeImage = () => {
  selectedImage.value = null;
  form.media_id = null;
};

const submit = () => {
  form.transform((data) => ({
    ...data,
    _method: 'PUT',
  })).post(`/admin/berita/${props.post.id}`, {
    onSuccess: () => {
      
    }
  });
};
</script>
