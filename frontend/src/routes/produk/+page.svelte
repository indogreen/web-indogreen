<script lang="ts">
  import { goto } from '$app/navigation';
  import type { PageData } from './$types.js';
  import Container from '$lib/components/ui/Container.svelte';
  import Section from '$lib/components/ui/Section.svelte';
  import Button from '$lib/components/ui/Button.svelte';
  import ProductCard from '$lib/components/ui/ProductCard.svelte';
  import PillTabs from '$lib/components/ui/PillTabs.svelte';
  import Badge from '$lib/components/ui/Badge.svelte';
  import Icon from '$lib/components/ui/Icon.svelte';
  import SeoHead from '$lib/components/layout/SeoHead.svelte';
  import Breadcrumb from '$lib/components/layout/Breadcrumb.svelte';

  interface Props {
    data: PageData;
  }

  let { data }: Props = $props();

  const selectedCategoryObj = $derived(
    data.categories.find((c) => c.slug === data.selectedCategory)
  );

  const activeCategoryTitle = $derived(
    selectedCategoryObj ? selectedCategoryObj.name : 'Semua Produk'
  );

  const categoryTabs = $derived([
    { id: '', label: 'Semua Produk' },
    ...data.categories.map((c) => ({
      id: c.slug,
      label: c.name
    }))
  ]);

  function handleCategoryChange(tabId: string) {
    const targetUrl = tabId ? `/produk?kategori=${encodeURIComponent(tabId)}` : '/produk';
    void goto(targetUrl);
  }

  function getPaginationUrl(page: number): string {
    const parts: string[] = [];
    if (data.selectedCategory) {
      parts.push(`kategori=${encodeURIComponent(data.selectedCategory)}`);
    }
    if (page > 1) {
      parts.push(`page=${page}`);
    }
    return parts.length > 0 ? `/produk?${parts.join('&')}` : '/produk';
  }
</script>

<SeoHead
  title={data.selectedCategory
    ? `Produk ${activeCategoryTitle}`
    : 'Katalog Produk Tenaga Surya & EBT'}
  description={selectedCategoryObj?.description ||
    'Katalog resmi perangkat keras dan sistem tenaga surya PT. Indogreen Technology And Management: Lampu PJU Two-In-One, All-In-One, baterai LiFePO4, dan modul fotovoltaik.'}
/>

<Breadcrumb
  items={data.selectedCategory
    ? [{ label: 'Produk', href: '/produk' }, { label: activeCategoryTitle }]
    : [{ label: 'Produk' }]}
/>

