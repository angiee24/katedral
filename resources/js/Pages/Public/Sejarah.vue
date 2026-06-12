<template>
  <AppLayout>
    <div class="pt-12 pb-stack-lg w-full">
      
      <section class="px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto mb-stack-lg text-center fade-in-section">
        <h1 class="font-display-lg text-display-lg text-primary mb-stack-sm">Jejak Iman di Tepian Mahakam</h1>
        <p class="font-body-lg text-body-lg text-secondary max-w-2xl mx-auto leading-relaxed">
          Sebuah perjalanan panjang dari misi awal hingga berdirinya katedral modern. Menelusuri sejarah keuskupan yang terus tumbuh bersama umat di Kalimantan Timur.
        </p>
      </section>

      
      <section class="py-16 px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto border-t border-b border-black/[0.05] my-12 fade-in-section">
        <div class="text-center mb-12">
          <h2 class="font-serif text-[28px] md:text-[36px] text-primary mb-2">Visi &amp; Misi</h2>
          <div class="w-12 h-1 bg-[#d1c5b5] mx-auto rounded-full"></div>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
          
          <div 
            class="lg:col-span-5 bg-white border border-outline-variant/20 rounded-2xl p-8 flex flex-col justify-center relative overflow-hidden group min-h-[250px] premium-hover-card shadow-sm hover:shadow-md transition-all duration-300"
          >
            <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-115 duration-500"></div>
            <span class="material-symbols-outlined text-primary text-4xl mb-6 relative z-10">visibility</span>
            <h3 class="font-serif text-[22px] md:text-[24px] text-on-surface mb-4 relative z-10">Visi Kami</h3>
            <p class="text-secondary text-[15px] leading-relaxed relative z-10">
              {{ vision || 'Menjadi persekutuan umat beriman yang tangguh, mandiri, dan misioner.' }}
            </p>
          </div>

          
          <div 
            class="lg:col-span-7 bg-white border border-outline-variant/20 rounded-2xl p-8 relative overflow-hidden flex flex-col justify-center min-h-[250px] premium-hover-card shadow-sm hover:shadow-md transition-all duration-300"
          >
            <span class="material-symbols-outlined text-primary text-4xl mb-6">explore</span>
            <h3 class="font-serif text-[22px] md:text-[24px] text-on-surface mb-4">Misi Kami</h3>
            <div class="text-secondary text-[15px] leading-relaxed space-y-3.5 text-left">
              <p 
                v-for="(misiLine, index) in parsedMissions" 
                :key="index"
                class="flex gap-3 items-start"
              >
                <span class="font-bold text-primary font-mono">{{ index + 1 }}.</span>
                <span>{{ cleanMissionLine(misiLine) }}</span>
              </p>
              <p v-if="parsedMissions.length === 0">Data misi belum dikonfigurasi.</p>
            </div>
          </div>
        </div>
      </section>

      
      <section class="relative px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto timeline-line py-stack-md">
        <div 
          v-for="(item, index) in timelines" 
          :key="item.id"
          class="relative flex flex-col md:flex-row items-center justify-between mb-stack-lg w-full cursor-pointer group fade-in-section"
          @click="triggerClickAnimation($event, index)"
        >
          
          <div 
            class="order-1 w-full mb-8 md:mb-0 ml-12 md:ml-0 transition-all duration-300"
            :class="[
              index % 2 === 0 
                ? 'md:w-5/12 md:text-right md:pr-12' 
                : 'md:order-3 md:w-5/12 md:text-left md:pl-12'
            ]"
          >
            <span class="font-label-md text-label-md text-primary uppercase tracking-widest block mb-2">{{ item.year }}</span>
            <h3 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface mb-4 transition-colors group-hover:text-primary">
              {{ item.title }}
            </h3>
            <p class="text-secondary font-body-md leading-relaxed">
              {{ item.description }}
            </p>
          </div>

          
          <div 
            class="z-10 order-2 absolute md:relative left-5 md:left-auto flex items-center justify-center w-4 h-4 bg-surface border-2 rounded-full transition-all duration-300 shadow-[0_0_0_8px_rgba(250,249,246,1)] group-hover:scale-125 group-hover:border-primary group-hover:bg-primary group-hover:ring-4 group-hover:ring-primary/20"
            :class="activeCard === index ? 'bg-primary border-primary scale-125 ring-4 ring-primary/25' : 'border-primary bg-surface'"
          ></div>

          
          <div 
            class="hidden md:block order-3 md:w-5/12"
            :class="index % 2 === 0 ? '' : 'md:order-1'"
          ></div>
        </div>
      </section>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import AppLayout from '@/Layouts/AppLayout.vue';

gsap.registerPlugin(ScrollTrigger);

const props = defineProps({
  vision: String,
  mission: String,
  timelines: Array,
});

const activeCard = ref(null);

const parsedMissions = computed(() => {
  if (!props.mission) return [];
  return props.mission.split('\n').map(m => m.trim()).filter(Boolean);
});

const cleanMissionLine = (line) => {
  return line.replace(/^\d+\.\s*/, '');
};

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

const triggerClickAnimation = (event, index) => {
  activeCard.value = activeCard.value === index ? null : index;

  gsap.timeline()
    .to(event.currentTarget, { scale: 0.98, duration: 0.1, ease: 'power2.out' })
    .to(event.currentTarget, { scale: 1.01, duration: 0.3, ease: 'back.out(2)' })
    .to(event.currentTarget, { scale: 1, duration: 0.15 });
};
</script>
