<script lang="ts">
  import { page } from '$app/state';
  import Container from '$lib/components/ui/Container.svelte';
  import Section from '$lib/components/ui/Section.svelte';
  import Button from '$lib/components/ui/Button.svelte';
  import CornerSquare from '$lib/components/ui/CornerSquare.svelte';
  import SeoHead from '$lib/components/layout/SeoHead.svelte';
  import Breadcrumb from '$lib/components/layout/Breadcrumb.svelte';

  const categorySlug = $derived(page.params.category || 'kategori');
  const productSlug = $derived(page.params.slug || 'produk');

  function formatTitle(slug: string): string {
    return slug
      .split('-')
      .map((w) => w.charAt(0).toUpperCase() + w.slice(1))
      .join(' ');
  }

  const categoryName = $derived(formatTitle(categorySlug));
  const productName = $derived(formatTitle(productSlug));
</script>

<SeoHead
  title={productName}
  description="Spesifikasi teknis resmi {productName} PT. Indogreen Technology And Management."
/>

<Breadcrumb
  items={[
    { label: 'Produk', href: '/produk' },
    { label: categoryName, href: `/produk/${categorySlug}` },
    { label: productName }
  ]}
/>

<Section tone="light">
  <Container>
    <div class="relative border border-hairline bg-canvas p-xl tablet:p-xxl">
      <CornerSquare position="top-left" size="lg" />

      <div class="flex flex-col items-start gap-md">
        <span class="type-caption-xs font-bold text-primary uppercase">
          Kategori: {categoryName}
        </span>

        <h1 class="type-display-lg font-bold text-ink">
          {productName}
        </h1>

        <p class="type-body-md max-w-2xl leading-relaxed text-body">
          Lembar spesifikasi teknis dan parameter operasional resmi {productName}.
        </p>

        <div
          class="type-caption-sm mt-xs inline-flex items-center gap-xs rounded-sm border border-hairline bg-surface-soft px-md py-xs text-stone"
        >
          <span>
            TODO-CONTENT: Spesifikasi teknis terinci, galeri foto, dan tombol unduh datasheet PDF
            diimplementasikan pada Fase 8.
          </span>
        </div>

        <div class="flex w-full flex-wrap items-center gap-sm border-t border-hairline pt-md">
          <!-- Exactly ONE solid green CTA per viewport -->
          <Button variant="primary" size="lg" href="/kontak">Minta Penawaran Harga</Button>

          <Button variant="outline" size="lg" href="/produk/{categorySlug}">
            Kembali ke Kategori
          </Button>
        </div>
      </div>
    </div>
  </Container>
</Section>
