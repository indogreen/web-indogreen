<script lang="ts">
  import Container from '$lib/components/ui/Container.svelte';
  import Icon from '$lib/components/ui/Icon.svelte';

  export interface SubNavItem {
    label: string;
    href: string;
    count?: number;
  }

  interface Props {
    items: SubNavItem[];
    activeHref?: string;
    class?: string;
    ariaLabel?: string;
  }

  let {
    items = [],
    activeHref = '',
    class: className = '',
    ariaLabel = 'Navigasi Sub-kategori'
  }: Props = $props();

  function handleSelectChange(e: Event) {
    const target = e.target as HTMLSelectElement;
    if (target.value && typeof window !== 'undefined') {
      window.location.href = target.value;
    }
  }
</script>

{#if items.length > 0}
  <nav
    class={['h-14 w-full border-b border-hairline bg-surface-soft text-ink select-none', className]
      .filter(Boolean)
      .join(' ')}
    aria-label={ariaLabel}
    data-testid="sub-nav-strip"
  >
    <Container class="h-full">
      <!-- Mobile View (< 640px): Collapses into Select Dropdown -->
      <div class="flex h-full items-center mobile:hidden">
        <div class="relative w-full">
          <select
            onchange={handleSelectChange}
            aria-label={ariaLabel}
            class="type-button-md focus-ring h-10 w-full appearance-none rounded-sm border border-hairline bg-canvas px-md pr-xl text-ink outline-none"
            value={activeHref || items[0]?.href}
          >
            {#each items as item (item.href)}
              <option value={item.href}>
                {item.label}
                {item.count !== undefined ? `(${item.count})` : ''}
              </option>
            {/each}
          </select>
          <div
            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-md text-mute"
            aria-hidden="true"
          >
            <Icon name="chevron-down" size={16} />
          </div>
        </div>
      </div>

      <!-- Tablet & Desktop View (>= 640px): Horizontal Row (scrollable on tablet) -->
      <div class="hidden h-full items-center overflow-x-auto whitespace-nowrap mobile:flex">
        <ul class="flex h-full items-center gap-xs">
          {#each items as item (item.href)}
            {@const isActive = activeHref === item.href}
            <li class="h-full">
              <a
                href={item.href}
                aria-current={isActive ? 'page' : undefined}
                class={[
                  'type-button-md focus-ring relative flex h-full items-center px-md text-[15px] transition-colors',
                  isActive ? 'font-bold text-primary' : 'text-ink hover:text-primary'
                ].join(' ')}
              >
                <span>{item.label}</span>
                {#if item.count !== undefined}
                  <span
                    class={[
                      'ml-xs rounded-sm px-1.5 py-0.5 text-xs',
                      isActive
                        ? 'bg-primary text-black'
                        : 'border border-hairline bg-canvas text-stone'
                    ].join(' ')}
                  >
                    {item.count}
                  </span>
                {/if}
                {#if isActive}
                  <span
                    class="absolute right-0 bottom-0 left-0 h-[2px] bg-primary"
                    aria-hidden="true"
                  ></span>
                {/if}
              </a>
            </li>
          {/each}
        </ul>
      </div>
    </Container>
  </nav>
{/if}
