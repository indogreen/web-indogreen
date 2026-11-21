<script lang="ts">
  import type { PageData } from './$types.js';
  import Container from '$lib/components/ui/Container.svelte';
  import Section from '$lib/components/ui/Section.svelte';
  import Button from '$lib/components/ui/Button.svelte';
  import FeatureCard from '$lib/components/ui/FeatureCard.svelte';
  import Icon from '$lib/components/ui/Icon.svelte';
  import SeoHead from '$lib/components/layout/SeoHead.svelte';
  import Breadcrumb from '$lib/components/layout/Breadcrumb.svelte';
  import SubNav from '$lib/components/layout/SubNav.svelte';
  import type { IconName } from '$lib/components/ui/types.js';

  interface Props {
    data: PageData;
  }

  let { data }: Props = $props();

  const subNavItems = $derived([
    { label: 'Semua Solusi', href: '/solusi' },
    ...data.solutions.map((s) => ({
      label: s.name,
      href: `/solusi/${s.slug}`
    }))
  ]);

  function getSolutionIcon(slug: string): IconName {
    if (slug.includes('on-grid') && !slug.includes('hybrid')) return 'sun';
    if (slug.includes('hybrid')) return 'cpu';
    if (slug.includes('off-grid')) return 'battery-charging';
    if (slug.includes('backup') || slug.includes('ups')) return 'shield-check';
    return 'zap';
  }

  const breadcrumbJsonLd = $derived({
    '@context': 'https://schema.org',
    '@type': 'BreadcrumbList',
    itemListElement: [
      {
        '@type': 'ListItem',
        position: 1,
        name: 'Beranda',
        item: 'https://indogreen.id/'
      },
      {
        '@type': 'ListItem',
        position: 2,
        name: 'Solusi Rekayasa EBT',
        item: 'https://indogreen.id/solusi'
      }
    ]
  });
</script>

<SeoHead
  title="Solusi Rekayasa Sistem EBT & PLTS"
  description="Layanan rekayasa sistem tenaga surya PT. Indogreen Technology And Management: PLTS On-Grid atap, sistem Off-Grid mandiri, sistem hybrid cerdas, dan cadangan daya UPS bebas kedip."
  jsonLd={breadcrumbJsonLd}
/>

<Breadcrumb items={[{ label: 'Solusi' }]} />
<SubNav items={subNavItems} activeHref="/solusi" ariaLabel="Navigasi Solusi EBT" />

