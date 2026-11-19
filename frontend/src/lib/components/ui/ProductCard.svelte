<script lang="ts">
	import type { Snippet } from 'svelte';
	import CornerSquare from './CornerSquare.svelte';
	import Icon from './Icon.svelte';

	interface Props {
		title: string;
		description?: string;
		category?: string;
		imageSrc?: string;
		imageAlt?: string;
		href?: string;
		ctaText?: string;
		class?: string;
		badge?: Snippet;
		actions?: Snippet;
	}

	let {
		title,
		description,
		category,
		imageSrc,
		imageAlt = title,
		href,
		ctaText = 'Pelajari Lebih Lanjut',
		class: className = '',
		badge,
		actions
	}: Props = $props();
</script>

<article
	class={[
		'relative flex flex-col justify-between rounded-sm border border-hairline bg-canvas p-xl transition-colors hover:border-primary',
		className
	]
		.filter(Boolean)
		.join(' ')}
>
	<CornerSquare position="top-left" />

	<div class="flex flex-col gap-md">
		{#if imageSrc}
			<div class="relative aspect-video w-full overflow-hidden rounded-none bg-surface-soft">
				<img src={imageSrc} alt={imageAlt} loading="lazy" class="h-full w-full object-cover" />
			</div>
		{/if}

		<div class="flex items-center justify-between gap-sm">
			{#if category}
				<span class="type-caption-xs font-bold tracking-normal text-mute uppercase">
					{category}
				</span>
			{/if}
			{#if badge}
				{@render badge()}
			{/if}
		</div>

		<h3 class="type-card-title font-bold text-ink">
			{#if href}
				<a {href} class="focus-ring transition-colors hover:text-primary">
					{title}
				</a>
			{:else}
				{title}
			{/if}
		</h3>

		{#if description}
			<p class="type-body-sm text-mute">
				{description}
			</p>
		{/if}
	</div>

	<div class="mt-lg flex items-center justify-between pt-sm">
		{#if actions}
			{@render actions()}
		{:else if href}
			<a
				{href}
				class="type-button-md focus-ring inline-flex items-center gap-xs font-bold text-primary hover:underline"
			>
				<span>{ctaText}</span>
				<Icon name="arrow-right" size={16} ariaHidden={true} />
			</a>
		{/if}
	</div>
</article>
