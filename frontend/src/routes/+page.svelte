<script lang="ts">
  import Container from '$lib/components/ui/Container.svelte';
  import Section from '$lib/components/ui/Section.svelte';
  import Button from '$lib/components/ui/Button.svelte';
  import CornerSquare from '$lib/components/ui/CornerSquare.svelte';
  import SeoHead from '$lib/components/layout/SeoHead.svelte';
</script>

<SeoHead
  title="Beranda"
  description="Solusi Rekayasa Energi Baru dan Terbarukan (EBT), PJU Tenaga Surya (TIO/AIO), PLTS Atap Residensial, dan Solar Home System PT. Indogreen Technology And Management."
/>

<!-- Hero Chapter Placeholder (Surface Dark #000000 per docs/DESIGN.md) -->
<Section tone="dark" class="border-b border-hairline-strong/50">
  <Container>
    <div class="relative flex flex-col items-start gap-md py-xl desktop:py-xxl">
      <CornerSquare position="top-left" size="lg" />

      <span class="type-caption-md font-bold tracking-wider text-accent-yellow uppercase">
        SOLAR ENERGY COMPANY · ENERGI RAMAH LINGKUNGAN
      </span>

      <h1 class="type-display-xl max-w-3xl font-bold text-on-dark">
        Rekayasa Sistem Energi Baru &amp; Terbarukan di Indonesia
      </h1>

      <p class="type-body-md max-w-2xl leading-relaxed text-on-dark-mute">
        Penyedia resmi Lampu Penerangan Jalan Umum (PJU) Tenaga Surya sistem Two-In-One dan
        All-In-One, PLTS Atap Residensial, Solar Home System, serta instalasi kelistrikan ramah
        lingkungan bergaransi resmi.
      </p>

      <div
        class="type-caption-sm mt-xs inline-flex items-center gap-xs rounded-sm border border-hairline-strong bg-surface-elevated px-md py-xs text-stone"
      >
        <span>
          TODO-CONTENT: Konten beranda final lengkap dengan slide banner dan agregasi data
          diimplementasikan pada Fase 7.
        </span>
      </div>

      <!-- Exactly ONE solid green CTA per viewport -->
      <div class="flex flex-wrap items-center gap-sm pt-md">
        <Button variant="primary" size="lg" href="/produk">Lihat Katalog Produk</Button>
        <Button variant="outline-on-dark" size="lg" href="/solusi">Pelajari Solusi EBT</Button>
      </div>
    </div>
  </Container>
</Section>

<!-- Overview Grid Placeholder (Canvas Surface) -->
<Section tone="light">
  <Container>
    <div class="grid grid-cols-1 gap-lg tablet:grid-cols-2 desktop:grid-cols-4">
      <div class="relative border border-hairline bg-canvas p-xl">
        <CornerSquare position="top-left" size="sm" />
        <h2 class="type-card-title mb-xs font-bold text-ink">PJU Tenaga Surya</h2>
        <p class="type-body-sm text-body">
          Sistem lampu jalan surya mandiri Two-In-One &amp; All-In-One seri Helios, Jupiter, dan
          Mars.
        </p>
        <div class="mt-md">
          <Button variant="ghost-link" href="/produk/pju-tenaga-surya">Detail Produk →</Button>
        </div>
      </div>

      <div class="relative border border-hairline bg-canvas p-xl">
        <CornerSquare position="top-left" size="sm" />
        <h2 class="type-card-title mb-xs font-bold text-ink">PLTS Residensial</h2>
        <p class="type-body-sm text-body">
          Pembangkit listrik tenaga surya atap hemat daya untuk hunian dan gedung komersial.
        </p>
        <div class="mt-md">
          <Button variant="ghost-link" href="/produk/plts-residential">Detail Produk →</Button>
        </div>
      </div>

      <div class="relative border border-hairline bg-canvas p-xl">
        <CornerSquare position="top-left" size="sm" />
        <h2 class="type-card-title mb-xs font-bold text-ink">Solusi Rekayasa EBT</h2>
        <p class="type-body-sm text-body">
          Sistem On-Grid, Off-Grid mandiri, dan Hybrid terintegrasi untuk kebutuhan industri.
        </p>
        <div class="mt-md">
          <Button variant="ghost-link" href="/solusi">Eksplorasi Solusi →</Button>
        </div>
      </div>

      <div class="relative border border-hairline bg-canvas p-xl">
        <CornerSquare position="top-left" size="sm" />
        <h2 class="type-card-title mb-xs font-bold text-ink">Tentang INDOGREEN</h2>
        <p class="type-body-sm text-body">
          Profil resmi perusahaan, legalitas badan usaha, sertifikasi, dan layanan purna jual.
        </p>
        <div class="mt-md">
          <Button variant="ghost-link" href="/tentang-kami">Profil Perusahaan →</Button>
        </div>
      </div>
    </div>
  </Container>
</Section>
