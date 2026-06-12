<template>
  <AdminLayout title="Dashboard Overview">
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      
      <div 
        class="bg-white rounded-xl p-8 border border-[#d1c5b5]/30 shadow-sm relative overflow-hidden group hover:border-[#765a27]/30 transition-colors duration-500 animate-fade-in"
      >
        <div class="absolute -right-6 -top-6 w-24 h-24 bg-[#f4f3f1] rounded-full opacity-50 group-hover:scale-110 transition-transform duration-700"></div>
        <div class="flex justify-between items-start relative z-10">
          <div>
            <h3 class="text-[12px] font-bold text-[#605e58] uppercase tracking-widest mb-2">Total Berita</h3>
            <div id="stat-total-posts" class="font-serif text-[48px] font-bold text-[#1a1c1a] group-hover:text-[#765a27] transition-colors duration-300">0</div>
          </div>
          <div class="w-12 h-12 rounded-full bg-[#f4f3f1] flex items-center justify-center text-[#765a27] border border-[#d1c5b5]/20">
            <span class="material-symbols-outlined">article</span>
          </div>
        </div>
        <div class="mt-6 flex items-center gap-2 text-[12px] text-[#765a27]">
          <span class="material-symbols-outlined text-[16px]">trending_up</span>
          <span>Mendukung pewartaan paroki</span>
        </div>
      </div>
      
      
      <div 
        class="bg-white rounded-xl p-8 border border-[#d1c5b5]/30 shadow-sm relative overflow-hidden group hover:border-[#765a27]/30 transition-colors duration-500 animate-fade-in"
      >
        <div class="absolute -right-6 -top-6 w-24 h-24 bg-[#f4f3f1] rounded-full opacity-50 group-hover:scale-110 transition-transform duration-700"></div>
        <div class="flex justify-between items-start relative z-10">
          <div>
            <h3 class="text-[12px] font-bold text-[#605e58] uppercase tracking-widest mb-2">Kategori Aktif</h3>
            <div id="stat-total-categories" class="font-serif text-[48px] font-bold text-[#1a1c1a] group-hover:text-[#765a27] transition-colors duration-300">0</div>
          </div>
          <div class="w-12 h-12 rounded-full bg-[#f4f3f1] flex items-center justify-center text-[#765a27] border border-[#d1c5b5]/20">
            <span class="material-symbols-outlined">category</span>
          </div>
        </div>
        <div class="mt-6 flex items-center gap-2 text-[12px] text-[#605e58]">
          <span class="material-symbols-outlined text-[16px]">horizontal_rule</span>
          <span>Pengelompokan warta</span>
        </div>
      </div>
      
      
      <div 
        class="bg-white rounded-xl p-8 border border-[#d1c5b5]/30 shadow-sm relative overflow-hidden group hover:border-[#765a27]/30 transition-colors duration-500 animate-fade-in"
      >
        <div class="absolute -right-6 -top-6 w-24 h-24 bg-[#f4f3f1] rounded-full opacity-50 group-hover:scale-110 transition-transform duration-700"></div>
        <div class="flex justify-between items-start relative z-10">
          <div>
            <h3 class="text-[12px] font-bold text-[#605e58] uppercase tracking-widest mb-2">Total View Warta</h3>
            <div id="stat-total-views" class="font-serif text-[48px] font-bold text-[#1a1c1a] group-hover:text-[#765a27] transition-colors duration-300">0</div>
          </div>
          <div class="w-12 h-12 rounded-full bg-[#f4f3f1] flex items-center justify-center text-[#765a27] border border-[#d1c5b5]/20">
            <span class="material-symbols-outlined">visibility</span>
          </div>
        </div>
        <div class="mt-6 flex items-center gap-2 text-[12px] text-[#765a27]">
          <span class="material-symbols-outlined text-[16px]">trending_up</span>
          <span>Akumulasi pembaca warta</span>
        </div>
      </div>
    </div>

    
    <div class="bg-white rounded-xl p-8 border border-[#d1c5b5]/30 shadow-sm mt-8">
      <div class="mb-6">
        <h2 class="font-serif text-[22px] text-[#1a1c1a] font-bold">Tren Kunjungan Portal</h2>
        <p class="text-[13px] text-[#605e58] mt-1">Statistik pengunjung unik harian (30 hari terakhir)</p>
      </div>
      
      
      <div class="w-full min-h-[320px]">
        <apexchart 
          type="area" 
          height="320" 
          :options="chartOptions" 
          :series="chartSeries"
        ></apexchart>
      </div>
    </div>

    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-8">
      
      <div class="bg-white rounded-xl p-8 border border-[#d1c5b5]/30 shadow-sm">
        <h3 class="font-serif text-[20px] text-[#1a1c1a] font-bold mb-6 flex items-center gap-2">
          <span class="material-symbols-outlined text-[#765a27]">trending_up</span> 
          Artikel Terpopuler
        </h3>
        <div class="overflow-x-auto">
          <table class="w-full text-left border-collapse text-[13px]">
            <thead>
              <tr class="border-b border-[#d1c5b5]/20 text-[#605e58]">
                <th class="pb-3 font-semibold uppercase tracking-wider text-[11px]">Judul Warta</th>
                <th class="pb-3 font-semibold uppercase tracking-wider text-[11px] text-right">Views</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-[#d1c5b5]/10">
              <tr 
                v-for="pop in metrics.popular_posts" 
                :key="pop.id"
                class="hover:bg-[#FAF9F6]/40 transition-colors"
              >
                <td class="py-3 pr-4">
                  <a 
                    :href="`/warta/${pop.slug}`" 
                    target="_blank" 
                    class="hover:text-[#765a27] transition-colors font-semibold text-[#1a1c1a] line-clamp-1"
                  >
                    {{ pop.title }}
                  </a>
                  <span class="text-[11px] text-[#605e58] mt-0.5 block">
                    {{ pop.category?.name }} • {{ formatDate(pop.published_at) }}
                  </span>
                </td>
                <td class="py-3 text-right font-bold text-[#765a27]">{{ pop.page_views_count }}</td>
              </tr>
              <tr v-if="!metrics.popular_posts || metrics.popular_posts.length === 0">
                <td colspan="2" class="py-4 text-center text-[#605e58]">Belum ada data warta populer.</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      
      <div class="bg-white rounded-xl p-8 border border-[#d1c5b5]/30 shadow-sm">
        <h3 class="font-serif text-[20px] text-[#1a1c1a] font-bold mb-6 flex items-center gap-2">
          <span class="material-symbols-outlined text-[#765a27]">history</span> 
          Aktivitas Pengguna
        </h3>
        <div class="space-y-4 max-h-[300px] overflow-y-auto pr-2 custom-scrollbar">
          <div 
            v-for="log in recentActivities" 
            :key="log.id"
            class="flex gap-4 items-start text-[13px] border-b border-[#d1c5b5]/10 pb-3 last:border-b-0"
          >
            <div class="w-8 h-8 rounded-full bg-[#765a27]/10 text-[#765a27] flex items-center justify-center flex-shrink-0 font-bold text-[11px] uppercase">
              {{ getAvatarInitials(log.user ? log.user.name : 'Sistem') }}
            </div>
            <div class="flex-grow">
              <p class="text-[#1a1c1a] font-semibold leading-none mb-1">
                {{ log.user ? log.user.name : 'Sistem / Tamu' }}
                <span class="text-[11px] text-[#605e58] font-normal ml-1">({{ log.ip_address }})</span>
              </p>
              <p class="text-[#605e58] text-[12px] mb-1">{{ log.activity }}</p>
              <span class="text-[10px] text-[#605e58] opacity-75 block">
                {{ timeAgo(log.created_at) }}
              </span>
            </div>
          </div>
          
          <div v-if="recentActivities.length === 0" class="text-center py-4 text-[#605e58]">
            Belum ada aktivitas terbaru yang tercatat.
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { onMounted } from 'vue';
import { CountUp } from 'countup.js';
import apexchart from 'vue3-apexcharts';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
  metrics: Object,
  trends: Object,
  monthlyTrend: Object,
  categoriesDist: Object,
  recentActivities: Array,
});


