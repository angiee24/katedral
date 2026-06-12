<template>
  <AppLayout>
    <div class="pt-[32px] pb-stack-lg px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto w-full">
      
      <header class="mb-stack-lg flex flex-col items-center text-center warta-header">
        <h1 class="font-display-lg text-display-lg md:text-display-lg text-on-surface mb-stack-sm">Warta Paroki</h1>
        <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mb-stack-md">
          Kabar terbaru, jadwal liturgi, dan informasi komunitas dari Paroki Gereja Katedral Samarinda.
        </p>
        
        <div class="w-full max-w-3xl flex flex-col md:flex-row gap-4 items-center bg-surface-container-low p-2 rounded-xl border border-outline-variant/20 focus-within:border-primary/50 focus-within:ring-2 focus-within:ring-primary/10 transition-all duration-300">
          
          <div class="relative w-full flex-grow">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline">search</span>
            <input 
              type="text" 
              v-model="searchQuery"
              @input="handleSearch"
              placeholder="Cari warta..."
              class="w-full bg-transparent border-none focus:ring-0 pl-12 pr-4 py-3 font-body-md text-body-md text-on-surface placeholder-outline-variant outline-none"
            />
          </div>
          
          <div class="h-8 w-px bg-outline-variant/30 hidden md:block"></div>
          
          
          <div class="flex gap-2 w-full md:w-auto overflow-x-auto no-scrollbar pb-2 md:pb-0 px-2 md:px-0">
            <Link 
              href="/warta"
              :data="filters.q ? { q: filters.q } : {}"
              class="whitespace-nowrap px-4 py-2 rounded-full font-label-md text-label-md transition-all duration-300 smooth-btn"
              :class="!selectedCategory ? 'bg-primary/10 text-primary' : 'hover:bg-primary/5 hover:text-primary text-on-surface-variant'"
            >
              Semua
            </Link>
            
            <Link 
              v-for="cat in categories" 
              :key="cat.id"
              href="/warta"
              :data="{ ... (filters.q ? { q: filters.q } : {}), category: cat.slug }"
              class="whitespace-nowrap px-4 py-2 rounded-full font-label-md text-label-md transition-all duration-300 smooth-btn"
              :class="selectedCategory === cat.slug ? 'bg-primary/10 text-primary' : 'hover:bg-primary/5 hover:text-primary text-on-surface-variant'"
            >
              {{ cat.name }}
            </Link>
          </div>
        </div>
      </header>

      
      <div v-if="posts.data.length > 0">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-gutter">
          <article 
            v-for="(post, index) in posts.data" 
            :key="post.id"
            @click="router.visit(`/warta/${post.slug}`)"
            class="bg-surface-container-low rounded-xl overflow-hidden group cursor-pointer flex flex-col justify-between premium-hover-card border border-outline-variant/10 shadow-sm hover:shadow-md fade-in-card"
            :class="index === 0 ? 'col-span-1 md:col-span-2 lg:col-span-2' : ''"
          >
            
            <div class="block w-full overflow-hidden relative">
              <div :class="index === 0 ? 'h-64 md:h-80' : 'h-48'" class="w-full overflow-hidden bg-[#FAF9F6] flex items-center justify-center">
                <img 
                  :src="post.media ? post.media.url : '/images/logo_katedral.png'" 
                  :alt="post.title" 
                  class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" 
                />
              </div>
              <div class="absolute top-4 left-4 flex gap-2">
                <span class="bg-surface/90 backdrop-blur text-primary font-label-md text-label-md px-3 py-1 rounded-md uppercase">
                  {{ post.category?.name }}
                </span>
              </div>
            </div>

            
            <div :class="index === 0 ? 'p-6 md:p-8 flex-grow flex flex-col justify-between' : 'p-6 flex-grow flex flex-col justify-between'">
              <div>
                <time class="font-caption text-caption text-outline mb-2 block">
                  {{ formatDate(post.published_at) }}
                </time>
                <h2 
                  :class="index === 0 ? 'font-headline-lg text-headline-lg' : 'font-headline-md text-headline-md'" 
                  class="text-on-surface mb-3 group-hover:text-primary transition-colors line-clamp-2"
                >
                  {{ post.title }}
                </h2>
                <p class="font-body-md text-body-md text-on-surface-variant mb-6 line-clamp-2">
                  {{ post.excerpt }}
                </p>
              </div>
              <span 
                class="font-label-md text-label-md text-primary flex items-center gap-1 mt-auto group-hover:text-on-primary-fixed-variant transition-colors"
              >
                Baca selengkapnya <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
              </span>
            </div>
          </article>
        </div>

        
        <div class="mt-stack-lg flex justify-center items-center gap-2" v-if="posts.links && posts.links.length > 3">
          <template v-for="(link, i) in posts.links" :key="i">
            <span 
              v-if="link.url === null" 
              class="px-4 py-2 text-[13px] text-[#605e58] opacity-50 cursor-not-allowed select-none"
              v-html="link.label"
            ></span>
            <Link 
              v-else
              :href="link.url"
              class="px-4 py-2 rounded-lg text-[13px] font-semibold border smooth-btn"
              :class="link.active 
                ? 'bg-primary text-white border-primary shadow-sm' 
                : 'bg-white text-secondary border-outline-variant/20 hover:border-primary hover:text-primary'"
              v-html="link.label"
            ></Link>
          </template>
        </div>
      </div>

      
      <div v-else class="text-center py-20 bg-surface-container-low border border-outline-variant/15 rounded-xl shadow-sm">
        <span class="material-symbols-outlined text-outline-variant text-5xl mb-4 block">search_off</span>
        <p class="text-on-surface-variant text-[15px] font-semibold">Tidak ada warta yang ditemukan.</p>
        <p class="text-on-surface-variant text-[12px] mt-1.5">Coba kata kunci pencarian atau kategori lain.</p>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import AppLayout from '@/Layouts/AppLayout.vue';

gsap.registerPlugin(ScrollTrigger);

const props = defineProps({
  posts: Object,
  categories: Array,
  selectedCategory: String,
  filters: Object,
});

const searchQuery = ref(props.filters.q || '');
let searchTimeout = null;

const handleSearch = () => {
  clearTimeout(searchTimeout);
  searchTimeout = setTimeout(() => {
    router.get('/warta', {
      q: searchQuery.value,
      category: props.selectedCategory || undefined,
    }, {
      preserveState: true,
      replace: true,
    });
  }, 400);
};

const formatDate = (dateStr) => {
  if (!dateStr) return '';
  const date = new Date(dateStr);
  return date.toLocaleDateString('id-ID', {
    day: 'numeric',
    month: 'long',
    year: 'numeric'
  });
};

onMounted(() => {
  // Animasi header & filter
  gsap.fromTo('.warta-header', 
    { y: 30, opacity: 0 }, 
    { y: 0, opacity: 1, duration: 0.8, ease: 'power3.out' }
  );

  // Animasi warta cards
  gsap.utils.toArray('.fade-in-card').forEach((el) => {
    gsap.fromTo(el,
      { y: 40, opacity: 0 },
      {
        y: 0,
        opacity: 1,
        duration: 0.7,
        ease: 'power2.out',
        scrollTrigger: {
          trigger: el,
          start: 'top 90%',
          toggleActions: 'play none none none',
        }
      }
    );
  });
});
</script>

<style scoped>
.no-scrollbar::-webkit-scrollbar {
  display: none;
}
.no-scrollbar {
  -ms-overflow-style: none;  
  scrollbar-width: none;  
}
</style>

