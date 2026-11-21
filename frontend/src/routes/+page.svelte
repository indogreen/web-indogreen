<script lang="ts">
  import { onMount } from 'svelte';
  import type { PageData } from './$types.js';
  import Container from '$lib/components/ui/Container.svelte';
  import Section from '$lib/components/ui/Section.svelte';
  import Button from '$lib/components/ui/Button.svelte';
  import CornerSquare from '$lib/components/ui/CornerSquare.svelte';
  import ProductCard from '$lib/components/ui/ProductCard.svelte';
  import FeatureCard from '$lib/components/ui/FeatureCard.svelte';
  import Icon from '$lib/components/ui/Icon.svelte';
  import SeoHead from '$lib/components/layout/SeoHead.svelte';
  import type { IconName } from '$lib/components/ui/types.js';

  interface Props {
    data: PageData;
  }

  let { data }: Props = $props();

  const slides = $derived(data.homeData.hero_slides || []);
  const hasMultipleSlides = $derived(slides.length > 1);

  let currentSlideIndex = $state(0);
  let isPlaying = $state(true);

  const activeSlide = $derived(
    slides[currentSlideIndex] || {
      id: 1,
      title: 'Lampu PJU Tenaga Surya Berkualitas Tinggi',
      subtitle:
        'Efisiensi maksimal dengan baterai LiFePO4 terintegrasi dan modul fotovoltaik Tier-1 bergaransi resmi.',
      button_text: 'Lihat Katalog Produk',
      button_url: '/produk',
      desktop_image: null,
      mobile_image: null,
      sort_order: 1
    }
  );

  function nextSlide() {
    if (slides.length <= 1) return;
    currentSlideIndex = (currentSlideIndex + 1) % slides.length;
  }

  function prevSlide() {
    if (slides.length <= 1) return;
    currentSlideIndex = (currentSlideIndex - 1 + slides.length) % slides.length;
  }

  function goToSlide(index: number) {
    currentSlideIndex = index;
  }

  function togglePlayPause() {
    isPlaying = !isPlaying;
  }

  function handleKeydown(e: KeyboardEvent) {
    if (!hasMultipleSlides) return;
    if (e.key === 'ArrowRight') {
      e.preventDefault();
      nextSlide();
    } else if (e.key === 'ArrowLeft') {
      e.preventDefault();
      prevSlide();
    } else if (e.key === 'Home') {
      e.preventDefault();
      goToSlide(0);
    } else if (e.key === 'End') {
      e.preventDefault();
      goToSlide(slides.length - 1);
    }
  }

  onMount(() => {
    let intervalId: ReturnType<typeof setInterval> | null = null;

    if (hasMultipleSlides && isPlaying) {
      intervalId = setInterval(() => {
        if (isPlaying) {
          nextSlide();
        }
      }, 6000);
    }

    return () => {
      if (intervalId) clearInterval(intervalId);
    };
  });

  // Map category slug to lucide icon safely
  function getCategoryIcon(slug: string, iconName?: string | null): IconName {
    if (iconName && ['sun', 'home', 'battery-charging', 'cpu', 'zap'].includes(iconName)) {
      return iconName as IconName;
    }
    if (slug.includes('pju')) return 'sun';
    if (slug.includes('residential')) return 'home';
    if (slug.includes('solar-home') || slug.includes('shs')) return 'battery-charging';
    if (slug.includes('aksesoris')) return 'cpu';
    return 'zap';
  }

  // Format title with yellow keyword on dark surface
  function formatHeroTitle(title: string): string {
    // If the title contains words like "Tenaga Surya" or "Energi Baru", wrap in yellow highlight
    if (title.includes('Tenaga Surya')) {
      return title.replace(
        'Tenaga Surya',
        '<span class="text-accent-yellow font-bold">Tenaga Surya</span>'
      );
    }
    if (title.includes('Energi Baru & Terbarukan')) {
      return title.replace(
        'Energi Baru & Terbarukan',
        '<span class="text-accent-yellow font-bold">Energi Baru &amp; Terbarukan</span>'
      );
    }
    return title;
  }
</script>

<SeoHead
  title="Solusi Rekayasa Energi Baru & Terbarukan"
  description={data.homeData.company.tagline ||
    'Penyedia resmi Lampu PJU Tenaga Surya Two-In-One dan All-In-One, PLTS Atap Residensial, dan Solar Home System PT. Indogreen Technology And Management.'}
