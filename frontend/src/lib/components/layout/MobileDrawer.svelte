<script lang="ts">
  import Icon from '$lib/components/ui/Icon.svelte';
  import Button from '$lib/components/ui/Button.svelte';
  import Logo from './Logo.svelte';

  export interface NavItem {
    name: string;
    href: string;
  }

  interface Props {
    isOpen: boolean;
    onClose: () => void;
    currentPath?: string;
    navItems?: NavItem[];
  }

  let {
    isOpen = false,
    onClose,
    currentPath = '/',
    navItems = [
      { name: 'Beranda', href: '/' },
      { name: 'Produk', href: '/produk' },
      { name: 'Solusi', href: '/solusi' },
      { name: 'Tentang Kami', href: '/tentang-kami' },
      { name: 'Kontak', href: '/kontak' }
    ]
  }: Props = $props();

  let drawerElement = $state<HTMLElement | null>(null);
  let closeButtonElement = $state<HTMLButtonElement | null>(null);
  let previouslyFocusedElement = $state<HTMLElement | null>(null);

  $effect(() => {
    if (typeof window === 'undefined') return;

    if (isOpen) {
      previouslyFocusedElement = document.activeElement as HTMLElement | null;
      const originalOverflow = document.body.style.overflow;
      document.body.style.overflow = 'hidden';

      const timer = setTimeout(() => {
        closeButtonElement?.focus();
      }, 50);

      function handleKeydown(e: KeyboardEvent) {
        if (e.key === 'Escape') {
          e.preventDefault();
          onClose();
          return;
        }

        // Focus trap
        if (e.key === 'Tab' && drawerElement) {
          const focusable = drawerElement.querySelectorAll<HTMLElement>(
            'a[href], button:not([disabled]), input:not([disabled]), [tabindex]:not([tabindex="-1"])'
          );
          if (focusable.length === 0) return;

          const first = focusable[0];
          const last = focusable[focusable.length - 1];

          if (e.shiftKey && document.activeElement === first) {
            e.preventDefault();
            last.focus();
          } else if (!e.shiftKey && document.activeElement === last) {
            e.preventDefault();
            first.focus();
          }
        }
      }

      window.addEventListener('keydown', handleKeydown);

      return () => {
        clearTimeout(timer);
        window.removeEventListener('keydown', handleKeydown);
        document.body.style.overflow = originalOverflow;
        previouslyFocusedElement?.focus();
      };
    } else {
      document.body.style.overflow = '';
    }
  });

  function isItemActive(href: string): boolean {
    if (href === '/') return currentPath === '/';
    return currentPath === href || currentPath.startsWith(href + '/');
  }
</script>

{#if isOpen}
  <!-- Backdrop Overlay -->
  <div
    class="fixed inset-0 z-50 bg-black/75 transition-opacity"
    onclick={onClose}
    aria-hidden="true"
    data-testid="drawer-backdrop"
  ></div>

  <!-- Slide-Over Drawer Container (< 768px / tablet) -->
  <div
    bind:this={drawerElement}
    id="mobile-drawer"
    class="fixed top-0 right-0 z-50 flex h-full w-[85%] max-w-[360px] flex-col justify-between border-l border-hairline-strong bg-surface-dark p-lg text-on-dark shadow-2xl transition-transform"
    role="dialog"
    aria-modal="true"
    aria-label="Menu navigasi utama mobile"
    data-testid="mobile-drawer"
  >
    <!-- Drawer Header -->
    <div class="flex items-center justify-between border-b border-hairline-strong/60 pb-md">
      <Logo imgClass="h-7 w-auto object-contain" />
      <button
        bind:this={closeButtonElement}
        type="button"
        onclick={onClose}
        class="focus-ring flex h-touch w-touch items-center justify-center text-on-dark transition-colors hover:text-primary"
        aria-label="Tutup navigasi"
        data-testid="drawer-close-btn"
      >
        <Icon name="x" size={24} />
      </button>
    </div>

    <!-- Nav Items (min touch target 52px per docs/05-design-decisions.md) -->
    <nav
      class="flex flex-1 flex-col justify-start gap-xs py-lg"
      aria-label="Tautan navigasi mobile"
    >
      {#each navItems as item (item.href)}
        {@const active = isItemActive(item.href)}
        <a
          href={item.href}
          onclick={onClose}
          aria-current={active ? 'page' : undefined}
          class={[
            'type-body-strong focus-ring flex h-[52px] items-center border-l-2 px-md text-[16px] transition-colors',
            active
              ? 'border-primary bg-surface-elevated font-bold text-primary'
              : 'border-transparent text-on-dark hover:border-hairline hover:text-primary'
          ].join(' ')}
        >
          {item.name}
        </a>
      {/each}

      <!-- Search in mobile drawer -->
      <a
        href="/pencarian"
        onclick={onClose}
        class="type-body-strong focus-ring flex h-[52px] items-center gap-sm border-l-2 border-transparent px-md text-[16px] text-on-dark-mute transition-colors hover:border-hairline hover:text-primary"
      >
        <Icon name="search" size={18} class="text-primary" />
        <span>Pencarian Produk & Solusi</span>
      </a>
    </nav>

    <!-- Bottom CTA Button (One primary green CTA per viewport) -->
    <div class="border-t border-hairline-strong/60 pt-md">
      <Button
        variant="primary"
        size="lg"
        href="/kontak"
        class="w-full text-center"
        onclick={onClose}
      >
        Hubungi Kami
      </Button>
    </div>
  </div>
{/if}
