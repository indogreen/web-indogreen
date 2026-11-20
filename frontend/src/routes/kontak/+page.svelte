<script lang="ts">
  import Container from '$lib/components/ui/Container.svelte';
  import Section from '$lib/components/ui/Section.svelte';
  import CornerSquare from '$lib/components/ui/CornerSquare.svelte';
  import Icon from '$lib/components/ui/Icon.svelte';
  import SeoHead from '$lib/components/layout/SeoHead.svelte';
  import Breadcrumb from '$lib/components/layout/Breadcrumb.svelte';
</script>

<SeoHead
  title="Hubungi Kami &amp; Lokasi Kantor"
  description="Hubungi tim sales engineering PT. Indogreen Technology And Management untuk konsultasi proyek PLTS, pengadaan PJU surya, dan permohonan penawaran teknis."
/>

<Breadcrumb items={[{ label: 'Kontak' }]} />

<Section tone="light">
  <Container>
    <div class="mb-xl flex flex-col gap-xs">
      <h1 class="type-display-lg font-bold text-ink">Kontak &amp; Konsultasi Rekayasa EBT</h1>
      <p class="type-body-md max-w-3xl text-body">
        Konsultasikan kebutuhan proyek penerangan jalan umum tenaga surya, instalasi PLTS atap
        gedung, atau pengadaan lelang LPSE dengan tim kami.
      </p>

      <div
        class="type-caption-sm mt-sm inline-flex items-center gap-xs rounded-sm border border-hairline bg-surface-soft px-md py-xs text-stone"
      >
        <span>
          TODO-CONTENT: Formulir konsultasi interaktif dengan validasi realtime diimplementasikan
          pada Fase 8.
        </span>
      </div>
    </div>

    <div class="grid grid-cols-1 gap-xl tablet:grid-cols-2">
      <!-- Office Location Card 1 -->
      <div class="relative border border-hairline bg-canvas p-xl">
        <CornerSquare position="top-left" size="sm" />
        <span class="type-caption-xs font-bold text-primary uppercase">Kantor Utama</span>
        <h2 class="type-card-title mt-xs font-bold text-ink">Kantor Utama Bogor</h2>
        <div class="type-body-sm mt-md flex flex-col gap-sm text-body">
          <p class="flex items-start gap-xs">
            <Icon name="map-pin" size={18} class="mt-0.5 shrink-0 text-primary" />
            <span>
              Ruko Taman Yasmin Sektor 6 No. 226, Jl. KH. Abdullah Bin Nuh, Kota Bogor, Jawa Barat
              16113
            </span>
          </p>
          <p class="flex items-center gap-xs">
            <Icon name="phone" size={18} class="shrink-0 text-primary" />
            <a href="tel:+622517541234" class="text-primary hover:underline">+62 251 754 1234</a>
          </p>
          <p class="flex items-center gap-xs">
            <Icon name="mail" size={18} class="shrink-0 text-primary" />
            <a href="mailto:marketing@indogreen.id" class="text-primary hover:underline">
              marketing@indogreen.id
            </a>
          </p>
        </div>
      </div>

      <!-- Office Location Card 2 -->
      <div class="relative border border-hairline bg-canvas p-xl">
        <CornerSquare position="top-left" size="sm" />
        <span class="type-caption-xs font-bold text-primary uppercase">Kantor Perwakilan</span>
        <h2 class="type-card-title mt-xs font-bold text-ink">Kantor Perwakilan Bandung</h2>
        <div class="type-body-sm mt-md flex flex-col gap-sm text-body">
          <p class="flex items-start gap-xs">
            <Icon name="map-pin" size={18} class="mt-0.5 shrink-0 text-primary" />
            <span>
              Gedung Wisma Bumiputera Lt. 7, Jl. Asia Afrika No. 141-149, Kota Bandung, Jawa Barat
              40112
            </span>
          </p>
          <p class="flex items-center gap-xs">
            <Icon name="phone" size={18} class="shrink-0 text-primary" />
            <a href="tel:+62224205678" class="text-primary hover:underline">+62 22 420 5678</a>
          </p>
          <p class="flex items-center gap-xs">
            <Icon name="phone" size={18} class="shrink-0 text-primary" />
            <a
              href="https://wa.me/6281112345678"
              target="_blank"
              rel="noopener noreferrer"
              class="text-primary hover:underline"
            >
              WhatsApp: +62 811 1234 5678
            </a>
          </p>
        </div>
      </div>
    </div>
  </Container>
</Section>
