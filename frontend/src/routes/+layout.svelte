<script lang="ts">
  import './layout.css';
  import { page } from '$app/state';
  import type { LayoutProps } from './$types';
  import UtilityBar from '$lib/components/layout/UtilityBar.svelte';
  import PrimaryNav from '$lib/components/layout/PrimaryNav.svelte';
  import Footer from '$lib/components/layout/Footer.svelte';

  let { data, children }: LayoutProps = $props();

  const currentPath = $derived(page.url.pathname);
</script>

<div class="flex min-h-screen flex-col bg-canvas text-body">
  <!-- Utility Bar (32px, Surface Dark) -->
  <UtilityBar settings={data.settings} />

  <!-- Primary Nav (64px, Sticky, Surface Dark) -->
  <PrimaryNav {currentPath} />

  <!-- Main Content Area -->
  <main class="flex-1">
    {@render children()}
  </main>

  <!-- Footer (Surface Dark & Sub-Footer) -->
  <Footer settings={data.settings} />
</div>