onMounted(() => {
  
  const postsCount = new CountUp('stat-total-posts', props.metrics.total_posts, { duration: 1.5 });
  if (!postsCount.error) postsCount.start();

  
  const catsCount = new CountUp('stat-total-categories', props.metrics.total_categories, { duration: 1.2 });
  if (!catsCount.error) catsCount.start();

  
  const viewsTarget = props.metrics.total_views || 0;
  const formatK = viewsTarget >= 1000;
  const viewsCount = new CountUp('stat-total-views', viewsTarget, {
    duration: 1.8,
    formattingFn: (n) => {
      if (formatK && n >= 1000) {
        return (n / 1000).toFixed(1) + 'K';
      }
      return n.toLocaleString('id-ID');
    }
  });
  if (!viewsCount.error) viewsCount.start();
});


const chartSeries = [
  {
    name: 'Pengunjung',
    data: props.trends?.visitors || []
  }
];

const chartOptions = {
  chart: {
    type: 'area',
    fontFamily: "'Hanken Grotesk', sans-serif",
    toolbar: { show: false },
    animations: {
      enabled: true,
      easing: 'easeinout',
      speed: 800,
    }
  },
  xaxis: {
    categories: props.trends?.labels || [],
    labels: {
      style: {
        colors: '#605e58',
        fontSize: '11px'
      }
    },
    axisBorder: { show: false },
    axisTicks: { show: false }
  },
  yaxis: {
    labels: {
      style: {
        colors: '#605e58',
        fontSize: '11px'
      }
    }
  },
  colors: ['#765a27'], 
  stroke: {
    curve: 'smooth',
    width: 3
  },
  fill: {
    type: 'gradient',
    gradient: {
      shadeIntensity: 1,
      opacityFrom: 0.4,
      opacityTo: 0.02,
      stops: [0, 95, 100]
    }
  },
  dataLabels: { enabled: false },
  grid: {
    borderColor: 'rgba(209, 197, 181, 0.15)',
    strokeDashArray: 4
  },
  tooltip: {
    theme: 'light',
    y: {
      formatter: (val) => val + " Pengunjung"
    }
  }
};