<Section tone="light" class="border-none">
  <Container>
    <!-- Header -->
    <div class="mb-xl flex flex-col items-start gap-xs">
      <span class="type-caption-md font-bold tracking-wider text-mute uppercase">
        KATALOG PERANGKAT KERAS
      </span>
      <h1 class="type-display-lg font-bold text-ink">
        {data.selectedCategory ? `Produk: ${activeCategoryTitle}` : 'Katalog Produk Tenaga Surya'}
      </h1>
      <p class="type-body-md max-w-3xl leading-relaxed text-body">
        {selectedCategoryObj?.description ||
          'Perangkat sistem energi baru dan terbarukan berkualitas tinggi yang dirancang untuk efisiensi maksimal, didukung garansi resmi dan ketersediaan suku cadang purna jual.'}
      </p>
    </div>

    <!-- Category PillTabs (Filter state mirrored in URL ?kategori=) -->
    <div class="mb-xl flex flex-col gap-sm">
      <span class="type-caption-sm font-bold text-mute uppercase"> Pilih Kategori: </span>
      <div class="flex flex-wrap items-center gap-xs">
        <PillTabs
          tabs={categoryTabs}
          activeTab={data.selectedCategory}
          onchange={handleCategoryChange}
        />
      </div>
    </div>

    <!-- Product Grid or Empty State -->
    {#if data.products.length > 0}
      <div
        class="grid grid-cols-1 gap-xl tablet:grid-cols-2 desktop-small:grid-cols-3 desktop:grid-cols-4"
        data-testid="product-grid"
      >
        {#each data.products as product (product.id)}
          <ProductCard
            title={product.name}
            category={product.category_name}
            description={product.short_description || undefined}
            imageSrc={product.featured_image?.card ||
              product.featured_image?.original ||
              '/images/product-pju-placeholder.svg'}
            imageAlt={product.featured_image?.alt || product.name}
            href={`/produk/${product.category_slug}/${product.slug}`}
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

      <!-- Pagination Controls -->
      {#if data.meta && typeof data.meta.last_page === 'number' && data.meta.last_page > 1}
        {@const lastPage = data.meta.last_page}
        <nav
          class="mt-xxl flex flex-wrap items-center justify-center gap-xs border-t border-hairline pt-xl"
          aria-label="Paginasi Katalog Produk"
        >
          <!-- Previous Button -->
          {#if data.currentPage > 1}
            <a
              href={getPaginationUrl(data.currentPage - 1)}
              class="focus-ring type-button-sm flex h-11 min-w-[44px] items-center justify-center rounded-sm border border-hairline bg-canvas px-md font-bold text-ink hover:bg-surface-soft"
              aria-label="Halaman sebelumnya"
            >
              <Icon name="chevron-left" size={16} />
              <span class="ml-xs hidden tablet:inline">Sebelumnya</span>
            </a>
          {:else}
            <span
              class="type-button-sm flex h-11 min-w-[44px] cursor-not-allowed items-center justify-center rounded-sm border border-hairline bg-surface-soft px-md font-bold text-ash opacity-60 select-none"
              aria-disabled="true"
            >
              <Icon name="chevron-left" size={16} />
              <span class="ml-xs hidden tablet:inline">Sebelumnya</span>
            </span>
          {/if}

          <!-- Page Numbers -->
          {#each Array.from({ length: lastPage }, (_, i) => i + 1) as pageNum (pageNum)}
            {@const isCurrent = pageNum === data.currentPage}
            {#if isCurrent}
              <span
                class="type-button-sm flex h-11 w-11 items-center justify-center rounded-sm border border-ink bg-ink font-bold text-on-dark select-none"
                aria-current="page"
              >
                {pageNum}
              </span>
            {:else}
              <a
                href={getPaginationUrl(pageNum)}
                class="focus-ring type-button-sm flex h-11 w-11 items-center justify-center rounded-sm border border-hairline bg-canvas font-bold text-ink hover:bg-surface-soft"
              >
                {pageNum}
              </a>
            {/if}
          {/each}

          <!-- Next Button -->
          {#if data.currentPage < lastPage}
            <a
              href={getPaginationUrl(data.currentPage + 1)}
              class="focus-ring type-button-sm flex h-11 min-w-[44px] items-center justify-center rounded-sm border border-hairline bg-canvas px-md font-bold text-ink hover:bg-surface-soft"
              aria-label="Halaman selanjutnya"
            >
              <span class="mr-xs hidden tablet:inline">Selanjutnya</span>
              <Icon name="chevron-right" size={16} />
            </a>
          {:else}
            <span
              class="type-button-sm flex h-11 min-w-[44px] cursor-not-allowed items-center justify-center rounded-sm border border-hairline bg-surface-soft px-md font-bold text-ash opacity-60 select-none"
              aria-disabled="true"
            >
              <span class="mr-xs hidden tablet:inline">Selanjutnya</span>
              <Icon name="chevron-right" size={16} />
            </span>
          {/if}
        </nav>
      {/if}
    {:else}
      <!-- Empty State -->
      <div
        class="flex flex-col items-center justify-center rounded-sm border border-hairline bg-surface-soft p-section text-center"
        data-testid="product-empty-state"
      >
        <div class="mb-md text-stone">
          <Icon name="package-open" size={48} />
        </div>
        <h2 class="type-heading-md font-bold text-ink">Tidak Ada Produk Ditemukan</h2>
        <p class="type-body-md mt-xs max-w-md text-body">
          {data.selectedCategory
            ? `Belum ada produk aktif yang terdaftar dalam kategori ${activeCategoryTitle}.`
            : 'Belum ada produk aktif yang tersedia saat ini.'}
        </p>
        <div class="mt-lg">
          <Button variant="outline" href="/produk">Tampilkan Semua Produk</Button>
        </div>
      </div>
    {/if}
  </Container>
</Section>
