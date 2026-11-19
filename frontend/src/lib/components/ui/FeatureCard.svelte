<script lang="ts">
	import type { Snippet } from 'svelte';
	import type { IconName } from './types.js';
	import Icon from './Icon.svelte';
	import CornerSquare from './CornerSquare.svelte';

	interface Props {
		title: string;
		description: string;
		icon?: IconName;
		hasCornerSquare?: boolean;
		class?: string;
		iconSlot?: Snippet;
	}

	let {
		title,
		description,
		icon,
		hasCornerSquare = false,
		class: className = '',
		iconSlot
	}: Props = $props();
</script>

<div
	class={[
		'relative flex flex-col gap-md rounded-sm border border-hairline bg-canvas p-xxl transition-colors hover:border-primary',
		className
	]
		.filter(Boolean)
		.join(' ')}
>
	{#if hasCornerSquare}
		<CornerSquare position="top-left" />
	{/if}

	<div class="flex items-center justify-start text-primary">
		{#if iconSlot}
			{@render iconSlot()}
		{:else if icon}
			<Icon name={icon} size={24} strokeWidth={2} ariaHidden={true} />
		{/if}
	</div>

	<h3 class="type-heading-md font-bold text-ink">
		{title}
	</h3>

	<p class="type-body-md text-body">
		{description}
	</p>
</div>
