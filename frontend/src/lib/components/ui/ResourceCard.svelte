<script lang="ts">
  import Badge from './Badge.svelte';
  import CornerSquare from './CornerSquare.svelte';
  import Icon from './Icon.svelte';

  interface Props {
    title: string;
    description?: string;
    typeLabel: string;
    imageSrc?: string;
    imageAlt?: string;
    href?: string;
    ctaText?: string;
    class?: string;
  }

  let {
    title,
    description,
    typeLabel,
    imageSrc,
    imageAlt = title,
    href,
    ctaText = 'Baca Selengkapnya',
    class: className = ''
  }: Props = $props();
</script>

<article
  class={[
    'relative flex flex-col justify-between rounded-sm border border-hairline bg-canvas p-xl transition-colors hover:border-primary',
    className
  ]
    .filter(Boolean)
    .join(' ')}
>
  <CornerSquare position="bottom-right" />

  <div class="flex flex-col gap-md">
    <div class="flex items-center justify-start">
      <Badge variant="default">
        {typeLabel}
      </Badge>
    </div>

    {#if imageSrc}
      <div class="relative aspect-[3/2] w-full overflow-hidden rounded-none bg-surface-soft">
        <img src={imageSrc} alt={imageAlt} loading="lazy" class="h-full w-full object-cover" />
      </div>
    {/if}

    <h3 class="type-card-title font-bold text-ink">
      {#if href}
        <a {href} class="focus-ring transition-colors hover:text-primary">
          {title}
        </a>
      {:else}
        {title}
      {/if}
    </h3>

    {#if description}
      <p class="type-body-sm text-mute">
        {description}
      </p>
    {/if}
  </div>

  <div class="mt-lg flex items-center justify-between pt-sm">
    {#if href}
      <a
        {href}
        class="type-button-md focus-ring inline-flex items-center gap-xs font-bold text-primary hover:underline"
      >
        <span>{ctaText}</span>
        <Icon name="arrow-right" size={16} ariaHidden={true} />
      </a>
    {/if}
  </div>
</article>
