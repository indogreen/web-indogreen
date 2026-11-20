<script lang="ts">
  import Container from '$lib/components/ui/Container.svelte';
  import Section from '$lib/components/ui/Section.svelte';
  import Button from '$lib/components/ui/Button.svelte';
  import CornerSquare from '$lib/components/ui/CornerSquare.svelte';
  import SeoHead from '$lib/components/layout/SeoHead.svelte';
  import Breadcrumb from '$lib/components/layout/Breadcrumb.svelte';
</script>

<SeoHead
  title="Tentang Kami"
  description="Profil resmi PT. Indogreen Technology And Management, pengembang dan penyedia sistem Energi Baru dan Terbarukan (EBT) di Indonesia."
/>

<Breadcrumb items={[{ label: 'Tentang Kami' }]} />

<Section tone="light">
  <Container>
    <div class="relative border border-hairline bg-canvas p-xl tablet:p-xxl">
      <CornerSquare position="top-left" size="lg" />

      <div class="flex flex-col items-start gap-md">
        <span class="type-caption-xs font-bold text-accent-yellow-deep uppercase">
          Profil Korporasi EBT
        </span>

        <h1 class="type-display-lg font-bold text-ink">PT. Indogreen Technology And Management</h1>

        <p class="type-body-md max-w-3xl leading-relaxed text-body">
          Perusahaan berbadan hukum resmi yang berfokus pada pembangunan dan pengembangan Energi
          Baru dan Terbarukan (EBT) di Indonesia, spesialis Lampu Penerangan Jalan Umum (PJU) Tenaga
          Surya dan Rekayasa PLTS.
        </p>

        <div
          class="type-caption-sm mt-xs inline-flex items-center gap-xs rounded-sm border border-hairline bg-surface-soft px-md py-xs text-stone"
        >
          <span>
            TODO-CONTENT: Sejarah perusahaan, visi &amp; misi, struktur legalitas, dan portofolio
            proyek riil diimplementasikan pada Fase 8.
          </span>
        </div>

        <div
          class="grid w-full grid-cols-1 gap-md border-t border-hairline pt-md tablet:grid-cols-3"
        >
          <div class="border border-hairline p-md">
            <h3 class="type-card-title font-bold text-ink">Visi Perusahaan</h3>
            <p class="type-body-sm mt-xs text-mute">
              Mendorong transisi energi bersih berkelanjutan di seluruh penjuru Indonesia.
            </p>
          </div>
          <div class="border border-hairline p-md">
            <h3 class="type-card-title font-bold text-ink">Standar Rekayasa</h3>
            <p class="type-body-sm mt-xs text-mute">
              Menggunakan modul surya Tier-1 dan baterai LiFePO4 teruji iklim tropis.
            </p>
          </div>
          <div class="border border-hairline p-md">
            <h3 class="type-card-title font-bold text-ink">Layanan Purna Jual</h3>
            <p class="type-body-sm mt-xs text-mute">
              Orientasi kepuasan pelanggan dengan jaminan garansi dan teknisi siaga.
            </p>
          </div>
        </div>

        <div class="pt-md">
          <!-- Exactly ONE solid green CTA per viewport -->
          <Button variant="primary" size="lg" href="/kontak">Hubungi Tim Kami</Button>
        </div>
      </div>
    </div>
  </Container>
</Section>