/>

<!-- 1. HERO CHAPTER (Surface Dark per docs/DESIGN.md hero-card-dark) -->
<section
  class="relative min-h-[560px] w-full overflow-hidden bg-surface-dark text-on-dark tablet:min-h-[620px] desktop:min-h-[680px]"
  aria-label="Banner Utama Beranda"
>
  <!-- Background Image with Art Direction (16:9 Desktop to 4:5 Mobile via <picture>) -->
  <div class="absolute inset-0 z-0">
    <picture>
      <source
        media="(max-width: 639px)"
        srcset={activeSlide.mobile_image?.hero ||
          activeSlide.mobile_image?.original ||
          '/images/hero-mobile-placeholder.svg'}
        width="800"
        height="1000"
      />
      <img
        src={activeSlide.desktop_image?.hero ||
          activeSlide.desktop_image?.original ||
          '/images/hero-placeholder.svg'}
        alt={activeSlide.desktop_image?.alt || activeSlide.title}
        width="1920"
        height="1080"
        loading="eager"
        fetchpriority="high"
        class="h-full w-full object-cover object-right desktop:object-center"
      />
    </picture>

    <!-- Dark Gradient Overlay (Hugs left third for crisp text contrast) -->
    <div
      class="absolute inset-0 bg-gradient-to-t from-surface-dark via-surface-dark/85 to-surface-dark/40 tablet:bg-gradient-to-r tablet:from-surface-dark tablet:via-surface-dark/90 tablet:to-transparent"
    ></div>
  </div>

  <!-- Hero Content Layer -->
  <Container
    class="relative z-10 flex h-full min-h-[560px] items-center tablet:min-h-[620px] desktop:min-h-[680px]"
  >
    <div
      class="relative flex w-full flex-col items-start py-section desktop:max-w-2xl desktop:py-[80px]"
    >
      <CornerSquare position="top-left" size="lg" />

      <!-- Eyebrow label in yellow on dark surface -->
      <span class="type-caption-md mb-xs font-bold tracking-wider text-accent-yellow uppercase">
        SOLAR ENERGY COMPANY · ENERGI RAMAH LINGKUNGAN
      </span>

      <!-- Display-XL Headline with yellow keyword -->
      <h1 class="type-display-xl mb-md font-bold tracking-normal text-on-dark">
        <!-- eslint-disable-next-line svelte/no-at-html-tags -->
        {@html formatHeroTitle(activeSlide.title)}
      </h1>

      <!-- Subtitle -->
      {#if activeSlide.subtitle}
        <p class="type-heading-lg mb-xl max-w-xl text-on-dark-mute">
          {activeSlide.subtitle}
        </p>
      {/if}

      <!-- Single Primary CTA + Secondary Outline on Dark -->
      <div class="flex flex-wrap items-center gap-sm">
        <Button variant="primary" size="lg" href={activeSlide.button_url || '/produk'}>
          {activeSlide.button_text || 'Lihat Katalog Produk'}
        </Button>

        <Button variant="outline-on-dark" size="lg" href="/solusi">Pelajari Solusi EBT</Button>
      </div>
    </div>
  </Container>

  <!-- Simple Carousel Controls (Rendered ONLY if more than one slide exists) -->
  {#if hasMultipleSlides}
    <div
      class="absolute right-md bottom-lg z-20 flex items-center gap-xs rounded-sm border border-hairline-strong/60 bg-surface-dark/90 p-xs select-none tablet:right-xl tablet:bottom-xl"
      aria-label="Navigasi Slide Banner"
      role="toolbar"
      tabindex="0"
      onkeydown={handleKeydown}
    >
      <button
        type="button"
        onclick={prevSlide}
        aria-label="Slide sebelumnya"
        class="focus-ring flex h-11 w-11 items-center justify-center rounded-sm text-on-dark transition-colors hover:bg-surface-elevated"
      >
        <Icon name="chevron-left" size={20} />
      </button>

      <!-- Slide Indicators -->
      <div class="flex items-center gap-xs px-xs" role="tablist">
        {#each slides as slide, idx (slide.id)}
          <button
            type="button"
            role="tab"
            aria-selected={currentSlideIndex === idx}
            aria-label={`Pindah ke slide ${idx + 1}`}
            onclick={() => goToSlide(idx)}
            class={[
              'h-2.5 rounded-sm transition-all',
              currentSlideIndex === idx ? 'w-6 bg-primary' : 'w-2.5 bg-stone/60 hover:bg-stone'
            ].join(' ')}
          ></button>
        {/each}
      </div>

      <button
        type="button"
        onclick={nextSlide}
        aria-label="Slide berikutnya"
        class="focus-ring flex h-11 w-11 items-center justify-center rounded-sm text-on-dark transition-colors hover:bg-surface-elevated"
      >
        <Icon name="chevron-right" size={20} />
      </button>

      <div class="mx-xs h-4 w-px bg-hairline-strong"></div>

      <!-- Play / Pause Toggle Button -->
      <button
        type="button"
        onclick={togglePlayPause}
        aria-label={isPlaying ? 'Jeda tayangan slide' : 'Lanjutkan tayangan slide'}
        class="focus-ring flex h-11 w-11 items-center justify-center rounded-sm text-on-dark transition-colors hover:bg-surface-elevated"
      >
        <Icon name={isPlaying ? 'pause' : 'play'} size={18} />
      </button>
    </div>
  {/if}
</section>

<!-- 2. PROFIL PERUSAHAAN (Section Tone Light - 64px gap without decorative divider) -->
<Section tone="light" class="border-none">
  <Container>
    <div class="grid grid-cols-1 items-start gap-xl desktop:grid-cols-12">
      <!-- Left Column: Company Focus -->
      <div class="flex flex-col items-start gap-sm desktop:col-span-5">
        <span class="type-caption-md font-bold tracking-wider text-mute uppercase">
          PROFIL PERUSAHAAN
        </span>
        <h2 class="type-display-lg font-bold text-ink">
          Dedikasi untuk Kemandirian Energi Bersih Indonesia
        </h2>
        <p class="type-body-md leading-relaxed text-body">
          {data.homeData.company.company_name} berfokus pada pembangunan dan pengembangan pembangkit Energi
          Baru dan Terbarukan (EBT) berkualitas tinggi, dengan spesialisasi lampu jalan surya (PJU), sistem
          PLTS mandiri, dan integrasi kelistrikan ramah lingkungan.
        </p>
        <div class="pt-sm">
          <Button variant="outline" href="/tentang-kami">Pelajari Profil Perusahaan</Button>
        </div>
      </div>

      <!-- Right Column: 3 Pillars Grid -->
      <div class="grid grid-cols-1 gap-md tablet:grid-cols-3 desktop:col-span-7">
        <div class="flex flex-col gap-xs rounded-sm border border-hairline bg-surface-soft p-xl">
          <div class="text-primary">
            <Icon name="sun" size={24} />
          </div>
          <h3 class="type-card-title mt-xs font-bold text-ink">PJU Surya Mandiri</h3>
          <p class="type-body-sm text-body">
            Sistem Two-In-One &amp; All-In-One dengan baterai LiFePO4 dan controller cerdas MPPT
            untuk penerangan jalan raya tanpa jaringan PLN.
          </p>
        </div>

        <div class="flex flex-col gap-xs rounded-sm border border-hairline bg-surface-soft p-xl">
          <div class="text-primary">
            <Icon name="home" size={24} />
          </div>
          <h3 class="type-card-title mt-xs font-bold text-ink">PLTS Residensial &amp; Atap</h3>
          <p class="type-body-sm text-body">
            Solusi atap surya On-Grid dan Hybrid untuk memangkas pengeluaran listrik hunian dan
            gedung komersial secara signifikan.
          </p>
        </div>

        <div class="flex flex-col gap-xs rounded-sm border border-hairline bg-surface-soft p-xl">
          <div class="text-primary">
            <Icon name="shield-check" size={24} />
          </div>
          <h3 class="type-card-title mt-xs font-bold text-ink">Garansi &amp; Purna Jual</h3>
          <p class="type-body-sm text-body">
            Dukungan teknis berkala, ketersediaan suku cadang resmi, dan tim inspeksi engineering
            berpengalaman di berbagai wilayah Indonesia.
          </p>
        </div>
      </div>
    </div>
  </Container>
</Section>

<!-- 3. GRID KATEGORI PRODUK (4-up on desktop, 2-up on tablet, 1-up on mobile) -->
<Section tone="soft" class="border-none">
  <Container>
    <div
      class="mb-xl flex flex-col items-start justify-between gap-sm tablet:flex-row tablet:items-end"
    >
      <div>
        <span class="type-caption-md font-bold tracking-wider text-mute uppercase">
          PERANGKAT KERAS &amp; SISTEM EBT
        </span>
        <h2 class="type-display-lg font-bold text-ink">Kategori Produk Tenaga Surya</h2>
      </div>
      <Button variant="outline" href="/produk">Buka Katalog Lengkap</Button>
    </div>

    <div class="grid grid-cols-1 gap-xl tablet:grid-cols-2 desktop:grid-cols-4">
      {#each data.homeData.categories as category (category.id)}
        <ProductCard
          title={category.name}
          category="Kategori Produk"
          description={category.description ||
            'Perangkat sistem tenaga surya teruji bergaransi resmi.'}
          imageSrc={category.image?.card ||
            category.image?.original ||
            '/images/product-pju-placeholder.svg'}
          imageAlt={`Kategori ${category.name}`}
          href={`/produk/${category.slug}`}
          ctaText="Lihat Produk"
        />
      {/each}
    </div>
  </Container>
</Section>

<!-- 4. SOLUSI PERUMAHAN & INDUSTRI (FeatureCard Grid) -->
<Section tone="light" class="border-none">
  <Container>
    <div
      class="mb-xl flex flex-col items-start justify-between gap-sm tablet:flex-row tablet:items-end"
    >
      <div>
        <span class="type-caption-md font-bold tracking-wider text-mute uppercase">
          INTEGRASI SISTEM SURYA
        </span>
        <h2 class="type-display-lg font-bold text-ink">Solusi Rekayasa Sistem EBT</h2>
      </div>
      <Button variant="outline" href="/solusi">Lihat Seluruh Solusi</Button>
    </div>

    <div class="grid grid-cols-1 gap-xl tablet:grid-cols-2 desktop:grid-cols-3">
      {#each data.homeData.solutions as solution (solution.id)}
        <div class="flex flex-col justify-between">
          <FeatureCard
            title={solution.name}
            description={solution.summary}
            icon={getCategoryIcon(solution.slug)}
            hasCornerSquare={true}
          />
          <div class="mt-xs pt-xs">
            <a
              href={`/solusi/${solution.slug}`}
              class="type-button-md focus-ring inline-flex items-center gap-xs font-bold text-primary hover:underline"
            >
              <span>Pelajari Arsitektur</span>
              <Icon name="arrow-right" size={16} ariaHidden={true} />
            </a>
          </div>
        </div>
      {/each}
    </div>
  </Container>
</Section>

<!-- 5. CALLOUT-STAT: HANYA bila data nyata tersedia dari CMS, jika tidak lewati seksi -->
<!-- (Strict requirement: do NOT show fabricated statistics!) -->

<!-- 6. CTA STRIP DARK (Surface Dark per docs/DESIGN.md cta-strip-dark) -->
<Section tone="dark" class="border-none py-section">
  <Container>
    <div
      class="flex flex-col items-start justify-between gap-lg tablet:flex-row tablet:items-center"
    >
      <div class="flex flex-col gap-xs desktop:max-w-2xl">
        <span class="type-caption-md font-bold tracking-wider text-accent-yellow uppercase">
          KONSULTASI TEKNIS &amp; PENAWARAN
        </span>
        <h2 class="type-heading-xl font-bold text-on-dark">
          Siap Membangun Sistem Energi Surya Anda?
        </h2>
        <p class="type-body-md text-on-dark-mute">
          Diskusikan kebutuhan spesifikasi teknis PJU tenaga surya, kalkulasi kapasitas PLTS atap,
          atau pengadaan proyek EBT bersama tim ahli engineering kami.
        </p>
      </div>

      <div class="flex shrink-0 flex-wrap items-center gap-sm">
        <Button variant="primary" size="lg" href="/kontak">Hubungi Tim Ahli</Button>
        <Button variant="outline-on-dark" size="lg" href="/produk">Katalog Produk</Button>
      </div>
    </div>
  </Container>
</Section>
