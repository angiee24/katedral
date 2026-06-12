<template>
  <AppLayout>
    <div class="w-full max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop pb-stack-lg pt-8">
      
      <section class="mb-stack-lg pt-stack-md text-center fade-in-section">
        <h1 class="font-display-lg text-display-lg text-on-surface mb-unit">Liturgi &amp; Pelayanan</h1>
        <p class="font-body-lg text-body-lg text-secondary max-w-2xl mx-auto">
          Membangun iman melalui perayaan Ekaristi dan pelayanan sakramen yang khusyuk, menjadi oase rohani bagi umat Katolik di Samarinda.
        </p>
        
        <div class="mt-8 flex justify-center">
          <button 
            @click="showPosterModal = true"
            class="bg-primary text-on-primary font-label-md text-label-md px-6 py-3 rounded-lg uppercase tracking-wider shadow-sm flex items-center gap-2 smooth-btn cursor-pointer"
          >
            <span class="material-symbols-outlined text-[18px]">image</span>
            <span>Lihat Poster Jadwal</span>
          </button>
        </div>
      </section>

      
      <section class="mb-stack-lg fade-in-section">
        <div class="flex items-center justify-between mb-stack-sm border-b border-on-surface/[0.1] pb-unit">
          <h2 class="font-headline-lg text-headline-lg md:font-headline-lg md:text-headline-lg text-on-surface flex items-center gap-2">
            <span class="material-symbols-outlined text-primary">schedule</span>
            Jadwal Misa Mingguan
          </h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-stack-md">
          
          <div class="bg-surface-champagne border border-outline-variant/30 rounded-2xl p-6 md:p-8 diffused-shadow premium-hover-card text-left">
            <h3 class="font-headline-md text-headline-md text-on-surface mb-6 border-b border-outline-variant/30 pb-2">Misa Harian</h3>
            <ul class="space-y-4 font-body-md text-body-md text-on-surface-variant">
              <li 
                v-for="misa in harianMasses" 
                :key="misa.id"
                class="flex justify-between items-center py-2.5 border-b border-outline-variant/20 last:border-none hover:translate-x-1 transition-transform"
              >
                <span class="font-semibold">{{ getMassDayLabel(misa) }}</span>
                <span class="font-bold text-primary">{{ misa.event_time }}</span>
              </li>
              <li v-if="harianMasses.length === 0" class="text-center py-4 text-secondary">
                Belum ada jadwal misa harian.
              </li>
            </ul>
          </div>

          
          <div class="bg-surface-champagne border border-outline-variant/30 rounded-2xl p-6 md:p-8 diffused-shadow premium-hover-card text-left">
            <h3 class="font-headline-md text-headline-md text-on-surface mb-6 border-b border-outline-variant/30 pb-2">Misa Akhir Pekan</h3>
            <ul class="space-y-4 font-body-md text-body-md text-on-surface-variant">
              <li 
                v-for="misa in akhirPekanMasses" 
                :key="misa.id"
                class="flex justify-between items-center py-2.5 border-b border-outline-variant/20 last:border-none hover:translate-x-1 transition-transform"
              >
                <span class="font-semibold">{{ getMassDayLabel(misa) }}</span>
                <span class="font-bold text-primary">{{ misa.event_time }}</span>
              </li>
              <li v-if="akhirPekanMasses.length === 0" class="text-center py-4 text-secondary">
                Belum ada jadwal misa akhir pekan.
              </li>
            </ul>
          </div>
        </div>
      </section>

      
      <section class="grid grid-cols-1 lg:grid-cols-2 gap-stack-md mb-stack-lg fade-in-section">
        
        <div class="space-y-6 text-left" data-aos="fade-up">
          <div class="flex items-center gap-2 pb-2 border-b border-on-surface/[0.1]">
            <span class="material-symbols-outlined text-primary text-[24px]">event_note</span>
            <h3 class="font-headline-md text-headline-md text-on-surface">Kalender Liturgi</h3>
          </div>
          
          <div class="space-y-4">
            <div 
              v-for="item in calendar" 
              :key="item.id"
              class="flex gap-4 items-start bg-surface-container-low p-5 rounded-xl border border-outline/10 shadow-sm"
            >
              <div class="bg-primary/10 border border-primary/20 text-primary w-12 h-12 rounded-lg flex flex-col items-center justify-center flex-shrink-0 font-bold">
                <span class="text-[10px] uppercase leading-none">{{ getMonthShort(item.event_date) }}</span>
                <span class="text-[18px] leading-tight mt-0.5">{{ getDay(item.event_date) }}</span>
              </div>
              <div>
                <h4 class="font-bold text-[15px] text-on-surface leading-tight">{{ item.title }}</h4>
                <p class="text-secondary text-[13px] mt-1.5 leading-relaxed">{{ item.content }}</p>
              </div>
            </div>
            
            <div v-if="calendar.length === 0" class="text-center py-8 text-secondary text-[14px]">
              Belum ada agenda kalender liturgi mendatang.
            </div>
          </div>
        </div>

        
        <div class="space-y-6 text-left" data-aos="fade-up" data-aos-delay="100">
          <div class="flex items-center gap-2 pb-2 border-b border-on-surface/[0.1]">
            <span class="material-symbols-outlined text-primary text-[24px]">campaign</span>
            <h3 class="font-headline-md text-headline-md text-on-surface">Pengumuman Liturgi</h3>
          </div>

          <div class="space-y-4">
            <div 
              v-for="ann in announcements" 
              :key="ann.id"
              class="bg-surface-container-low p-5 rounded-xl border border-outline/10 shadow-sm relative overflow-hidden"
            >
              <div class="absolute left-0 top-0 bottom-0 w-1 bg-primary"></div>
              <h4 class="font-bold text-[16px] text-on-surface mb-2 leading-tight">{{ ann.title }}</h4>
              <p class="text-secondary text-[13px] leading-relaxed">{{ ann.content }}</p>
              <span class="text-[10px] font-semibold text-primary block mt-3 font-mono">
                Diumumkan pada: {{ formatDate(ann.event_date) }}
              </span>
            </div>

            <div v-if="announcements.length === 0" class="text-center py-8 text-secondary text-[14px]">
              Belum ada pengumuman liturgi terbaru.
            </div>
          </div>
        </div>
      </section>

      
      <section class="mb-stack-lg fade-in-section">
        <h2 class="font-headline-lg text-headline-lg md:font-headline-lg md:text-headline-lg text-on-surface mb-stack-md text-center">
          Pelayanan Liturgi
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter text-left">
          
          <div class="bg-white border border-outline-variant/20 rounded-2xl p-6 flex flex-col justify-between premium-hover-card shadow-sm hover:shadow-md transition-all duration-300">
            <div>
              <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center mb-4 text-primary">
                <span class="material-symbols-outlined">music_note</span>
              </div>
              <h3 class="font-headline-md text-headline-md text-on-surface mb-2">Koor Paduan Suara</h3>
              <p class="font-body-md text-body-md text-secondary mb-6 leading-relaxed">
                Mendukung perayaan Ekaristi melalui nyanyian rohani yang mengangkat hati umat kepada Tuhan.
              </p>
            </div>
            <a class="text-primary font-label-md text-label-md hover:text-[#60491f] flex items-center gap-1 mt-auto transition-colors" href="#">
              Informasi Bergabung <span class="material-symbols-outlined text-sm">arrow_forward</span>
            </a>
          </div>
          
          
          <div class="bg-white border border-outline-variant/20 rounded-2xl p-6 flex flex-col justify-between premium-hover-card shadow-sm hover:shadow-md transition-all duration-300">
            <div>
              <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center mb-4 text-primary">
                <span class="material-symbols-outlined">menu_book</span>
              </div>
              <h3 class="font-headline-md text-headline-md text-on-surface mb-2">Lektor &amp; Pemazmur</h3>
              <p class="font-body-md text-body-md text-secondary mb-6 leading-relaxed">
                Mewartakan Sabda Allah dan memandu umat dalam nyanyian mazmur tanggapan selama perayaan.
              </p>
            </div>
            <a class="text-primary font-label-md text-label-md hover:text-[#60491f] flex items-center gap-1 mt-auto transition-colors" href="#">
              Informasi Bergabung <span class="material-symbols-outlined text-sm">arrow_forward</span>
            </a>
          </div>
          
          
          <div class="bg-white border border-outline-variant/20 rounded-2xl p-6 flex flex-col justify-between premium-hover-card shadow-sm hover:shadow-md transition-all duration-300">
            <div>
              <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center mb-4 text-primary">
                <span class="material-symbols-outlined">local_fire_department</span>
              </div>
              <h3 class="font-headline-md text-headline-md text-on-surface mb-2">Putra-Putri Altar</h3>
              <p class="font-body-md text-body-md text-secondary mb-6 leading-relaxed">
                Membantu Imam di seputar Altar, melatih kaum muda dalam pelayanan sakral dan kedisiplinan rohani.
              </p>
            </div>
            <a class="text-primary font-label-md text-label-md hover:text-[#60491f] flex items-center gap-1 mt-auto transition-colors" href="#">
              Informasi Bergabung <span class="material-symbols-outlined text-sm">arrow_forward</span>
            </a>
          </div>
        </div>
      </section>
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
        v-if="showPosterModal" 
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm"
        @click.self="showPosterModal = false"
      >
        <div class="relative max-w-4xl w-full bg-white rounded-2xl overflow-hidden shadow-2xl p-2 flex flex-col">
          
          <button 
            @click="showPosterModal = false"
            class="absolute top-4 right-4 bg-black/60 hover:bg-black/80 text-white rounded-full p-2 transition-colors z-10"
          >
            <span class="material-symbols-outlined block text-[20px]">close</span>
          </button>
          
          <img 
            src="/images/jadwal_misa.jpg" 
            alt="Poster Jadwal Misa" 
            class="w-full h-auto max-h-[85vh] object-contain rounded-lg"
          />
        </div>
      </div>
    </transition>
  </AppLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
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
  masses: Array,
  announcements: Array,
  calendar: Array,
});

