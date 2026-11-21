<script lang="ts">
  import type { PageData } from './$types.js';
  import Container from '$lib/components/ui/Container.svelte';
  import Section from '$lib/components/ui/Section.svelte';
  import Button from '$lib/components/ui/Button.svelte';
  import ProductCard from '$lib/components/ui/ProductCard.svelte';
  import Badge from '$lib/components/ui/Badge.svelte';
  import Icon from '$lib/components/ui/Icon.svelte';
  import SeoHead from '$lib/components/layout/SeoHead.svelte';
  import Breadcrumb from '$lib/components/layout/Breadcrumb.svelte';
  import SubNav from '$lib/components/layout/SubNav.svelte';

  interface Props {
    data: PageData;
  }

  let { data }: Props = $props();

  const subNavItems = $derived([
    { label: 'Semua Produk', href: '/produk' },
    ...data.categories.map((c) => ({
      label: c.name,
      href: `/produk/${c.slug}`
    }))
  ]);

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
        name: data.category.name,
        item: `https://indogreen.id/produk/${data.category.slug}`
      }
    ]
  });
</script>

<SeoHead
  title={`Kategori ${data.category.name}`}
  description={data.category.description ||
    `Daftar spesifikasi produk kategori ${data.category.name} PT. Indogreen Technology And Management.`}
  jsonLd={breadcrumbJsonLd}
/>

<Breadcrumb items={[{ label: 'Produk', href: '/produk' }, { label: data.category.name }]} />

<SubNav
  items={subNavItems}
  activeHref={`/produk/${data.category.slug}`}
  ariaLabel="Kategori Produk"
/>

<Section tone="light" class="border-none">
  <Container>
    <!-- Category Header -->
    <div class="mb-xl flex flex-col items-start gap-xs">
      <div class="flex items-center gap-sm">
        <span class="type-caption-md font-bold tracking-wider text-mute uppercase">
          KATEGORI PRODUK
        </span>
        <Badge variant="default">{data.products.length} Produk Tersedia</Badge>
      </div>

      <h1 class="type-display-lg font-bold text-ink">
        {data.category.name}
      </h1>

      {#if data.category.description}
        <p class="type-body-md max-w-3xl leading-relaxed text-body">
          {data.category.description}
        </p>
      {/if}
    </div>

    <!-- Product Grid or Empty State -->
    {#if data.products.length > 0}
      <div
        class="grid grid-cols-1 gap-xl tablet:grid-cols-2 desktop-small:grid-cols-3 desktop:grid-cols-4"
        data-testid="category-products-grid"
      >
        {#each data.products as product (product.id)}
          <ProductCard
            title={product.name}
            category={data.category.name}
            description={product.short_description || undefined}
            imageSrc={product.featured_image?.card ||
              product.featured_image?.original ||
              '/images/product-pju-placeholder.svg'}
            imageAlt={product.featured_image?.alt || product.name}
            href={`/produk/${data.category.slug}/${product.slug}`}
            ctaText="Lihat Spesifikasi"
          >
            {#snippet badge()}
              {#if product.badge_tag}
                <Badge variant="default">{product.badge_tag}</Badge>
              {/if}
            {/snippet}
          </ProductCard>
        {/each}
      </div>
    {:else}
      <!-- Empty State -->
      <div
        class="flex flex-col items-center justify-center rounded-sm border border-hairline bg-surface-soft p-section text-center"
      >
        <div class="mb-md text-stone">
          <Icon name="package-open" size={48} />
        </div>
        <h2 class="type-heading-md font-bold text-ink">Belum Ada Produk Tersedia</h2>
        <p class="type-body-md mt-xs max-w-md text-body">
          Saat ini belum ada produk aktif yang terdaftar dalam kategori {data.category.name}.
        </p>
        <div class="mt-lg">
          <Button variant="outline" href="/produk">Kembali ke Katalog Produk</Button>
        </div>
      </div>
    {/if}
  </Container>
</Section>
