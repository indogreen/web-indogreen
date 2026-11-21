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

  const product = $derived(data.product);

  // Gallery images combined
  const galleryImages = $derived.by(() => {
    const list: Array<{ url: string; alt: string }> = [];
    if (product.featured_image?.original) {
      list.push({
        url: product.featured_image.original,
        alt: product.featured_image.alt || product.name
      });
    }
    if (product.gallery && product.gallery.length > 0) {
      for (const item of product.gallery) {
        if (item.original && !list.some((img) => img.url === item.original)) {
          list.push({
            url: item.original,
            alt: item.alt || product.name
          });
        }
      }
    }
    if (list.length === 0) {
      list.push({
        url: '/images/product-pju-placeholder.svg',
        alt: product.name
      });
    }
    return list;
  });

  let selectedImageIndex = $state(0);
  const currentImage = $derived(galleryImages[selectedImageIndex] || galleryImages[0]);

  // Structured Data (JSON-LD Product without price + BreadcrumbList)
  const productJsonLd = $derived({
    '@context': 'https://schema.org',
    '@type': 'Product',
    name: product.name,
    description: product.short_description || product.seo_description || '',
    image: galleryImages.map((img) => img.url),
    category: product.category.name,
    brand: {
      '@type': 'Brand',
      name: 'INDOGREEN'
    }
  });

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
        name: 'Produk',
        item: 'https://indogreen.id/produk'
      },
      {
        '@type': 'ListItem',
        position: 3,
        name: product.category.name,
        item: `https://indogreen.id/produk/${product.category.slug}`
      },
      {
        '@type': 'ListItem',
        position: 4,
        name: product.name,
        item: `https://indogreen.id/produk/${product.category.slug}/${product.slug}`
      }
    ]
  });
</script>

<SeoHead
  title={product.seo_title || product.name}
  description={product.seo_description ||
    product.short_description ||
    `Spesifikasi teknis resmi ${product.name} PT. Indogreen Technology And Management.`}
  jsonLd={[productJsonLd, breadcrumbJsonLd]}
/>

<Breadcrumb
  items={[
    { label: 'Produk', href: '/produk' },
    { label: product.category.name, href: `/produk/${product.category.slug}` },
    { label: product.name }
  ]}
/>

