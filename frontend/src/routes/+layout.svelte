<script lang="ts">
	import './layout.css';
	import type { LayoutProps } from './$types';

	let { children }: LayoutProps = $props();
</script>

<svelte:head>
	<link rel="icon" type="image/png" href="/indogreen.png" />
	<link rel="apple-touch-icon" href="/indogreen.png" />
</svelte:head>

{@render children()}
