<script lang="ts">
  import type { PageData } from './$types.js';
  import Container from '$lib/components/ui/Container.svelte';
  import Section from '$lib/components/ui/Section.svelte';
  import Button from '$lib/components/ui/Button.svelte';
  import ProductCard from '$lib/components/ui/ProductCard.svelte';
  import Badge from '$lib/components/ui/Badge.svelte';
  import CornerSquare from '$lib/components/ui/CornerSquare.svelte';
  import Icon from '$lib/components/ui/Icon.svelte';
  import SeoHead from '$lib/components/layout/SeoHead.svelte';
  import Breadcrumb from '$lib/components/layout/Breadcrumb.svelte';

  interface Props {
    data: PageData;
  }

  let { data }: Props = $props();

  const solution = $derived(data.solution);

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
        name: 'Solusi',
        item: 'https://indogreen.id/solusi'
      },
      {
        '@type': 'ListItem',
        position: 3,
        name: solution.name,
        item: `https://indogreen.id/solusi/${solution.slug}`
      }
    ]
  });
</script>

<SeoHead
  title={solution.seo_title || solution.name}
  description={solution.seo_description ||
    solution.summary ||
    `Arsitektur rekayasa sistem ${solution.name} PT. Indogreen Technology And Management.`}
  jsonLd={breadcrumbJsonLd}
/>

<Breadcrumb items={[{ label: 'Solusi', href: '/solusi' }, { label: solution.name }]} />

<!-- Solution Header / Overview Section -->
<Section tone="light" class="border-none">
  <Container>
    <div class="relative border border-hairline bg-canvas p-xl tablet:p-xxl">
      <CornerSquare position="top-left" size="lg" />

      <div class="flex flex-col items-start gap-md">
        <div class="flex items-center gap-xs">
          <Badge variant="default">Sistem {solution.system_type}</Badge>
          <span class="type-caption-xs font-bold text-mute uppercase"> REKAYASA SISTEM EBT </span>
        </div>

        <!-- Single H1 on Solution Detail Page -->
        <h1 class="type-display-lg font-bold text-ink">
          {solution.name}
        </h1>

        <p class="type-body-md max-w-3xl leading-relaxed text-body">
          {solution.summary}
        </p>

        <div class="mt-sm flex w-full flex-wrap items-center gap-sm border-t border-hairline pt-md">
          <Button
            variant="primary"
            size="lg"
            href={`/kontak?solusi=${encodeURIComponent(solution.slug)}`}
          >
            Konsultasi Proyek Sistem
          </Button>

          <Button variant="outline" size="lg" href="/solusi">Lihat Solusi Lainnya</Button>
        </div>
      </div>
    </div>
  </Container>
</Section>