<!-- Main Product Overview Section -->
<Section tone="light" class="border-none">
  <Container>
    <div class="grid grid-cols-1 items-start gap-xl desktop:grid-cols-12">
      <!-- Left Column: Image Gallery (5 cols) -->
      <div class="flex flex-col gap-md desktop:col-span-6">
        <!-- Main Image Stage -->
        <div
          class="relative aspect-4/3 w-full overflow-hidden rounded-sm border border-hairline bg-surface-soft select-none"
        >
          <CornerSquare position="top-left" size="sm" />
          <img
            src={currentImage.url}
            alt={currentImage.alt}
            width="800"
            height="600"
            loading="eager"
            class="h-full w-full object-contain p-md"
          />
        </div>

        <!-- Thumbnail Strip (rendered if more than 1 image) -->
        {#if galleryImages.length > 1}
          <div
            class="flex items-center gap-xs overflow-x-auto py-xs"
            role="tablist"
            aria-label="Galeri Gambar Produk"
          >
            {#each galleryImages as img, idx (idx)}
              {@const isSelected = selectedImageIndex === idx}
              <button
                type="button"
                role="tab"
                aria-selected={isSelected}
                aria-label={`Lihat gambar produk ${idx + 1}`}
                onclick={() => (selectedImageIndex = idx)}
                class={[
                  'focus-ring relative h-20 w-20 shrink-0 overflow-hidden rounded-sm border bg-surface-soft p-1 transition-all',
                  isSelected
                    ? 'border-primary ring-1 ring-primary'
                    : 'border-hairline opacity-70 hover:opacity-100'
                ].join(' ')}
              >
                <img
                  src={img.url}
                  alt={img.alt}
                  width="80"
                  height="80"
                  loading="lazy"
                  class="h-full w-full object-cover"
                />
              </button>
            {/each}
          </div>
        {/if}
      </div>

      <!-- Right Column: Summary, Series & CTA (7 cols) -->
      <div class="flex flex-col items-start gap-md desktop:col-span-6">
        <div class="flex flex-wrap items-center gap-xs">
          <Badge variant="default">{product.category.name}</Badge>
          {#if product.model_series}
            <Badge variant="outline">Seri {product.model_series}</Badge>
          {/if}
          {#if product.badge_tag}
            <Badge variant="primary">{product.badge_tag}</Badge>
          {/if}
        </div>

        <!-- Single H1 on Product Detail Page -->
        <h1 class="type-display-lg font-bold text-ink">
          {product.name}
        </h1>

        {#if product.short_description}
          <p class="type-body-md leading-relaxed text-body">
            {product.short_description}
          </p>
        {/if}

        <!-- Primary Action CTAs -->
        <div
          class="mt-md flex w-full flex-wrap items-center gap-sm border-t border-b border-hairline py-lg"
        >
          <!-- CTA 'Minta Penawaran' ke /kontak?produk=slug -->
          <Button
            variant="primary"
            size="lg"
            href={`/kontak?produk=${encodeURIComponent(product.slug)}`}
          >
            Minta Penawaran
          </Button>

          <!-- Tombol Unduh Datasheet (Button-Outline) -->
          {#if product.datasheet_pdf_url}
            <Button
              variant="outline"
              size="lg"
              href={product.datasheet_pdf_url}
              target="_blank"
              rel="noopener noreferrer"
            >
              <Icon name="download" size={16} />
              <span>Unduh Datasheet</span>
            </Button>
          {/if}
        </div>

        <!-- Engineering Trust Highlights -->
        <div class="grid w-full grid-cols-1 gap-xs pt-xs tablet:grid-cols-2">
          <div class="flex items-center gap-xs text-mute">
            <Icon name="shield-check" size={18} class="text-primary" />
            <span class="type-caption-sm text-body">Garansi Resmi Pabrikan</span>
          </div>
          <div class="flex items-center gap-xs text-mute">
            <Icon name="wrench" size={18} class="text-primary" />
            <span class="type-caption-sm text-body">Ketersediaan Suku Cadang</span>
          </div>
          <div class="flex items-center gap-xs text-mute">
            <Icon name="truck" size={18} class="text-primary" />
            <span class="type-caption-sm text-body">Pengiriman ke Seluruh Indonesia</span>
          </div>
          <div class="flex items-center gap-xs text-mute">
            <Icon name="file-text" size={18} class="text-primary" />
            <span class="type-caption-sm text-body">Dukungan Dokumen Teknis &amp; Uji</span>
          </div>
        </div>
      </div>
    </div>
  </Container>
</Section>

<!-- Product Full Description / Features Section -->
{#if product.full_description}
  <Section tone="soft" class="border-none">
    <Container>
      <div class="max-w-4xl">
        <span class="type-caption-md font-bold tracking-wider text-mute uppercase">
          DESKRIPSI &amp; FITUR UNGGULAN
        </span>
        <h2 class="type-heading-xl mt-xs mb-md font-bold text-ink">
          Fitur &amp; Karakteristik Operasional
        </h2>
        <div class="prose max-w-none leading-relaxed text-body">
          <!-- eslint-disable-next-line svelte/no-at-html-tags -->
          {@html product.full_description}
        </div>
      </div>
    </Container>
  </Section>
{/if}

<!-- Technical Specifications Table (hairline, alternating surface-soft rows) -->
<Section tone="light" class="border-none">
  <Container>
    <div class="max-w-5xl">
      <span class="type-caption-md font-bold tracking-wider text-mute uppercase">
        LEMBAR DATA TEKNIS
      </span>
      <h2 class="type-heading-xl mt-xs mb-lg font-bold text-ink">Tabel Spesifikasi Teknis</h2>

      {#if product.specifications_grouped && Object.keys(product.specifications_grouped).length > 0}
        <div class="flex flex-col gap-xl">
          {#each Object.entries(product.specifications_grouped) as [groupTitle, specs] (groupTitle)}
            <div class="overflow-hidden rounded-sm border border-hairline bg-canvas">
              <!-- Group Table Header -->
              <div class="border-b border-hairline bg-surface-dark px-lg py-sm text-on-dark">
                <h3 class="type-card-title font-bold text-on-dark">
                  {groupTitle}
                </h3>
              </div>

              <!-- Specs Table -->
              <div class="overflow-x-auto">
                <table class="w-full border-collapse text-left">
                  <thead>
                    <tr
                      class="type-caption-sm border-b border-hairline bg-surface-soft font-bold text-mute uppercase"
                    >
                      <th class="w-1/2 p-md">Parameter Teknis</th>
                      <th class="w-1/2 p-md">Nilai &amp; Satuan</th>
                    </tr>
                  </thead>
                  <tbody>
                    {#each specs as spec, idx (idx)}
                      <tr
                        class={[
                          'type-body-sm border-b border-hairline/60 transition-colors last:border-b-0',
                          idx % 2 === 1 ? 'bg-surface-soft/60' : 'bg-canvas'
                        ].join(' ')}
                      >
                        <td class="p-md font-bold text-ink">
                          {spec.key}
                        </td>
                        <td class="p-md text-body">
                          <span>{spec.value}</span>
                          {#if spec.unit}
                            <span class="ml-xs font-bold text-mute">{spec.unit}</span>
                          {/if}
                        </td>
                      </tr>
                    {/each}
                  </tbody>
                </table>
              </div>
            </div>
          {/each}
        </div>
      {:else}
        <!-- Fallback Note when no grouped specifications from CMS -->
        <div class="rounded-sm border border-hairline bg-surface-soft p-xl">
          <p class="type-body-md text-mute">
            Spesifikasi teknis detail untuk seri produk ini dapat diunduh melalui lembar datasheet
            resmi atau dengan menghubungi sales engineering kami.
          </p>
        </div>
      {/if}
    </div>
  </Container>
</Section>

<!-- Related Products Section (Produk Terkait) -->
{#if data.relatedProducts.length > 0}
  <Section tone="soft" class="border-none">
    <Container>
      <div class="mb-xl flex items-center justify-between">
        <div>
          <span class="type-caption-md font-bold tracking-wider text-mute uppercase">
            REKOMENDASI PRODUK
          </span>
          <h2 class="type-heading-xl font-bold text-ink">Produk Terkait Lainnya</h2>
        </div>
        <Button variant="outline" href={`/produk/${product.category.slug}`}>
          Lihat Kategori Ini
        </Button>
      </div>

      <div class="grid grid-cols-1 gap-xl tablet:grid-cols-2 desktop:grid-cols-4">
        {#each data.relatedProducts as relProduct (relProduct.id)}
          <ProductCard
            title={relProduct.name}
            category={relProduct.category_name}
            description={relProduct.short_description || undefined}
            imageSrc={relProduct.featured_image?.card ||
              relProduct.featured_image?.original ||
              '/images/product-pju-placeholder.svg'}
            imageAlt={relProduct.featured_image?.alt || relProduct.name}
            href={`/produk/${relProduct.category_slug}/${relProduct.slug}`}
            ctaText="Lihat Spesifikasi"
          >
            {#snippet badge()}
              {#if relProduct.badge_tag}
                <Badge variant="default">{relProduct.badge_tag}</Badge>
              {/if}
            {/snippet}
          </ProductCard>
        {/each}
      </div>
    </Container>
  </Section>
{/if}

<!-- CTA Strip: Inquiry Guidance -->
<Section tone="dark" class="border-none py-section">
  <Container>
    <div
      class="flex flex-col items-start justify-between gap-lg tablet:flex-row tablet:items-center"
    >
      <div class="flex flex-col gap-xs desktop:max-w-2xl">
        <span class="type-caption-md font-bold tracking-wider text-accent-yellow uppercase">
          KONSULTASI SPESIFIKASI &amp; HARGA PROYEK
        </span>
        <h2 class="type-heading-xl font-bold text-on-dark">
          Membutuhkan Penawaran untuk {product.name}?
        </h2>
        <p class="type-body-md text-on-dark-mute">
          Tim sales engineering PT. Indogreen siap memberikan kalkulasi teknis, jadwal pengadaan,
          dan surat dukungan lelang proyek untuk kebutuhan instansi Anda.
        </p>
      </div>

      <div class="flex shrink-0 flex-wrap items-center gap-sm">
        <Button
          variant="primary"
          size="lg"
          href={`/kontak?produk=${encodeURIComponent(product.slug)}`}
        >
          Minta Penawaran
        </Button>
        <Button variant="outline-on-dark" size="lg" href="/produk">Katalog Lainnya</Button>
      </div>
    </div>
  </Container>
</Section>