const showPosterModal = ref(false);

const getMassDayLabel = (misa) => {
  const title = misa.title.toLowerCase();
  if (title.includes('jumat pertama')) return 'Jumat Pertama';
  if (title.includes('harian')) return 'Senin - Jumat';
  if (title.includes('sabtu sore')) return 'Sabtu (Sore)';
  if (title.includes('minggu pagi i')) return 'Minggu Pagi I';
  if (title.includes('minggu pagi ii')) return 'Minggu Pagi II';
  if (title.includes('minggu sore')) return 'Minggu Sore';

  
  const date = new Date(misa.event_date);
  if (!isNaN(date.getTime())) {
    const dayName = date.toLocaleDateString('id-ID', { weekday: 'long' });
    return `${dayName} (${misa.title})`;
  }
  return misa.content || misa.title;
};


const harianMasses = computed(() => {
  return props.masses.filter(m => {
    const label = getMassDayLabel(m).toLowerCase();
    const isWeekend = label.includes('sabtu') || label.includes('minggu');
    return !isWeekend;
  });
});

const akhirPekanMasses = computed(() => {
  return props.masses.filter(m => {
    const label = getMassDayLabel(m).toLowerCase();
    const isWeekend = label.includes('sabtu') || label.includes('minggu');
    return isWeekend;
  });
});

const formatDate = (dateStr) => {
  if (!dateStr) return '';
  const date = new Date(dateStr);
  return date.toLocaleDateString('id-ID', {
    day: 'numeric',
    month: 'long',
    year: 'numeric'
  });
};

const getMonthShort = (dateStr) => {
  if (!dateStr) return '';
  const date = new Date(dateStr);
  return date.toLocaleDateString('id-ID', { month: 'short' });
};

const getDay = (dateStr) => {
  if (!dateStr) return '';
  const date = new Date(dateStr);
  return date.getDate();
};
</script>
