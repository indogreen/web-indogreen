<script lang="ts">
  import Container from '$lib/components/ui/Container.svelte';
  import Icon from '$lib/components/ui/Icon.svelte';

  export interface BreadcrumbItem {
    label: string;
    href?: string;
  }

  interface Props {
    items: BreadcrumbItem[];
    class?: string;
  }

  let { items = [], class: className = '' }: Props = $props();
</script>

{#if items.length > 0}
  <nav
    class={['h-12 w-full border-b border-hairline bg-surface-soft text-body select-none', className]
      .filter(Boolean)
      .join(' ')}
    aria-label="Breadcrumb"
    data-testid="breadcrumb-bar"
  >
    <Container class="h-full">
      <ol
        class="type-caption-md flex h-full items-center gap-xs overflow-x-auto text-[14px] font-bold tracking-wider whitespace-nowrap text-body uppercase"
      >
        <li>
          <a
            href="/"
            class="focus-ring transition-colors hover:text-primary"
            aria-label="Kembali ke Beranda"
          >
            Beranda
          </a>
        </li>

        {#each items as item, index (index)}
          <li class="flex items-center gap-xs">
            <span class="shrink-0 text-mute" aria-hidden="true">
              <Icon name="chevron-right" size={14} />
            </span>
            {#if item.href && index < items.length - 1}
              <a href={item.href} class="focus-ring transition-colors hover:text-primary">
                {item.label}
              </a>
            {:else}
              <span class="text-mute" aria-current="page">
                {item.label}
              </span>
            {/if}
          </li>
        {/each}
      </ol>
    </Container>
  </nav>
{/if}
