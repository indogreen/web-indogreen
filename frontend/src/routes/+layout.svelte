<script lang="ts">
	import './layout.css';
	import favicon from '#lib/assets/favicon.svg';
	import type { LayoutProps } from './$types';

	let { children }: LayoutProps = $props();
</script>

<svelte:head>
	<link rel="icon" type="image/png" href="/favicon.png" />
	<link rel="icon" type="image/svg+xml" href={favicon} />
	<link rel="apple-touch-icon" href="/favicon.png" />
</svelte:head>

{@render children()}
