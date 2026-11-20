<script lang="ts">
  import { page } from '$app/state';
  import Container from '$lib/components/ui/Container.svelte';
  import Section from '$lib/components/ui/Section.svelte';
  import Button from '$lib/components/ui/Button.svelte';
  import CornerSquare from '$lib/components/ui/CornerSquare.svelte';
  import Icon from '$lib/components/ui/Icon.svelte';
  import SeoHead from '$lib/components/layout/SeoHead.svelte';

  const status = $derived(page.status || 500);
  const is404 = $derived(status === 404);

  const title = $derived(
    is404 ? '404 - Halaman Tidak Ditemukan' : `${status} - Gangguan Server Internal`
  );

  const description = $derived(
    is404
      ? 'Maaf, halaman atau dokumen spesifikasi teknis yang Anda cari tidak tersedia atau telah dipindahkan.'
      : 'Terjadi kendala pada sistem server backend kami. Tim teknis sedang menangani kendala ini.'
  );
</script>

<SeoHead
  title={is404 ? 'Halaman Tidak Ditemukan (404)' : `Gangguan Server (${status})`}
  robots="noindex, nofollow"
/>

<Section tone="soft" class="flex min-h-[70vh] items-center justify-center">
  <Container>
    <div class="relative mx-auto max-w-2xl border border-hairline bg-canvas p-xl tablet:p-xxl">
      <!-- Signature Decorative Corner Square (Top-Left) -->
      <CornerSquare position="top-left" size="lg" />

      <div class="flex flex-col items-start gap-md">
        <!-- Error Status Badge -->
        <div
          class="inline-flex items-center gap-xs rounded-sm border border-hairline bg-surface-soft px-sm py-xs text-mute"
        >
          <Icon name={is404 ? 'info' : 'alert-triangle'} size={16} class="text-primary" />
          <span class="type-caption-md font-bold tracking-wider text-body uppercase">
            Status HTTP {status}
          </span>
        </div>

        <!-- Headline -->
        <h1 class="type-display-lg font-bold text-ink">
          {title}
        </h1>

        <!-- Explanatory Subtext -->
        <p class="type-body-md leading-relaxed text-body">
          {description}
        </p>

        <!-- Technical Suggestion -->
        <div class="type-body-sm w-full border-t border-hairline pt-md text-stone">
          {#if is404}
            <p>
              Pastikan alamat URL yang Anda masukkan sudah benar, atau gunakan tombol navigasi di
              bawah ini untuk kembali ke katalog utama EBT PT. Indogreen Technology And Management.
            </p>
          {:else}
            <p>
              Silakan segarkan kembali peramban Anda. Apabila kendala terus berlanjut, hubungi tim
              dukungan teknis kami melalui kontak resmi.
            </p>
          {/if}
        </div>

        <!-- Action CTAs: Max ONE solid green CTA per viewport -->
        <div class="flex flex-wrap items-center gap-sm pt-sm">
          <Button variant="primary" size="lg" href="/">Kembali ke Beranda</Button>

          <Button variant="outline" size="lg" href="/kontak">Hubungi Dukungan Teknis</Button>
        </div>
      </div>
    </div>
  </Container>
</Section>
