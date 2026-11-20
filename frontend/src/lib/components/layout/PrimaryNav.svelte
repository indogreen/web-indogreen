<script lang="ts">
  import Container from '$lib/components/ui/Container.svelte';
  import Button from '$lib/components/ui/Button.svelte';
  import Icon from '$lib/components/ui/Icon.svelte';
  import Logo from './Logo.svelte';
  import MobileDrawer from './MobileDrawer.svelte';

  export interface NavItem {
    name: string;
    href: string;
  }

  interface Props {
    currentPath?: string;
    class?: string;
  }

  let { currentPath = '/', class: className = '' }: Props = $props();

  const navItems: NavItem[] = [
    { name: 'Beranda', href: '/' },
    { name: 'Produk', href: '/produk' },
    { name: 'Solusi', href: '/solusi' },
    { name: 'Tentang Kami', href: '/tentang-kami' },
    { name: 'Kontak', href: '/kontak' }
  ];

  let isDrawerOpen = $state(false);
  let isScrolled = $state(false);

  function handleScroll() {
    if (typeof window !== 'undefined') {
      isScrolled = window.scrollY > 8;
    }
  }

  $effect(() => {
    if (typeof window !== 'undefined') {
      window.addEventListener('scroll', handleScroll, { passive: true });
      handleScroll();
      return () => {
        window.removeEventListener('scroll', handleScroll);
      };
    }
  });

  function isItemActive(href: string): boolean {
    if (href === '/') return currentPath === '/';
    return currentPath === href || currentPath.startsWith(href + '/');
  }

  function openDrawer() {
    isDrawerOpen = true;
  }

  function closeDrawer() {
    isDrawerOpen = false;
  }
</script>

<header
  class={[
    'sticky top-0 z-40 h-16 w-full border-b border-hairline-strong/60 bg-surface-dark text-on-dark transition-shadow select-none',
    isScrolled ? 'shadow-[0_0_5px_0_rgba(0,0,0,0.3)]' : '',
    className
  ]
    .filter(Boolean)
    .join(' ')}
  aria-label="Navigasi Utama Situs"
  data-testid="primary-nav"
>
  <Container class="h-full">
    <div class="flex h-full items-center justify-between gap-md">
      <!-- Left: Official Logo -->
      <div class="flex shrink-0 items-center">
        <Logo imgClass="h-9 w-auto object-contain" />
      </div>

      <!-- Center: Desktop Navigation Links (>= 768px) -->
      <nav
        class="hidden h-full items-center gap-md tablet:flex desktop:gap-xl"
        aria-label="Menu Utama Desktop"
      >
        {#each navItems as item (item.href)}
          {@const active = isItemActive(item.href)}
          <a
            href={item.href}
            aria-current={active ? 'page' : undefined}
            class={[
              'type-body-strong focus-ring relative flex h-full items-center px-xs text-[15px] transition-colors',
              active ? 'font-bold text-primary' : 'text-on-dark hover:text-primary'
            ].join(' ')}
          >
            <span>{item.name}</span>
            {#if active}
              <span class="absolute right-0 bottom-0 left-0 h-[2px] bg-primary" aria-hidden="true"
              ></span>
            {/if}
          </a>
        {/each}
      </nav>

      <!-- Right: Search Button & Primary Green CTA & Mobile Hamburger -->
      <div class="flex items-center gap-sm desktop:gap-md">
        <!-- Global Search Icon Button -->
        <a
          href="/pencarian"
          class="focus-ring flex h-touch w-touch items-center justify-center text-on-dark transition-colors hover:text-primary"
          aria-label="Buka pencarian global"
          data-testid="nav-search-btn"
        >
          <Icon name="search" size={20} />
        </a>

        <!-- Exactly ONE solid green CTA per viewport -->
        <div class="hidden mobile:block">
          <Button
            variant="primary"
            size="md"
            href="/kontak"
            class="whitespace-nowrap"
            data-testid="nav-contact-cta"
          >
            Hubungi Kami
          </Button>
        </div>

        <!-- Mobile Drawer Hamburger Toggle (< 768px) -->
        <button
          type="button"
          onclick={openDrawer}
          class="focus-ring flex h-touch w-touch items-center justify-center text-on-dark transition-colors hover:text-primary tablet:hidden"
          aria-label="Buka navigasi"
          aria-expanded={isDrawerOpen}
          aria-controls="mobile-drawer"
          data-testid="drawer-toggle-btn"
        >
          <Icon name="menu" size={24} />
        </button>
      </div>
    </div>
  </Container>
</header>

<!-- Mobile Slide-Over Drawer -->
<MobileDrawer isOpen={isDrawerOpen} onClose={closeDrawer} {currentPath} {navItems} />
