<script lang="ts">
	import type { Snippet } from 'svelte';

	interface Props {
		class?: string;
		children?: Snippet;
	}

	let { class: className = '', children }: Props = $props();
</script>

<div
	class={['container-max w-full px-lg tablet:px-xl ultrawide:px-section', className]
		.filter(Boolean)
		.join(' ')}
>
	{#if children}
		{@render children()}
	{/if}
</div>
