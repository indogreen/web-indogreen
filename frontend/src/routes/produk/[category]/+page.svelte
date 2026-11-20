<script lang="ts">
  import { page } from '$app/state';
  import Container from '$lib/components/ui/Container.svelte';
  import Section from '$lib/components/ui/Section.svelte';
  import Button from '$lib/components/ui/Button.svelte';
  import CornerSquare from '$lib/components/ui/CornerSquare.svelte';
  import SeoHead from '$lib/components/layout/SeoHead.svelte';
  import Breadcrumb from '$lib/components/layout/Breadcrumb.svelte';
  import SubNav from '$lib/components/layout/SubNav.svelte';

  const categorySlug = $derived(page.params.category || 'kategori');

  function formatTitle(slug: string): string {
    return slug
      .split('-')
      .map((w) => w.charAt(0).toUpperCase() + w.slice(1))
      .join(' ');
  }

  const categoryName = $derived(formatTitle(categorySlug));

  const subNavItems = [
    { label: 'Semua Produk', href: '/produk' },
    { label: 'PJU Tenaga Surya', href: '/produk/pju-tenaga-surya' },
    { label: 'PLTS Residensial', href: '/produk/plts-residential' },
    { label: 'Solar Home System', href: '/produk/solar-home-system' },
    { label: 'Aksesoris Kelistrikan', href: '/produk/aksesoris-kelistrikan' }
  ];
</script>

<SeoHead
  title="Kategori {categoryName}"
  description="Daftar produk resmi kategori {categoryName} PT. Indogreen Technology And Management."
/>

<Breadcrumb items={[{ label: 'Produk', href: '/produk' }, { label: categoryName }]} />

<SubNav
  items={subNavItems}
  activeHref="/produk/{categorySlug}"
  ariaLabel="Filter Kategori Produk"
/>

<Section tone="light">
  <Container>
    <div class="mb-xl flex flex-col gap-xs">
      <h1 class="type-display-lg font-bold text-ink">Kategori: {categoryName}</h1>
      <p class="type-body-md max-w-3xl text-body">
        Spesifikasi perangkat dan sistem energi surya kategori {categoryName}.
      </p>

      <div
        class="type-caption-sm mt-sm inline-flex items-center gap-xs rounded-sm border border-hairline bg-surface-soft px-md py-xs text-stone"
      >
        <span>TODO-CONTENT: Daftar produk kategori spesifik diimplementasikan pada Fase 8.</span>
      </div>
    </div>

    <!-- Sample Model Series Cards for Navigation Verification -->
    <div class="grid grid-cols-1 gap-lg tablet:grid-cols-2 desktop:grid-cols-3">
      <div class="relative border border-hairline bg-canvas p-xl">
        <CornerSquare position="top-left" size="sm" />
        <span class="type-caption-xs font-bold text-primary uppercase">Best Seller</span>
        <h2 class="type-card-title mt-xs font-bold text-ink">PJU Two-In-One Helios Series</h2>
        <p class="type-body-sm mt-xs text-body">
          Lampu jalan surya hemat daya dengan baterai LiFePO4 dan controller MPPT cerdas.
        </p>
        <div class="mt-md">
          <Button variant="ghost-link" href="/produk/{categorySlug}/pju-two-in-one-helios-series">
            Lihat Spesifikasi Teknis →
          </Button>
        </div>
      </div>

      <div class="relative border border-hairline bg-canvas p-xl">
        <CornerSquare position="top-left" size="sm" />
        <span class="type-caption-xs font-bold text-mute uppercase">Seri Pilihan</span>
        <h2 class="type-card-title mt-xs font-bold text-ink">PJU All-In-One Mars Series</h2>
        <p class="type-body-sm mt-xs text-body">
          Desain ringkas terintegrasi modular untuk instalasi cepat di area industri.
        </p>
        <div class="mt-md">
          <Button variant="ghost-link" href="/produk/{categorySlug}/pju-all-in-one-mars-series">
            Lihat Spesifikasi Teknis →
          </Button>
        </div>
      </div>
    </div>
  </Container>
</Section>
