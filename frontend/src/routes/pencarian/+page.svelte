<script lang="ts">
  import Container from '$lib/components/ui/Container.svelte';
  import Section from '$lib/components/ui/Section.svelte';
  import Button from '$lib/components/ui/Button.svelte';
  import CornerSquare from '$lib/components/ui/CornerSquare.svelte';
  import Icon from '$lib/components/ui/Icon.svelte';
  import SeoHead from '$lib/components/layout/SeoHead.svelte';
  import Breadcrumb from '$lib/components/layout/Breadcrumb.svelte';

  let searchQuery = $state('');
</script>

<SeoHead
  title="Pencarian Produk &amp; Solusi"
  description="Pencarian terpadu melintasi katalog produk PJU surya, komponen baterai, dan solusi sistem rekayasa EBT PT. Indogreen Technology And Management."
/>

<Breadcrumb items={[{ label: 'Pencarian' }]} />

<Section tone="light">
  <Container>
    <div class="relative mx-auto max-w-3xl border border-hairline bg-canvas p-xl tablet:p-xxl">
      <CornerSquare position="top-left" size="lg" />

      <div class="flex flex-col items-start gap-md">
        <span class="type-caption-xs font-bold text-primary uppercase">
          Pencarian Katalog &amp; Solusi
        </span>

        <h1 class="type-display-lg font-bold text-ink">Cari Produk atau Solusi EBT</h1>

        <!-- Search Input -->
        <div class="relative w-full">
          <input
            type="search"
            bind:value={searchQuery}
            placeholder="Ketik kata kunci, misalnya: Helios, On-Grid, Baterai LiFePO4..."
            class="type-body-md focus-ring h-12 w-full rounded-sm border border-hairline bg-canvas pr-md pl-xl text-ink outline-none"
            aria-label="Cari kata kunci"
          />
          <div
            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-md text-stone"
          >
            <Icon name="search" size={20} />
          </div>
        </div>

        <div
          class="type-caption-sm mt-xs inline-flex items-center gap-xs rounded-sm border border-hairline bg-surface-soft px-md py-xs text-stone"
        >
          <span>
            TODO-CONTENT: Integrasi API pencarian multi-entitas instan diimplementasikan pada Fase
            8.
          </span>
        </div>

        <div class="w-full border-t border-hairline pt-md">
          <Button variant="outline" size="md" href="/produk">Jelajahi Semua Produk</Button>
        </div>
      </div>
    </div>
  </Container>
</Section>
