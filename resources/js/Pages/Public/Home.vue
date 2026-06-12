<template>
  <AppLayout>
    
    <section class="relative w-full h-[819px] min-h-[600px] flex items-end pb-24 pt-32">
      <div class="absolute inset-0 z-0">
        <img 
          :src="bannerImage || '/images/katedral_hero_section.jpg'" 
          :alt="bannerTitle" 
          class="w-full h-full object-cover object-center" 
        />
        <div class="absolute inset-0 hero-overlay"></div>
      </div>
      <div class="relative z-10 w-full max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
        <div class="max-w-2xl text-left">
          <span ref="heroSpan" class="font-label-md text-label-md text-inverse-primary uppercase tracking-widest mb-4 block">
            Gereja Katedral Samarinda
          </span>
          <h1 ref="heroTitle" class="font-display-lg text-display-lg text-on-primary mb-6 leading-tight">
            {{ bannerTitle }}
          </h1>
          <p ref="heroSubtitle" class="font-body-lg text-body-lg text-surface-container-high mb-8 opacity-90">
            {{ bannerSubtitle }}
          </p>
          <div ref="heroBtn">
            <Link 
              href="/warta" 
              class="bg-primary text-on-primary font-label-md text-label-md px-8 py-3 rounded-lg uppercase tracking-wider hover:bg-[#60491f] transition-all inline-block text-center shadow-md smooth-btn cursor-pointer"
            >
              Jelajahi Warta
            </Link>
          </div>
        </div>
      </div>
    </section>

    
    <section class="py-stack-lg max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop w-full">
      <div class="flex justify-between items-end mb-stack-md border-b-[0.5px] border-on-surface/10 pb-4">
        <div>
          <h2 class="font-headline-lg text-headline-lg text-on-surface">Berita Terbaru</h2>
          <p class="font-body-md text-body-md text-on-surface-variant mt-2">Kabar terkini dari paroki dan keuskupan.</p>
        </div>
        <Link 
          href="/warta" 
          class="hidden md:flex items-center gap-2 text-primary hover:text-on-primary-fixed-variant transition-colors font-label-md text-label-md uppercase"
        >
          Lihat Semua <span class="material-symbols-outlined text-sm">arrow_forward</span>
        </Link>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-12 gap-gutter" v-if="featuredPost">
        
        <article 
          @click="router.visit(`/warta/${featuredPost.slug}`)"
          class="col-span-1 md:col-span-8 group cursor-pointer text-left premium-hover-card border border-outline-variant/20 rounded-2xl p-4 md:p-6 bg-white shadow-sm"
        >
          <div class="relative w-full h-80 md:h-[400px] rounded-xl overflow-hidden mb-4 bg-surface-container-low soft-shadow">
            <img 
              :src="featuredPost.media ? featuredPost.media.url : '/images/logo_katedral.png'" 
              :alt="featuredPost.title" 
              class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-in-out" 
            />
          </div>
          <div class="flex items-center gap-3 mb-2">
            <span class="bg-primary/10 text-primary font-label-md text-[10px] px-2 py-1 rounded uppercase tracking-wider">
              {{ featuredPost.category?.name }}
            </span>
            <time class="font-caption text-caption text-on-surface-variant">
              {{ formatDate(featuredPost.published_at) }}
            </time>
          </div>
          <h3 class="font-headline-md text-headline-md text-on-surface group-hover:text-primary transition-colors">
            {{ featuredPost.title }}
          </h3>
          <p class="font-body-md text-body-md text-on-surface-variant mt-2 line-clamp-2">
            {{ featuredPost.excerpt }}
          </p>
        </article>
        
        
        <div class="col-span-1 md:col-span-4 flex flex-col gap-gutter text-left">
          <article 
            v-for="post in sidePosts" 
            :key="post.id"
            @click="router.visit(`/warta/${post.slug}`)"
            class="flex-1 flex flex-col group cursor-pointer bg-white border border-outline-variant/20 rounded-2xl p-6 shadow-sm premium-hover-card"
          >
            <div class="flex items-center gap-3 mb-3">
              <span class="bg-primary/10 text-primary font-label-md text-[10px] px-2 py-1 rounded uppercase tracking-wider">
                {{ post.category?.name }}
              </span>
              <time class="font-caption text-caption text-on-surface-variant">
                {{ formatDate(post.published_at) }}
              </time>
            </div>
            <h3 class="font-headline-md text-xl text-on-surface group-hover:text-primary transition-colors mb-2">
              {{ post.title }}
            </h3>
            <p class="font-body-md text-sm text-on-surface-variant line-clamp-3">
              {{ post.excerpt }}
            </p>
          </article>
        </div>
      </div>
      
      
      <div v-else class="text-center py-20 bg-surface-container-low border border-outline-variant/15 rounded-xl shadow-sm">
        <span class="material-symbols-outlined text-outline-variant text-4xl mb-3 block">description</span>
        <p class="text-on-surface-variant text-[13px] font-medium">Belum ada warta terbaru yang diterbitkan.</p>
      </div>
    </section>
  </AppLayout>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import { gsap } from 'gsap';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
  bannerTitle: String,
  bannerSubtitle: String,
  bannerImage: String,
  featuredPost: Object,
  sidePosts: Array,
});

const heroSpan = ref(null);
const heroTitle = ref(null);
const heroSubtitle = ref(null);
const heroBtn = ref(null);

onMounted(() => {
  
  gsap.timeline()
    .fromTo(heroSpan.value,
      { y: 20, opacity: 0 },
      { y: 0, opacity: 1, duration: 0.6, ease: 'power3.out' }
    )
    .fromTo(heroTitle.value, 
      { y: 30, opacity: 0 }, 
      { y: 0, opacity: 1, duration: 0.8, ease: 'power3.out' },
      '-=0.4'
    )
    .fromTo(heroSubtitle.value, 
      { y: 20, opacity: 0 }, 
      { y: 0, opacity: 0.9, duration: 0.6, ease: 'power3.out' },
      '-=0.4'
    )
    .fromTo(heroBtn.value, 
      { y: 20, opacity: 0 }, 
      { y: 0, opacity: 1, duration: 0.6, ease: 'power3.out' },
      '-=0.4'
    );
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
</script>
