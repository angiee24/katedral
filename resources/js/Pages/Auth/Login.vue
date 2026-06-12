<template>
  <div class="bg-background min-h-screen flex items-center justify-center font-body-md text-body-md text-on-background antialiased relative overflow-hidden">
    
    <div class="absolute inset-0 pointer-events-none overflow-hidden flex items-center justify-center opacity-30">
      <div class="w-[800px] h-[800px] rounded-full border border-outline-variant/20 absolute"></div>
      <div class="w-[600px] h-[600px] rounded-full border border-outline-variant/30 absolute"></div>
      <div class="w-[400px] h-[400px] rounded-full border border-outline-variant/40 absolute"></div>
    </div>
    
    
    <main class="w-full max-w-md px-margin-mobile md:px-0 relative z-10 text-left">
      <div class="glass-panel diffused-shadow rounded-xl p-stack-md flex flex-col gap-stack-md">
        
        <header class="text-center flex flex-col items-center gap-unit">
          <span class="material-symbols-outlined text-primary text-4xl">church</span>
          <h1 class="font-display-lg text-headline-md text-primary mt-4">Katedral Samarinda</h1>
          <p class="font-body-md text-body-md text-on-surface-variant">Portal Administrasi Sistem</p>
        </header>

        
        <form @submit.prevent="submitForm" class="flex flex-col gap-gutter">
          
          <div class="flex flex-col gap-2">
            <label class="font-label-md text-label-md text-on-surface-variant uppercase tracking-widest" for="username">Nama Pengguna</label>
            <div class="relative">
              <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline">person</span>
              <input 
                class="w-full bg-[#f4f3f1] border-0 border-b border-primary/30 rounded-t pl-12 pr-4 py-3 text-on-background focus:ring-0 focus:border-primary focus:bg-[#efeeeb] transition-colors duration-300 placeholder:text-outline-variant outline-none font-body-md text-body-md" 
                id="username" 
                v-model="form.username"
                placeholder="Masukkan ID Admin" 
                required 
                type="email"
                autofocus
              />
            </div>
            <span v-if="form.errors.username" class="text-error text-[11px] mt-1">{{ form.errors.username }}</span>
          </div>

          
          <div class="flex flex-col gap-2">
            <label class="font-label-md text-label-md text-on-surface-variant uppercase tracking-widest" for="password">Kata Sandi</label>
            <div class="relative">
              <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline">lock</span>
              <input 
                class="w-full bg-[#f4f3f1] border-0 border-b border-primary/30 rounded-t pl-12 pr-12 py-3 text-on-background focus:ring-0 focus:border-primary focus:bg-[#efeeeb] transition-colors duration-300 placeholder:text-outline-variant outline-none font-body-md text-body-md" 
                id="password" 
                v-model="form.password"
                placeholder="••••••••" 
                required 
                :type="showPassword ? 'text' : 'password'"
              />
              <button 
                aria-label="Tampilkan kata sandi" 
                class="absolute right-4 top-1/2 -translate-y-1/2 text-outline hover:text-primary transition-colors cursor-pointer" 
                @click="showPassword = !showPassword"
                type="button"
              >
                <span class="material-symbols-outlined">{{ showPassword ? 'visibility_off' : 'visibility' }}</span>
              </button>
            </div>
            <span v-if="form.errors.password" class="text-error text-[11px] mt-1">{{ form.errors.password }}</span>
          </div>

          
          <div class="flex items-center justify-between mt-2">
            <label class="flex items-center gap-2 cursor-pointer group">
              <input 
                class="w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary/50 focus:ring-offset-background bg-transparent checked:bg-primary transition-all cursor-pointer" 
                type="checkbox"
                v-model="form.remember"
              />
              <span class="font-caption text-caption text-on-surface-variant group-hover:text-on-background transition-colors">Ingat Saya</span>
            </label>
            <a class="font-caption text-caption text-primary hover:text-on-primary-fixed-variant transition-colors" href="#">Lupa Kata Sandi?</a>
          </div>

          
          <button 
            class="w-full bg-primary text-on-primary rounded-lg py-4 font-label-md text-label-md uppercase tracking-wider hover:bg-primary-container hover:text-on-primary transition-all duration-300 mt-4 flex justify-center items-center gap-2 group shadow-sm disabled:opacity-50 disabled:cursor-not-allowed" 
            type="submit"
            :disabled="form.processing"
          >
            <span>{{ form.processing ? 'Masuk...' : 'Masuk' }}</span>
            <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">arrow_forward</span>
          </button>
        </form>

        
        <div class="text-center mt-4">
          <p class="font-caption text-caption text-outline">
            Akses terbatas untuk petugas terdaftar.<br/>
            <span class="opacity-70 mt-1 block">Silakan hubungi administrator paroki jika menemui kendala.</span>
          </p>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

const showPassword = ref(false);

const form = useForm({
  username: '',
  password: '',
  remember: false,
});

const submitForm = () => {
  form.post('/login', {
    onFinish: () => form.reset('password'),
  });
};
</script>
