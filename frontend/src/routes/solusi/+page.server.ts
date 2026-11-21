import type { PageServerLoad } from './$types.js';
import { api } from '$lib/server/api.js';
import type { SolutionListItem } from '$lib/types/index.js';

export const load: PageServerLoad = async ({ fetch }) => {
  try {
    const solutions = await api.getSolutions(fetch);
    return {
      solutions
    };
  } catch {
    // Fallback solutions when API is unreachable
    const fallbackSolutions: SolutionListItem[] = [
      {
        id: 1,
        name: 'PLTS On-Grid System',
        slug: 'plts-on-grid',
        system_type: 'On-Grid',
        summary:
          'Sistem PLTS tersambung jaringan PLN untuk memangkas tagihan listrik harian melalui skema net-metering tanpa baterai.',
        diagram_image: null,
        sort_order: 1
      },
      {
        id: 2,
        name: 'PLTS On-Grid Hybrid System',
        slug: 'plts-on-grid-hybrid',
        system_type: 'On-Grid Hybrid',
        summary:
          'Sistem hemat biaya tersambung PLN dengan integrasi bank baterai LiFePO4 untuk cadangan daya darurat saat pemadaman.',
        diagram_image: null,
        sort_order: 2
      },
      {
        id: 3,
        name: 'PLTS Off-Grid Mandiri',
        slug: 'plts-off-grid',
        system_type: 'Off-Grid',
        summary:
          'Sistem mandiri 100% tanpa jaringan transmisi PLN, menggunakan bank baterai LiFePO4 untuk elektrifikasi pulau dan daerah 3T.',
        diagram_image: null,
        sort_order: 3
      },
      {
        id: 4,
        name: 'PLTS Off-Grid Hybrid',
        slug: 'plts-off-grid-hybrid',
        system_type: 'Off-Grid Hybrid',
        summary:
          'Kombinasi PLTS mandiri dengan genset diesel atau turbin angin untuk kontinuitas daya operasional 24/7 di lokasi terpencil.',
        diagram_image: null,
        sort_order: 4
      },
      {
        id: 5,
        name: 'Backup Power UPS Surya',
        slug: 'backup-power-ups',
        system_type: 'Backup Power',
        summary:
          'Sistem pencadangan daya bebas kedip (< 10ms) untuk infrastruktur kritis, server data, dan peralatan medis penting.',
        diagram_image: null,
        sort_order: 5
      }
    ];

    return {
      solutions: fallbackSolutions
    };
  }
};
