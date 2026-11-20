<script lang="ts">
  import Container from '$lib/components/ui/Container.svelte';
  import Section from '$lib/components/ui/Section.svelte';
  import Button from '$lib/components/ui/Button.svelte';
  import CornerSquare from '$lib/components/ui/CornerSquare.svelte';
  import SeoHead from '$lib/components/layout/SeoHead.svelte';
  import Breadcrumb from '$lib/components/layout/Breadcrumb.svelte';
  import SubNav from '$lib/components/layout/SubNav.svelte';

  const subNavItems = [
    { label: 'Semua Produk', href: '/produk' },
    { label: 'PJU Tenaga Surya', href: '/produk/pju-tenaga-surya' },
    { label: 'PLTS Residensial', href: '/produk/plts-residential' },
    { label: 'Solar Home System', href: '/produk/solar-home-system' },
    { label: 'Aksesoris Kelistrikan', href: '/produk/aksesoris-kelistrikan' }
  ];
</script>

<SeoHead
  title="Katalog Produk EBT & PJU Surya"
  description="Katalog resmi perangkat keras dan sistem tenaga surya PT. Indogreen Technology And Management: Lampu PJU Two-In-One, All-In-One, baterai LiFePO4, dan inverter."
/>

<Breadcrumb items={[{ label: 'Produk' }]} />
<SubNav items={subNavItems} activeHref="/produk" ariaLabel="Kategori Produk" />

<Section tone="light">
  <Container>
    <div class="mb-xl flex flex-col gap-xs">
      <h1 class="type-display-lg font-bold text-ink">Katalog Produk Tenaga Surya</h1>
      <p class="type-body-md max-w-3xl text-body">
        Perangkat keras berkualitas tinggi yang dirancang untuk keandalan maksimal di iklim tropis
        Indonesia, didukung garansi resmi dan ketersediaan suku cadang purna jual.
      </p>

      <div
        class="type-caption-sm mt-sm inline-flex items-center gap-xs rounded-sm border border-hairline bg-surface-soft px-md py-xs text-stone"
      >
        <span>
          TODO-CONTENT: Grid katalog produk interaktif dengan paginasi dan filter diimplementasikan
          pada Fase 8.
        </span>
      </div>
    </div>

    <!-- Category Placeholder Cards -->
    <div class="grid grid-cols-1 gap-lg tablet:grid-cols-2 desktop:grid-cols-4">
      <div class="relative border border-hairline bg-canvas p-xl">
        <CornerSquare position="top-left" size="sm" />
        <span class="type-caption-xs font-bold text-mute uppercase">Kategori 01</span>
        <h2 class="type-card-title mt-xs font-bold text-ink">PJU Tenaga Surya</h2>
        <p class="type-body-sm mt-xs text-body">
          Lampu jalan mandiri hemat energi seri Helios, Jupiter, dan Mars.
        </p>
        <div class="mt-md">
          <Button variant="ghost-link" href="/produk/pju-tenaga-surya">Lihat Kategori →</Button>
        </div>
      </div>

      <div class="relative border border-hairline bg-canvas p-xl">
        <CornerSquare position="top-left" size="sm" />
        <span class="type-caption-xs font-bold text-mute uppercase">Kategori 02</span>
        <h2 class="type-card-title mt-xs font-bold text-ink">PLTS Residensial</h2>
        <p class="type-body-sm mt-xs text-body">
          Sistem pembangkit listrik tenaga surya atap hemat daya untuk hunian mandiri.
        </p>
        <div class="mt-md">
          <Button variant="ghost-link" href="/produk/plts-residential">Lihat Kategori →</Button>
        </div>
      </div>

      <div class="relative border border-hairline bg-canvas p-xl">
        <CornerSquare position="top-left" size="sm" />
        <span class="type-caption-xs font-bold text-mute uppercase">Kategori 03</span>
        <h2 class="type-card-title mt-xs font-bold text-ink">Solar Home System (SHS)</h2>
        <p class="type-body-sm mt-xs text-body">
          Paket elektrifikasi surya pedesaan dan daerah terpencil / 3T.
        </p>
        <div class="mt-md">
          <Button variant="ghost-link" href="/produk/solar-home-system">Lihat Kategori →</Button>
        </div>
      </div>

      <div class="relative border border-hairline bg-canvas p-xl">
        <CornerSquare position="top-left" size="sm" />
        <span class="type-caption-xs font-bold text-mute uppercase">Kategori 04</span>
        <h2 class="type-card-title mt-xs font-bold text-ink">Aksesoris Kelistrikan</h2>
        <p class="type-body-sm mt-xs text-body">
          Inverter efisiensi tinggi, baterai LiFePO4, solar charge controller MPPT.
        </p>
        <div class="mt-md">
          <Button variant="ghost-link" href="/produk/aksesoris-kelistrikan">
            Lihat Kategori →
          </Button>
        </div>
      </div>
    </div>
  </Container>
</Section>
