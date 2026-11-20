<script lang="ts">
  import type { Snippet } from 'svelte';

  export type SectionTone = 'light' | 'dark' | 'soft';

  interface Props {
    tone?: SectionTone;
    id?: string;
    class?: string;
    children?: Snippet;
  }

  let { tone = 'light', id, class: className = '', children }: Props = $props();

  const toneClasses: Record<SectionTone, string> = {
    light: 'bg-canvas text-ink',
    dark: 'bg-surface-dark text-on-dark',
    soft: 'bg-surface-soft text-ink'
  };
</script>

<section
  {id}
  class={[
    'section-padding relative w-full border-b border-hairline/20',
    toneClasses[tone],
    className
  ]
    .filter(Boolean)
    .join(' ')}
>
  {#if children}
    {@render children()}
  {/if}
</section>
