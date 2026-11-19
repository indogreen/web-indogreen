<script lang="ts">
	import type { Snippet } from 'svelte';

	export type BadgeVariant = 'default' | 'primary' | 'dark' | 'outline';

	interface Props {
		variant?: BadgeVariant;
		text?: string;
		class?: string;
		children?: Snippet;
	}

	let { variant = 'default', text, class: className = '', children }: Props = $props();

	const variantClasses: Record<BadgeVariant, string> = {
		default: 'bg-surface-soft text-body border-transparent',
		primary: 'bg-primary text-on-primary border-transparent',
		dark: 'bg-surface-elevated text-on-dark border-transparent',
		outline: 'bg-transparent text-body border border-hairline'
	};
</script>

<span
	class={[
		'type-caption-md inline-flex items-center justify-center rounded-sm px-badge-x py-badge-y font-bold tracking-normal uppercase select-none',
		variantClasses[variant],
		className
	]
		.filter(Boolean)
		.join(' ')}
>
	{#if children}
		{@render children()}
	{:else if text}
		{text}
	{/if}
</span>
