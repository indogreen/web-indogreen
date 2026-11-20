<script lang="ts">
  import type { Snippet } from 'svelte';

  interface SeoDataInput {
    seo_title?: string | null;
    seo_description?: string | null;
    title?: string | null;
    name?: string | null;
    description?: string | null;
    short_description?: string | null;
    featured_image?: { original?: string } | null;
  }

  interface Props {
    title?: string | null;
    description?: string | null;
    canonical?: string | null;
    ogTitle?: string | null;
    ogDescription?: string | null;
    ogImage?: string | null;
    ogType?: string;
    twitterCard?: string;
    robots?: string;
    jsonLd?: Record<string, unknown> | Array<Record<string, unknown>> | null;
    seoData?: SeoDataInput | null;
    children?: Snippet;
  }

  let {
    title,
    description,
    canonical,
    ogTitle,
    ogDescription,
    ogImage,
    ogType = 'website',
    twitterCard = 'summary_large_image',
    robots = 'index, follow',
    jsonLd,
    seoData,
    children
  }: Props = $props();

  const rawTitle = $derived(
    title ||
      seoData?.seo_title ||
      seoData?.title ||
      seoData?.name ||
      'Solusi Energi Baru & Terbarukan'
  );

  // Formatted title with template '%s | INDOGREEN'
  const formattedTitle = $derived.by(() => {
    if (!rawTitle) return 'INDOGREEN | Solusi Energi Baru & Terbarukan';
    if (rawTitle.includes('| INDOGREEN')) return rawTitle;
    return `${rawTitle} | INDOGREEN`;
  });

  const finalDescription = $derived(
    description ||
      seoData?.seo_description ||
      seoData?.description ||
      seoData?.short_description ||
      'PT. Indogreen Technology And Management - Perusahaan penyedia dan pengembang sistem Lampu PJU Tenaga Surya (TIO/AIO), PLTS Atap, dan Solar Home System terkemuka di Indonesia.'
  );

  const finalOgTitle = $derived(ogTitle || formattedTitle);
  const finalOgDescription = $derived(ogDescription || finalDescription);
  const finalOgImage = $derived(ogImage || seoData?.featured_image?.original || '/indogreen.png');

  const closeTag = '</' + 'script>';
  const jsonLdScript = $derived(
    jsonLd ? `<script type="application/ld+json">${JSON.stringify(jsonLd)}${closeTag}` : ''
  );
</script>

<svelte:head>
  <title>{formattedTitle}</title>
  <meta name="description" content={finalDescription} />
  <meta name="robots" content={robots} />

  {#if canonical}
    <link rel="canonical" href={canonical} />
  {/if}

  <!-- Open Graph / Facebook -->
  <meta property="og:site_name" content="INDOGREEN" />
  <meta property="og:type" content={ogType} />
  <meta property="og:title" content={finalOgTitle} />
  <meta property="og:description" content={finalOgDescription} />
  <meta property="og:image" content={finalOgImage} />
  <meta property="og:locale" content="id_ID" />
  {#if canonical}
    <meta property="og:url" content={canonical} />
  {/if}

  <!-- Twitter Card -->
  <meta name="twitter:card" content={twitterCard} />
  <meta name="twitter:title" content={finalOgTitle} />
  <meta name="twitter:description" content={finalOgDescription} />
  <meta name="twitter:image" content={finalOgImage} />

  <!-- Structured Data (JSON-LD) -->
  {#if jsonLdScript}
    <!-- eslint-disable-next-line svelte/no-at-html-tags -->
    {@html jsonLdScript}
  {/if}

  {#if children}
    {@render children()}
  {/if}
</svelte:head>
