<script lang="ts">
  import { page } from '$app/state';
  import Container from '$lib/components/ui/Container.svelte';
  import Section from '$lib/components/ui/Section.svelte';
  import Button from '$lib/components/ui/Button.svelte';
  import CornerSquare from '$lib/components/ui/CornerSquare.svelte';
  import SeoHead from '$lib/components/layout/SeoHead.svelte';
  import Breadcrumb from '$lib/components/layout/Breadcrumb.svelte';

  const slug = $derived(page.params.slug || 'solusi');

  function formatTitle(str: string): string {
    return str
      .split('-')
      .map((w) => w.charAt(0).toUpperCase() + w.slice(1))
      .join(' ');
  }

  const solutionName = $derived(formatTitle(slug));
</script>

<SeoHead
  title={solutionName}
  description="Arsitektur rekayasa dan spesifikasi sistem {solutionName} PT. Indogreen Technology And Management."
/>

<Breadcrumb items={[{ label: 'Solusi', href: '/solusi' }, { label: solutionName }]} />

<Section tone="light">
  <Container>
    <div class="relative border border-hairline bg-canvas p-xl tablet:p-xxl">
      <CornerSquare position="top-left" size="lg" />

      <div class="flex flex-col items-start gap-md">
        <span class="type-caption-xs font-bold text-primary uppercase"> Rekayasa Sistem EBT </span>

        <h1 class="type-display-lg font-bold text-ink">
          {solutionName}
        </h1>

        <p class="type-body-md max-w-2xl leading-relaxed text-body">
          Penjelasan arsitektur sistem, komponen terintegrasi, dan estimasi reduksi biaya energi
          untuk {solutionName}.
        </p>

        <div
          class="type-caption-sm mt-xs inline-flex items-center gap-xs rounded-sm border border-hairline bg-surface-soft px-md py-xs text-stone"
        >
          <span>
            TODO-CONTENT: Diagram sistem interaktif dan daftar komponen teknis diimplementasikan
            pada Fase 8.
          </span>
        </div>

        <div class="flex w-full flex-wrap items-center gap-sm border-t border-hairline pt-md">
          <!-- Exactly ONE solid green CTA per viewport -->
          <Button variant="primary" size="lg" href="/kontak">Konsultasi Proyek Sistem</Button>

          <Button variant="outline" size="lg" href="/solusi">Kembali ke Katalog Solusi</Button>
        </div>
      </div>
    </div>
  </Container>
</Section>
