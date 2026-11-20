<script lang="ts">
  interface Props {
    href?: string;
    class?: string;
    imgClass?: string;
    alt?: string;
    isLink?: boolean;
  }

  let {
    href = '/',
    class: className = '',
    imgClass = 'h-9 w-auto object-contain',
    alt = 'PT. Indogreen Technology And Management',
    isLink = true
  }: Props = $props();
</script>

{#if isLink}
  <a
    {href}
    class={['focus-ring inline-flex items-center transition-opacity hover:opacity-90', className]
      .filter(Boolean)
      .join(' ')}
    aria-label={alt}
  >
    <img
      src="/indogreen.png"
      {alt}
      width="809"
      height="233"
      class={imgClass}
      loading="eager"
      decoding="async"
    />
  </a>
{:else}
  <div class={['inline-flex items-center', className].filter(Boolean).join(' ')}>
    <img
      src="/indogreen.png"
      {alt}
      width="809"
      height="233"
      class={imgClass}
      loading="lazy"
      decoding="async"
    />
  </div>
{/if}