<!-- Diagram / Architectural Visual Section (if available) -->
{#if solution.diagram_image?.original}
  <Section tone="soft" class="border-none">
    <Container>
      <div class="max-w-4xl">
        <span class="type-caption-md font-bold tracking-wider text-mute uppercase">
          SKEMA DIAGRAM SISTEM
        </span>
        <h2 class="type-heading-xl mt-xs mb-md font-bold text-ink">
          Diagram Aliran Energi {solution.name}
        </h2>
        <div class="overflow-hidden rounded-sm border border-hairline bg-canvas p-md">
          <img
            src={solution.diagram_image.original}
            alt={solution.diagram_image.alt || `Diagram Sistem ${solution.name}`}
            width="1200"
            height="675"
            loading="lazy"
            class="h-auto w-full object-contain"
          />
        </div>
      </div>
    </Container>
  </Section>
{/if}

<!-- System Architecture & Principles Body Section -->
{#if solution.system_architecture}
  <Section tone="light" class="border-none">
    <Container>
      <div class="max-w-4xl">
        <span class="type-caption-md font-bold tracking-wider text-mute uppercase">
          PRINSIP KERJA &amp; ARSITEKTUR
        </span>
        <h2 class="type-heading-xl mt-xs mb-md font-bold text-ink">
          Penjelasan Teknis Arsitektur Sistem
        </h2>
        <div class="prose max-w-none leading-relaxed text-body">
          <!-- eslint-disable-next-line svelte/no-at-html-tags -->
          {@html solution.system_architecture}
        </div>
      </div>
    </Container>
  </Section>
{/if}

<!-- Benefits (Manfaat Utama) Section -->
{#if solution.benefits && solution.benefits.length > 0}
  <Section tone="soft" class="border-none">
    <Container>
      <div class="mb-xl max-w-3xl">
        <span class="type-caption-md font-bold tracking-wider text-mute uppercase">
          NILAI TAMBAH &amp; EFISIENSI
        </span>
        <h2 class="type-heading-xl mt-xs mb-xs font-bold text-ink">
          Keunggulan &amp; Manfaat Sistem
        </h2>
        <p class="type-body-md text-body">
          Parameter keandalan dan keuntungan investasi yang didapatkan dari instalasi sistem ini.
        </p>
      </div>

      <div class="grid grid-cols-1 gap-md tablet:grid-cols-2">
        {#each solution.benefits as benefit, idx (idx)}
          <div
            class="flex items-start gap-md rounded-sm border border-hairline bg-canvas p-lg transition-colors hover:border-primary"
          >
            <div class="mt-0.5 shrink-0 text-primary">
              <Icon name="check-circle" size={22} />
            </div>
            <p class="type-body-md font-bold text-ink">
              {benefit}
            </p>
          </div>
        {/each}
      </div>
    </Container>
  </Section>
{/if}

<!-- Included Components (Komponen Terintegrasi) Section -->
{#if solution.included_components && solution.included_components.length > 0}
  <Section tone="light" class="border-none">
    <Container>
      <div class="mb-xl max-w-3xl">
        <span class="type-caption-md font-bold tracking-wider text-mute uppercase">
          BILL OF MATERIALS (BOM)
        </span>
        <h2 class="type-heading-xl mt-xs mb-xs font-bold text-ink">
          Komponen &amp; Perangkat Terintegrasi
        </h2>
        <p class="type-body-md text-body">
          Daftar perangkat standar rekayasa yang disertakan dalam paket implementasi sistem.
        </p>
      </div>

      <div class="grid grid-cols-1 gap-md tablet:grid-cols-2 desktop:grid-cols-3">
        {#each solution.included_components as component, idx (idx)}
          <div
            class="flex items-center gap-sm rounded-sm border border-hairline bg-surface-soft p-md text-body"
          >
            <div class="shrink-0 text-primary">
              <Icon name="cpu" size={20} />
            </div>
            <span class="type-body-sm font-bold text-ink">
              {component}
            </span>
          </div>
        {/each}
      </div>
    </Container>
  </Section>
{/if}

<!-- Related Products Section (Produk Terkait) -->
{#if solution.products && solution.products.length > 0}
  <Section tone="soft" class="border-none">
    <Container>
      <div class="mb-xl flex items-center justify-between">
        <div>
          <span class="type-caption-md font-bold tracking-wider text-mute uppercase">
            INTEGRASI PERANGKAT KERAS
          </span>
          <h2 class="type-heading-xl font-bold text-ink">Produk Terkait Solusi Ini</h2>
        </div>
        <Button variant="outline" href="/produk">Katalog Produk</Button>
      </div>

      <div class="grid grid-cols-1 gap-xl tablet:grid-cols-2 desktop:grid-cols-4">
        {#each solution.products as prod (prod.id)}
          <ProductCard
            title={prod.name}
            category={prod.category_name}
            description={prod.short_description || undefined}
            imageSrc={prod.featured_image?.card ||
              prod.featured_image?.original ||
              '/images/product-pju-placeholder.svg'}
            imageAlt={prod.featured_image?.alt || prod.name}
            href={`/produk/${prod.category_slug}/${prod.slug}`}
            ctaText="Lihat Spesifikasi"
          />
        {/each}
      </div>
    </Container>
  </Section>
{/if}

<!-- CTA Strip: Project Consultation -->
<Section tone="dark" class="border-none py-section">
  <Container>
    <div
      class="flex flex-col items-start justify-between gap-lg tablet:flex-row tablet:items-center"
    >
      <div class="flex flex-col gap-xs desktop:max-w-2xl">
        <span class="type-caption-md font-bold tracking-wider text-accent-yellow uppercase">
          PERENCANAAN &amp; STUDI KELAYAKAN
        </span>
        <h2 class="type-heading-xl font-bold text-on-dark">
          Konsultasikan Proyek {solution.name} Anda
        </h2>
        <p class="type-body-md text-on-dark-mute">
          Tim spesialis PLTS PT. Indogreen siap membantu survei lokasi, kalkulasi penghematan kWh,
          dan penyusunan proposal teknis komprehensif.
        </p>
      </div>

      <div class="flex shrink-0 flex-wrap items-center gap-sm">
        <Button
          variant="primary"
          size="lg"
          href={`/kontak?solusi=${encodeURIComponent(solution.slug)}`}
        >
          Konsultasi Proyek
        </Button>
        <Button variant="outline-on-dark" size="lg" href="/solusi">Solusi Lainnya</Button>
      </div>
    </div>
  </Container>
</Section>
