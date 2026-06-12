<template>
  <AppLayout>
    <div class="pt-14 pb-stack-lg px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto w-full">
      <div class="text-center mb-stack-lg max-w-2xl mx-auto fade-in-section">
        <h1 class="font-display-lg text-display-lg text-on-background mb-4">Hubungi Kami</h1>
        <p class="font-body-lg text-body-lg text-on-surface-variant">
          Kami menyambut dengan hangat setiap pertanyaan, doa, atau niat baik Anda. Silakan hubungi sekretariat paroki melalui informasi di bawah ini.
        </p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-12 gap-gutter text-left fade-in-section">
        
        <div class="col-span-1 md:col-span-5 flex flex-col gap-stack-md">
          <div class="card-champagne flex flex-col gap-6">
            <div>
              <h3 class="font-headline-md text-headline-md text-on-background mb-2">Sekretariat Paroki</h3>
              <p class="font-body-md text-body-md text-on-surface-variant flex items-start gap-2">
                <span class="material-symbols-outlined text-primary mt-1" style="font-variation-settings: 'FILL' 1; font-size: 20px;">location_on</span>
                <span>{{ address || settings.church_address || 'Jl. Jend. Sudirman No.1, Bugis, Kec. Samarinda Kota, Kota Samarinda, Kalimantan Timur 75242' }}</span>
              </p>
            </div>
            
            <div class="h-[0.5px] bg-on-background/10 w-full"></div>
            
            <div>
              <h4 class="font-label-md text-label-md text-on-surface-variant uppercase mb-2 tracking-wider">Jam Pelayanan</h4>
              <ul class="font-body-md text-body-md text-on-background space-y-2">
                <li class="flex justify-between">
                  <span>Senin - Jumat</span> 
                  <span>{{ monFri || settings.church_work_hours_mon_fri || '08:00 - 16:00' }}</span>
                </li>
                <li class="flex justify-between">
                  <span>Sabtu</span> 
                  <span>{{ sat || settings.church_work_hours_sat || '08:00 - 13:00' }}</span>
                </li>
                <li class="flex justify-between text-secondary">
                  <span>Minggu</span> 
                  <span>{{ sun || settings.church_work_hours_sun || 'Tutup' }}</span>
                </li>
              </ul>
            </div>
            
            <div class="h-[0.5px] bg-on-background/10 w-full"></div>
            
            <div class="flex flex-col gap-3">
              <a :href="`tel:${settings.church_phone}`" class="flex items-center gap-3 text-on-background hover:text-primary transition-colors">
                <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 0;">call</span>
                <span class="font-body-md text-body-md">{{ phone || settings.church_phone || '(0541) 123456' }}</span>
              </a>
              <a :href="`mailto:${settings.church_email}`" class="flex items-center gap-3 text-on-background hover:text-primary transition-colors">
                <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 0;">mail</span>
                <span class="font-body-md text-body-md">{{ email || settings.church_email || 'sekretariat@katedralsamarinda.org' }}</span>
              </a>
            </div>
          </div>
          
          
          <a 
            v-if="mapsUrl || mapsLink"
            :href="mapsLink || '#'"
            target="_blank"
            rel="noopener noreferrer"
            class="block w-full h-64 bg-surface-container-high rounded-xl overflow-hidden relative shadow-[0_4px_20px_rgba(45,45,45,0.04)] group"
          >
            <iframe 
              v-if="mapsUrl"
              :src="mapsUrl" 
              class="w-full h-full border-none pointer-events-none" 
              allowfullscreen="" 
              loading="lazy" 
              referrerpolicy="no-referrer-when-downgrade"
            ></iframe>
            
            <div class="absolute inset-0 bg-on-background/0 group-hover:bg-on-background/20 transition-all duration-300 flex items-center justify-center">
              <span class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-primary text-on-primary font-label-md text-label-md px-4 py-2 rounded-lg flex items-center gap-2 shadow-lg">
                <span class="material-symbols-outlined text-sm">open_in_new</span>
                Buka di Google Maps
              </span>
            </div>
          </a>
        </div>

        
        <div class="col-span-1 md:col-span-7">
          <div class="bg-surface rounded-xl p-8 md:p-12 shadow-[0_4px_20px_rgba(45,45,45,0.04)] h-full">
            <h2 class="font-headline-md text-headline-md text-on-background mb-8">Kirim Pesan</h2>
            <form @submit.prevent="submit" class="flex flex-col gap-6">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label class="sr-only" for="name">Nama Lengkap</label>
                  <input 
                    class="form-input-elegant font-body-md text-body-md text-on-background placeholder:text-on-surface-variant/60" 
                    id="name" 
                    v-model="form.name"
                    placeholder="Nama Lengkap" 
                    type="text"
                    required
                  />
                  <span v-if="form.errors.name" class="text-error text-[11px] mt-1 block">{{ form.errors.name }}</span>
                </div>
                <div>
                  <label class="sr-only" for="email">Alamat Email</label>
                  <input 
                    class="form-input-elegant font-body-md text-body-md text-on-background placeholder:text-on-surface-variant/60" 
                    id="email" 
                    v-model="form.email"
                    placeholder="Alamat Email" 
                    type="email"
                    required
                  />
                  <span v-if="form.errors.email" class="text-error text-[11px] mt-1 block">{{ form.errors.email }}</span>
                </div>
              </div>
              
              <div>
                <label class="sr-only" for="subject">Subjek</label>
                <select 
                  id="subject"
                  v-model="form.subject"
                  class="form-input-elegant font-body-md text-body-md text-on-background placeholder:text-on-surface-variant/60 appearance-none bg-no-repeat bg-right pr-10"
                  style="background-image: url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 width=%2224%22 height=%2224%22 fill=%22none%22 stroke=%22%23765a27%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22><polyline points=%226 9 12 15 18 9%22/></svg>'); background-position: right 1rem center; background-size: 1.2em;"
                  required
                >
                  <option disabled value="">Pilih Subjek</option>
                  <option value="Pertanyaan Umum">Pertanyaan Umum</option>
                  <option value="Pendaftaran Baptis">Pendaftaran Baptis</option>
                  <option value="Pendaftaran Pernikahan">Pendaftaran Pernikahan</option>
                  <option value="Lainnya">Lainnya</option>
                </select>
                <span v-if="form.errors.subject" class="text-error text-[11px] mt-1 block">{{ form.errors.subject }}</span>
              </div>
              
              <div>
                <label class="sr-only" for="message">Pesan</label>
                <textarea 
                  class="form-input-elegant font-body-md text-body-md text-on-background placeholder:text-on-surface-variant/60 resize-none" 
                  id="message" 
                  v-model="form.message"
                  placeholder="Tulis pesan Anda di sini..." 
                  rows="5"
                  required
                ></textarea>
                <span v-if="form.errors.message" class="text-error text-[11px] mt-1 block">{{ form.errors.message }}</span>
              </div>
              
              <div class="mt-4 flex justify-end">
                <button 
                  class="bg-primary text-on-primary font-label-md text-label-md px-6 py-3 rounded-lg flex items-center gap-2 smooth-btn cursor-pointer shadow-sm disabled:opacity-50" 
                  type="submit"
                  :disabled="form.processing"
                >
                  <span>{{ form.processing ? 'Mengirim...' : 'Kirim Pesan' }}</span>
                  <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 0;">send</span>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { computed, onMounted } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import AppLayout from '@/Layouts/AppLayout.vue';

gsap.registerPlugin(ScrollTrigger);

onMounted(() => {
  gsap.utils.toArray('.fade-in-section').forEach((el) => {
    gsap.fromTo(el,
      { y: 30, opacity: 0 },
      {
        y: 0,
        opacity: 1,
        duration: 0.8,
        ease: 'power2.out',
        scrollTrigger: {
          trigger: el,
          start: 'top 85%',
          toggleActions: 'play none none none',
        }
      }
    );
  });
});

const props = defineProps({
  address: String,
  phone: String,
  email: String,
  monFri: String,
  sat: String,
  sun: String,
  mapsUrl: String,
  mapsLink: String,
});

const page = usePage();
const settings = computed(() => page.props.settings || {});

const form = useForm({
  name: '',
  email: '',
  subject: '',
  message: '',
});

const submit = () => {
  form.post('/kontak', {
    onSuccess: () => {
      form.reset();
    }
  });
};
</script>
