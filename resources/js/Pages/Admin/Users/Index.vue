<template>
  <AdminLayout title="Kelola Pengguna Sistem">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
      <p class="text-[13.5px] text-[#605e58]">Kelola administrator, editor, dan penulis warta beserta penetapan peran/hak akses masing-masing.</p>
      
      <button 
        type="button"
        @click="openAddModal"
        class="bg-[#765a27] text-white hover:bg-[#60491f] px-5 py-3 rounded-lg text-[12px] font-semibold uppercase tracking-wider transition-all shadow flex items-center gap-1.5 self-start md:self-auto"
      >
        <span class="material-symbols-outlined text-[16px]">person_add</span>
        <span>Tambah Pengguna</span>
      </button>
    </div>

    
    <div class="bg-white rounded-xl border border-[#d1c5b5]/30 shadow-sm overflow-hidden mb-8">
      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-[13px]">
          <thead>
            <tr class="bg-[#FAF9F6] border-b border-[#d1c5b5]/20 text-[#605e58]">
              <th class="py-4 px-6 font-semibold uppercase tracking-wider text-[11px] w-12">Avatar</th>
              <th class="py-4 px-6 font-semibold uppercase tracking-wider text-[11px]">Nama Lengkap</th>
              <th class="py-4 px-6 font-semibold uppercase tracking-wider text-[11px]">Surel (Email)</th>
              <th class="py-4 px-6 font-semibold uppercase tracking-wider text-[11px]">Peran / Role</th>
              <th class="py-4 px-6 font-semibold uppercase tracking-wider text-[11px] text-right">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-[#d1c5b5]/10">
            <tr 
              v-for="user in users.data" 
              :key="user.id"
              class="hover:bg-[#FAF9F6]/40 transition-colors"
            >
              
              <td class="py-4 px-6">
                <div class="w-9 h-9 rounded-full bg-[#765a27]/10 text-[#765a27] flex items-center justify-center font-bold text-[12px] uppercase">
                  {{ getAvatarInitials(user.name) }}
                </div>
              </td>
              
              
              <td class="py-4 px-6 font-bold text-[#1a1c1a]">
                {{ user.name }}
                <span 
                  v-if="user.id === $page.props.auth.user.id"
                  class="ml-2 bg-[#FAF9F6] border border-[#d1c5b5]/40 text-[#765a27] text-[10px] px-1.5 py-0.5 rounded font-normal"
                >
                  Anda
                </span>
              </td>

              
              <td class="py-4 px-6 text-[#605e58] font-medium">
                {{ user.email }}
              </td>

              
              <td class="py-4 px-6">
                <span 
                  class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider border"
                  :class="getRoleBadgeClasses(user.roles[0]?.name)"
                >
                  {{ user.roles[0]?.name || 'Guest' }}
                </span>
              </td>

              
              <td class="py-4 px-6 text-right space-x-1.5 whitespace-nowrap">
                <button 
                  @click="openEditModal(user)"
                  class="inline-flex items-center justify-center w-8 h-8 rounded-full border border-[#d1c5b5] hover:border-[#765a27] text-[#605e58] hover:text-[#765a27] transition-all bg-white shadow-sm"
                  title="Sunting Pengguna"
                >
                  <span class="material-symbols-outlined text-[16px]">edit</span>
                </button>
                <button 
                  @click="openResetPasswordModal(user)"
                  class="inline-flex items-center justify-center w-8 h-8 rounded-full border border-[#d1c5b5] hover:border-[#765a27] text-[#605e58] hover:text-[#765a27] transition-all bg-white shadow-sm"
                  title="Reset Sandi"
                >
                  <span class="material-symbols-outlined text-[16px]">lock_reset</span>
                </button>
                <button 
                  @click="confirmDelete(user)"
                  :disabled="user.id === $page.props.auth.user.id"
                  class="inline-flex items-center justify-center w-8 h-8 rounded-full border border-red-200 hover:border-red-500 text-red-500 hover:bg-red-50 disabled:opacity-30 disabled:cursor-not-allowed transition-all bg-white shadow-sm"
                  title="Hapus Pengguna"
                >
                  <span class="material-symbols-outlined text-[16px]">delete</span>
                </button>
              </td>
            </tr>
            
            <tr v-if="users.data.length === 0">
              <td colspan="5" class="py-12 px-6 text-center text-[#605e58]">
                Belum ada pengguna sistem yang terdaftar.
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      
      <div class="bg-[#FAF9F6] border-t border-[#d1c5b5]/20 py-4 px-6 flex justify-center items-center" v-if="users.links && users.links.length > 3">
        <div class="flex gap-2">
          <template v-for="(link, i) in users.links" :key="i">
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
        <div class="relative max-w-md w-full bg-white rounded-2xl overflow-hidden shadow-2xl flex flex-col border border-[#d1c5b5]/30">
          
          <div class="p-6 border-b border-[#d1c5b5]/20 flex items-center justify-between bg-[#FAF9F6]">
            <h3 class="font-serif text-[20px] text-[#1a1c1a] font-bold">
              {{ isEditing ? 'Sunting Pengguna' : 'Tambah Pengguna' }}
            </h3>
            <button @click="closeModal" class="text-[#605e58] hover:text-[#1a1c1a]">
              <span class="material-symbols-outlined text-[24px]">close</span>
            </button>
          </div>

          
          <form @submit.prevent="submitForm" class="p-6 flex flex-col gap-4">
            
            <div>
              <label class="block text-[11.5px] font-bold text-[#605e58] uppercase tracking-widest mb-1.5">Nama Lengkap *</label>
              <input 
                type="text" 
                v-model="form.name"
                placeholder="Masukkan nama pengguna..."
                class="w-full bg-white border border-[#d1c5b5] focus:border-[#765a27] rounded-lg px-3.5 py-2.5 text-[13px] outline-none transition-colors"
                :class="{ 'border-red-500': form.errors.name }"
              />
              <span v-if="form.errors.name" class="text-red-500 text-[11px] mt-1 block">{{ form.errors.name }}</span>
            </div>

            
            <div>
              <label class="block text-[11.5px] font-bold text-[#605e58] uppercase tracking-widest mb-1.5">Alamat Surel (Email) *</label>
              <input 
                type="email" 
                v-model="form.email"
                placeholder="email@katedralsamarinda.org"
                class="w-full bg-white border border-[#d1c5b5] focus:border-[#765a27] rounded-lg px-3.5 py-2.5 text-[13px] outline-none transition-colors"
                :class="{ 'border-red-500': form.errors.email }"
              />
              <span v-if="form.errors.email" class="text-red-500 text-[11px] mt-1 block">{{ form.errors.email }}</span>
            </div>

            
            <div v-if="!isEditing" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-[11.5px] font-bold text-[#605e58] uppercase tracking-widest mb-1.5">Kata Sandi *</label>
                <input 
                  type="password" 
                  v-model="form.password"
                  placeholder="Min. 8 karakter"
                  class="w-full bg-white border border-[#d1c5b5] focus:border-[#765a27] rounded-lg px-3.5 py-2.5 text-[13px] outline-none transition-colors"
                  :class="{ 'border-red-500': form.errors.password }"
                />
              </div>
              <div>
                <label class="block text-[11.5px] font-bold text-[#605e58] uppercase tracking-widest mb-1.5">Konfirmasi Sandi *</label>
                <input 
                  type="password" 
                  v-model="form.password_confirmation"
                  placeholder="Ketik ulang sandi"
                  class="w-full bg-white border border-[#d1c5b5] focus:border-[#765a27] rounded-lg px-3.5 py-2.5 text-[13px] outline-none transition-colors"
                />
              </div>
              <span v-if="form.errors.password" class="text-red-500 text-[11px] col-span-2 block">{{ form.errors.password }}</span>
            </div>

            
            <div>
              <label class="block text-[11.5px] font-bold text-[#605e58] uppercase tracking-widest mb-1.5">Peran Pengguna *</label>
              <select 
                v-model="form.role_id"
                class="w-full bg-white border border-[#d1c5b5] focus:border-[#765a27] rounded-lg px-3.5 py-2.5 text-[13px] outline-none transition-colors"
                :class="{ 'border-red-500': form.errors.role_id }"
              >
                <option value="">Pilih Peran...</option>
                <option 
                  v-for="role in roles" 
                  :key="role.id" 
                  :value="role.id"
                >
                  {{ role.name }}
                </option>
              </select>
              <span v-if="form.errors.role_id" class="text-red-500 text-[11px] mt-1 block">{{ form.errors.role_id }}</span>
            </div>

            
            <div v-if="isEditing && activeUser?.id === $page.props.auth.user.id" class="bg-amber-50 text-amber-800 text-[12px] p-3 rounded-lg border border-amber-200">
              Perhatian: Anda sedang mengubah akun Anda sendiri.
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
        v-if="showResetModal" 
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
        @click.self="showResetModal = false"
      >
        <div class="relative max-w-md w-full bg-white rounded-2xl overflow-hidden shadow-2xl flex flex-col border border-[#d1c5b5]/30">
          <div class="p-6 border-b border-[#d1c5b5]/20 flex items-center justify-between bg-[#FAF9F6]">
            <h3 class="font-serif text-[20px] text-[#1a1c1a] font-bold">Reset Kata Sandi</h3>
            <button @click="showResetModal = false" class="text-[#605e58] hover:text-[#1a1c1a]">
              <span class="material-symbols-outlined text-[24px]">close</span>
            </button>
          </div>

          <form @submit.prevent="submitResetPassword" class="p-6 flex flex-col gap-4">
            <p class="text-[12.5px] text-[#605e58]">Mereset kata sandi untuk pengguna <strong>{{ activeUser?.name }}</strong>.</p>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-[11.5px] font-bold text-[#605e58] uppercase tracking-widest mb-1.5">Sandi Baru *</label>
                <input 
                  type="password" 
                  v-model="resetForm.password"
                  placeholder="Min. 8 karakter"
                  class="w-full bg-white border border-[#d1c5b5] focus:border-[#765a27] rounded-lg px-3.5 py-2.5 text-[13px] outline-none transition-colors"
                  :class="{ 'border-red-500': resetForm.errors.password }"
                />
              </div>
              <div>
                <label class="block text-[11.5px] font-bold text-[#605e58] uppercase tracking-widest mb-1.5">Konfirmasi *</label>
                <input 
                  type="password" 
                  v-model="resetForm.password_confirmation"
                  placeholder="Ulangi sandi"
                  class="w-full bg-white border border-[#d1c5b5] focus:border-[#765a27] rounded-lg px-3.5 py-2.5 text-[13px] outline-none transition-colors"
                />
              </div>
              <span v-if="resetForm.errors.password" class="text-red-500 text-[11px] col-span-2 block">{{ resetForm.errors.password }}</span>
            </div>

            <div class="flex justify-end gap-3 border-t border-[#d1c5b5]/20 pt-5 mt-2">
              <button 
                type="button" 
                @click="showResetModal = false"
                class="border border-[#d1c5b5] text-[#605e58] hover:bg-black/5 px-4.5 py-2 rounded-lg text-[12px] font-semibold uppercase tracking-wider transition-colors"
              >
                Batal
              </button>
              <button 
                type="submit" 
                :disabled="resetForm.processing"
                class="bg-[#765a27] text-white hover:bg-[#60491f] disabled:bg-gray-300 disabled:cursor-not-allowed px-5 py-2 rounded-lg text-[12px] font-semibold uppercase tracking-wider transition-all shadow flex items-center gap-1"
              >
                <span class="material-symbols-outlined text-[16px]">{{ resetForm.processing ? 'sync' : 'lock_open' }}</span>
                <span>Reset Sandi</span>
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
          <h3 class="font-serif text-[22px] text-[#1a1c1a] font-bold mb-2">Hapus Akun Pengguna?</h3>
          <p class="text-[#605e58] text-[13.5px] leading-relaxed mb-8">
            Apakah Anda yakin ingin menghapus akun pengguna <strong>{{ activeUser?.name }}</strong>? Tindakan ini akan menghapusnya secara permanen.
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
              @click="deleteUser"
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

const props = defineProps({
  users: Object,
  roles: Array,
});

const showModal = ref(false);
const isEditing = ref(false);
const showResetModal = ref(false);
const showDeleteModal = ref(false);
const activeUser = ref(null);

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
  role_id: '',
});

const resetForm = useForm({
  password: '',
  password_confirmation: '',
});

const getAvatarInitials = (name) => {
  if (!name) return 'U';
  return name.trim().split(' ').map(n => n[0]).slice(0, 2).join('');
};

const getRoleBadgeClasses = (roleName) => {
  if (roleName === 'admin') return 'bg-[#765a27]/10 text-[#765a27] border border-[#765a27]/20';
  if (roleName === 'editor') return 'bg-blue-50 text-blue-700 border-blue-200';
  if (roleName === 'author') return 'bg-green-50 text-green-700 border-green-200';
  return 'bg-gray-50 text-gray-600 border-gray-200'; 
};

const openAddModal = () => {
  isEditing.value = false;
  form.reset();
  form.clearErrors();
  showModal.value = true;
};

const openEditModal = (user) => {
  isEditing.value = true;
  activeUser.value = user;
  
  form.name = user.name;
  form.email = user.email;
  form.role_id = user.roles[0]?.id || '';
  
  form.clearErrors();
  showModal.value = true;
};

const closeModal = () => {
  showModal.value = false;
  activeUser.value = null;
};

const submitForm = () => {
  if (isEditing.value) {
    form.put(`/admin/users/${activeUser.value.id}`, {
      onSuccess: () => {
        closeModal();
      }
    });
  } else {
    form.post('/admin/users', {
      onSuccess: () => {
        closeModal();
      }
    });
  }
};

const openResetPasswordModal = (user) => {
  activeUser.value = user;
  resetForm.reset();
  resetForm.clearErrors();
  showResetModal.value = true;
};

const submitResetPassword = () => {
  resetForm.post(`/admin/users/${activeUser.value.id}/reset-password`, {
    onSuccess: () => {
      showResetModal.value = false;
      activeUser.value = null;
    }
  });
};

const confirmDelete = (user) => {
  activeUser.value = user;
  showDeleteModal.value = true;
};

const deleteForm = useForm({});

const deleteUser = () => {
  if (!activeUser.value) return;

  deleteForm.delete(`/admin/users/${activeUser.value.id}`, {
    onSuccess: () => {
      showDeleteModal.value = false;
      activeUser.value = null;
    },
    onError: () => {
      showDeleteModal.value = false;
    }
  });
};
</script>
