<script lang="ts">
  import Container from '$lib/components/ui/Container.svelte';
  import Section from '$lib/components/ui/Section.svelte';
  import Button from '$lib/components/ui/Button.svelte';
  import CornerSquare from '$lib/components/ui/CornerSquare.svelte';
  import SeoHead from '$lib/components/layout/SeoHead.svelte';
  import Breadcrumb from '$lib/components/layout/Breadcrumb.svelte';
</script>

<SeoHead
  title="Kebijakan Privasi &amp; Syarat Layanan"
  description="Kebijakan privasi perlindungan data pribadi dan syarat ketentuan penggunaan website resmi PT. Indogreen Technology And Management."
/>

<Breadcrumb items={[{ label: 'Kebijakan Privasi' }]} />

<Section tone="light">
  <Container>
    <div class="relative mx-auto max-w-4xl border border-hairline bg-canvas p-xl tablet:p-xxl">
      <CornerSquare position="top-left" size="lg" />

      <div class="flex flex-col items-start gap-md">
        <span class="type-caption-xs font-bold text-mute uppercase">
          Kepatuhan Hukum &amp; Perlindungan Data
        </span>

        <h1 class="type-display-lg font-bold text-ink">
          Kebijakan Privasi &amp; Perlindungan Data
        </h1>

        <p class="type-body-md leading-relaxed text-body">
          PT. Indogreen Technology And Management berkomitmen menjunjung tinggi privasi dan
          melindungi data pribadi yang Anda serahkan saat menggunakan situs web dan layanan
          konsultasi kami, sesuai ketentuan Undang-Undang Perlindungan Data Pribadi (UU PDP No. 27
          Tahun 2022).
        </p>

        <div
          class="type-caption-sm mt-xs inline-flex items-center gap-xs rounded-sm border border-hairline bg-surface-soft px-md py-xs text-stone"
        >
          <span>
            TODO-CONTENT: Klausul hukum lengkap mengenai retensi data formulir dan hak subjek data
            diimplementasikan pada Fase 8.
          </span>
        </div>

        <div class="w-full border-t border-hairline pt-md">
          <Button variant="outline" size="md" href="/">Kembali ke Beranda</Button>
        </div>
      </div>
    </div>
  </Container>
</Section>
