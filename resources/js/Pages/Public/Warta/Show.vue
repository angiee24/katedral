<template>
  <AppLayout>
    <div class="pt-[28px] pb-stack-lg max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop w-full">
      
      <div class="mb-6">
        <Link 
          href="/warta" 
          class="inline-flex items-center gap-1.5 text-[13px] font-semibold text-primary hover:text-on-primary-fixed-variant uppercase tracking-wider group smooth-btn"
        >
          <span class="material-symbols-outlined transition-transform duration-300 group-hover:-translate-x-1 text-[18px]">
            arrow_back
          </span>
          <span>Kembali ke Warta</span>
        </Link>
      </div>

      
      <div v-if="post.media" class="w-full h-[409px] md:h-[614px] bg-surface-container-high rounded-xl overflow-hidden mb-8 relative shadow-sm header-image-anim">
        <img 
          :src="post.media.url" 
          :alt="post.title" 
          class="w-full h-full object-cover" 
        />
        <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
      </div>

      
      <div class="grid grid-cols-1 md:grid-cols-12 gap-gutter pt-4">
        
        <div class="md:col-span-8 flex flex-col warta-detail-content">
          
          <div class="mb-8">
            <div class="flex items-center gap-4 mb-4">
              <span class="bg-[#F7F3EB] text-primary px-3 py-1 rounded font-label-md text-label-md uppercase tracking-wider border border-outline-variant/30">
                {{ post.category?.name }}
              </span>
              <span class="text-on-surface-variant font-caption text-caption flex items-center gap-1">
                <span class="material-symbols-outlined text-[16px]">calendar_today</span>
                {{ formatDate(post.published_at) }}
              </span>
            </div>
            
            <h1 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-background mb-4 leading-tight">
              {{ post.title }}
            </h1>

            <div class="flex items-center gap-3 border-y border-outline-variant/20 py-4">
              <div class="w-10 h-10 rounded-full bg-surface-container-high flex items-center justify-center font-bold text-primary uppercase text-sm border border-[#d1c5b5]/20">
                {{ getInitials(post.author ? post.author.name : 'Penulis') }}
              </div>
              <div>
                <p class="font-label-md text-label-md text-on-background">
                  {{ post.author ? post.author.name : 'Penulis Paroki' }}
                </p>
                <p class="font-caption text-caption text-on-surface-variant">
                  Tim Komunikasi Paroki
                </p>
              </div>
            </div>
          </div>

          
          <div 
            class="article-content font-body-lg text-body-lg text-on-surface-variant leading-relaxed text-left space-y-6 mb-8"
            v-html="post.content"
          >
          </div>
        </div>

        
        <aside class="md:col-span-4 space-y-stack-md mt-stack-md md:mt-0 flex flex-col gap-6 text-left warta-detail-sidebar">
          
          <div class="bg-[#F7F3EB] rounded-xl p-6 shadow-sm border border-outline-variant/10">
            <h3 class="font-headline-md text-headline-md text-on-background mb-6 flex items-center gap-2">
              <span class="material-symbols-outlined text-primary">trending_up</span> 
              Berita Terpopuler
            </h3>
            <div class="space-y-6">
              <div v-for="(pop, i) in popularPosts" :key="pop.id">
                <Link :href="`/warta/${pop.slug}`" class="group block">
                  <span class="font-caption text-caption text-primary mb-1 block">
                    {{ formatDate(pop.published_at) }}
                  </span>
                  <h4 class="font-body-md text-body-md text-on-background group-hover:text-primary group-hover:translate-x-1 transition-all duration-300 line-clamp-2 font-semibold">
                    {{ pop.title }}
                  </h4>
                </Link>
                <hr v-if="i < popularPosts.length - 1" class="border-outline-variant/10 mt-4" />
              </div>
            </div>
          </div>

          
          <div class="bg-surface-container-low border border-outline-variant/20 rounded-xl p-6 shadow-sm">
            <h3 class="font-headline-md text-headline-md text-on-background mb-4">
              Kategori
            </h3>
            <div class="flex flex-wrap gap-2">
              <Link 
                v-for="cat in categories" 
                :key="cat.id"
                :href="`/warta`"
                :data="{ category: cat.slug }"
                class="bg-surface text-on-surface-variant border border-outline-variant/20 px-4 py-2 rounded-full font-label-md text-label-md hover:border-primary hover:text-primary hover:bg-primary/5 transition-all duration-300 smooth-btn shadow-sm hover:shadow"
              >
                {{ cat.name }}
              </Link>
            </div>
          </div>
        </aside>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { onMounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import { gsap } from 'gsap';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
  post: Object,
  popularPosts: Array,
  categories: Array,
});

onMounted(() => {
  // Fade in header image if exists
  gsap.fromTo('.header-image-anim', 
    { scale: 0.98, opacity: 0 }, 
    { scale: 1, opacity: 1, duration: 0.8, ease: 'power3.out' }
  );

  // Fade in warta content
  gsap.fromTo('.warta-detail-content', 
    { y: 30, opacity: 0 }, 
    { y: 0, opacity: 1, duration: 0.8, ease: 'power3.out', delay: 0.1 }
  );
  
  // Fade in sidebar items
  gsap.fromTo('.warta-detail-sidebar > div', 
    { y: 30, opacity: 0 }, 
    { y: 0, opacity: 1, duration: 0.8, ease: 'power3.out', stagger: 0.15, delay: 0.2 }
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

const getInitials = (name) => {
  if (!name) return 'P';
  return name.trim().split(' ').map(n => n[0]).slice(0, 2).join('');
};
</script>

<style scoped>
.article-content :deep(p) {
  margin-bottom: 1.5rem;
}
.article-content :deep(iframe) {
  width: 100%;
  aspect-ratio: 16/9;
  border-radius: 0.75rem;
  margin-top: 1.5rem;
  margin-bottom: 1.5rem;
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.07);
  border: 1px solid rgba(118, 90, 39, 0.1);
}
.article-content :deep(img) {
  border-radius: 0.75rem;
  max-width: 100%;
  height: auto;
  margin: 1.5rem 0;
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
}
</style>