const formatDate = (dateStr) => {
  if (!dateStr) return '';
  const date = new Date(dateStr);
  return date.toLocaleDateString('id-ID', {
    day: 'numeric',
    month: 'short',
    year: 'numeric'
  });
};

const getAvatarInitials = (name) => {
  if (!name) return 'S';
  return name.trim().split(' ').map(n => n[0]).slice(0, 2).join('');
};

const timeAgo = (dateStr) => {
  if (!dateStr) return '';
  const date = new Date(dateStr);
  const now = new Date();
  const diffMs = now - date;
  const diffSec = Math.floor(diffMs / 1000);
  const diffMin = Math.floor(diffSec / 60);
  const diffHr = Math.floor(diffMin / 60);
  const diffDay = Math.floor(diffHr / 24);

  if (diffSec < 60) return 'Baru saja';
  if (diffMin < 60) return `${diffMin} menit yang lalu`;
  if (diffHr < 24) return `${diffHr} jam yang lalu`;
  if (diffDay === 1) return 'Kemarin';
  return `${diffDay} hari yang lalu`;
};
</script>

<style scoped>
.custom-scrollbar::-webkit-scrollbar {
  width: 4px;
}
.custom-scrollbar::-webkit-scrollbar-track {
  background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
  background-color: #d1c5b5;
  border-radius: 10px;
}
</style>
