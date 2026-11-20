<script lang="ts">
  import Container from '$lib/components/ui/Container.svelte';
  import Section from '$lib/components/ui/Section.svelte';
  import Button from '$lib/components/ui/Button.svelte';
  import CornerSquare from '$lib/components/ui/CornerSquare.svelte';
  import SeoHead from '$lib/components/layout/SeoHead.svelte';
  import Breadcrumb from '$lib/components/layout/Breadcrumb.svelte';
  import SubNav from '$lib/components/layout/SubNav.svelte';

  const subNavItems = [
    { label: 'Semua Solusi', href: '/solusi' },
    { label: 'PLTS On-Grid', href: '/solusi/plts-on-grid' },
    { label: 'PLTS On-Grid Hybrid', href: '/solusi/plts-on-grid-hybrid' },
    { label: 'PLTS Off-Grid', href: '/solusi/plts-off-grid' },
    { label: 'PLTS Off-Grid Hybrid', href: '/solusi/plts-off-grid-hybrid' },
    { label: 'Backup Power UPS', href: '/solusi/backup-power-ups' }
  ];
</script>

<SeoHead
  title="Solusi Rekayasa Sistem EBT & PLTS"
  description="Layanan rekayasa sistem tenaga surya PT. Indogreen Technology And Management: PLTS On-Grid, Off-Grid mandiri, sistem hybrid cerdas, dan cadangan daya UPS."
/>

<Breadcrumb items={[{ label: 'Solusi' }]} />
<SubNav items={subNavItems} activeHref="/solusi" ariaLabel="Solusi Rekayasa EBT" />

<Section tone="light">
  <Container>
    <div class="mb-xl flex flex-col gap-xs">
      <h1 class="type-display-lg font-bold text-ink">Solusi Rekayasa Sistem Energi Surya</h1>
      <p class="type-body-md max-w-3xl text-body">
        Integrasi sistem PLTS terstandarisasi untuk memangkas biaya energi operasional industri,
        menjamin kontinuitas daya tanpa jeda, serta mendukung target reduksi emisi karbon perusahaan
        Anda.
      </p>

      <div
        class="type-caption-sm mt-sm inline-flex items-center gap-xs rounded-sm border border-hairline bg-surface-soft px-md py-xs text-stone"
      >
        <span>
          TODO-CONTENT: Seluruh diagram arsitektur sistem dan kalkulator daya diimplementasikan pada
          Fase 8.
        </span>
      </div>
    </div>

    <!-- Solution Grid Placeholder -->
    <div class="grid grid-cols-1 gap-lg tablet:grid-cols-2 desktop:grid-cols-3">
      <div class="relative border border-hairline bg-canvas p-xl">
        <CornerSquare position="top-left" size="sm" />
        <span class="type-caption-xs font-bold text-primary uppercase">Sistem On-Grid</span>
        <h2 class="type-card-title mt-xs font-bold text-ink">PLTS On-Grid System</h2>
        <p class="type-body-sm mt-xs text-body">
          Tersambung jaringan PLN untuk memangkas tagihan listrik harian melalui skema net-metering.
        </p>
        <div class="mt-md">
          <Button variant="ghost-link" href="/solusi/plts-on-grid">Pelajari Arsitektur →</Button>
        </div>
      </div>

      <div class="relative border border-hairline bg-canvas p-xl">
        <CornerSquare position="top-left" size="sm" />
        <span class="type-caption-xs font-bold text-primary uppercase">Sistem Mandiri</span>
        <h2 class="type-card-title mt-xs font-bold text-ink">PLTS Off-Grid Mandiri</h2>
        <p class="type-body-sm mt-xs text-body">
          Sistem mandiri 100% dengan bank baterai LiFePO4 untuk daerah tanpa jaringan transmisi PLN.
        </p>
        <div class="mt-md">
          <Button variant="ghost-link" href="/solusi/plts-off-grid">Pelajari Arsitektur →</Button>
        </div>
      </div>

      <div class="relative border border-hairline bg-canvas p-xl">
        <CornerSquare position="top-left" size="sm" />
        <span class="type-caption-xs font-bold text-primary uppercase">Cadangan Kritis</span>
        <h2 class="type-card-title mt-xs font-bold text-ink">Backup Power / UPS Surya</h2>
        <p class="type-body-sm mt-xs text-body">
          Penyedia daya darurat instan tanpa jeda (zero transfer time) untuk server dan fasilitas
          penting.
        </p>
        <div class="mt-md">
          <Button variant="ghost-link" href="/solusi/backup-power-ups">
            Pelajari Arsitektur →
          </Button>
        </div>
      </div>
    </div>
  </Container>
</Section>