<!-- Header Introduction Section -->
<Section tone="light" class="border-none">
  <Container>
    <div class="mb-xl flex flex-col items-start gap-xs">
      <span class="type-caption-md font-bold tracking-wider text-mute uppercase">
        REKAYASA SISTEM ENERGI
      </span>
      <h1 class="type-display-lg font-bold text-ink">Solusi Rekayasa Sistem Energi Surya</h1>
      <p class="type-body-md max-w-3xl leading-relaxed text-body">
        Integrasi sistem PLTS terstandarisasi untuk memangkas pengeluaran energi operasional
        komersial &amp; industri, menjamin kontinuitas daya cadangan tanpa jeda, serta mendukung
        program dekarbonisasi perusahaan Anda.
      </p>
    </div>

    <!-- Solutions FeatureCard Grid -->
    <div
      class="grid grid-cols-1 gap-xl tablet:grid-cols-2 desktop:grid-cols-3"
      data-testid="solutions-grid"
    >
      {#each data.solutions as solution (solution.id)}
        <div class="flex flex-col justify-between">
          <FeatureCard
            title={solution.name}
            description={solution.summary}
            icon={getSolutionIcon(solution.slug)}
            hasCornerSquare={true}
          />
          <div class="mt-xs pt-xs">
            <a
              href={`/solusi/${solution.slug}`}
              class="type-button-md focus-ring inline-flex items-center gap-xs font-bold text-primary hover:underline"
            >
              <span>Pelajari Arsitektur</span>
              <Icon name="arrow-right" size={16} ariaHidden={true} />
            </a>
          </div>
        </div>
      {/each}
    </div>
  </Container>
</Section>

<!-- Engineering Process Overview Section -->
<Section tone="soft" class="border-none">
  <Container>
    <div class="mb-xl flex flex-col items-start gap-xs">
      <span class="type-caption-md font-bold tracking-wider text-mute uppercase">
        STANDAR KONTRAKTOR EPC
      </span>
      <h2 class="type-heading-xl font-bold text-ink">Tahapan Implementasi Proyek Sistem</h2>
      <p class="type-body-md max-w-2xl text-body">
        Metodologi teruji dari audit beban kelistrikan hingga komisioning akhir di lapangan.
      </p>
    </div>

    <div class="grid grid-cols-1 gap-lg tablet:grid-cols-2 desktop:grid-cols-4">
      <div class="flex flex-col gap-xs rounded-sm border border-hairline bg-canvas p-xl">
        <span class="type-display-lg font-bold text-primary">01</span>
        <h3 class="type-card-title font-bold text-ink">Audit &amp; Desain Teknis</h3>
        <p class="type-body-sm text-body">
          Pengukuran kurva beban harian, evaluasi sudut irradiasi matahari lokasi, dan simulasi daya
          akurat.
        </p>
      </div>

      <div class="flex flex-col gap-xs rounded-sm border border-hairline bg-canvas p-xl">
        <span class="type-display-lg font-bold text-primary">02</span>
        <h3 class="type-card-title font-bold text-ink">Pengadaan Komponen Tier-1</h3>
        <p class="type-body-sm text-body">
          Pemilihan panel fotovoltaik, inverter bersertifikasi, dan baterai LiFePO4 bergaransi
          resmi.
        </p>
      </div>

      <div class="flex flex-col gap-xs rounded-sm border border-hairline bg-canvas p-xl">
        <span class="type-display-lg font-bold text-primary">03</span>
        <h3 class="type-card-title font-bold text-ink">Instalasi &amp; Komisioning</h3>
        <p class="type-body-sm text-body">
          Pemasangan bracket anti-korosi, pengkabelan standar PUIL, dan pengujian performa sistem.
        </p>
      </div>

      <div class="flex flex-col gap-xs rounded-sm border border-hairline bg-canvas p-xl">
        <span class="type-display-lg font-bold text-primary">04</span>
        <h3 class="type-card-title font-bold text-ink">Monitoring &amp; Perawatan</h3>
        <p class="type-body-sm text-body">
          Sistem pemantauan kinerja harian dan inspeksi berkala untuk keandalan jangka panjang.
        </p>
      </div>
    </div>
  </Container>
</Section>

<!-- CTA Strip: Project Consultation -->
<Section tone="dark" class="border-none py-section">
  <Container>
    <div
      class="flex flex-col items-start justify-between gap-lg tablet:flex-row tablet:items-center"
    >
      <div class="flex flex-col gap-xs desktop:max-w-2xl">
        <span class="type-caption-md font-bold tracking-wider text-accent-yellow uppercase">
          KONSULTASI PERENCANAAN PROYEK
        </span>
        <h2 class="type-heading-xl font-bold text-on-dark">
          Ingin Menghitung Potensi Penghematan Energi Anda?
        </h2>
        <p class="type-body-md text-on-dark-mute">
          Konsultasikan kapasitas daya terpasang dan kelayakan teknis atap surya bersama spesialis
          rekayasa sistem PT. Indogreen.
        </p>
      </div>

      <div class="flex shrink-0 flex-wrap items-center gap-sm">
        <Button variant="primary" size="lg" href="/kontak">Konsultasi Rekayasa</Button>
        <Button variant="outline-on-dark" size="lg" href="/produk">Katalog Perangkat</Button>
      </div>
    </div>
  </Container>
</Section>
