<script lang="ts">
	import type { Snippet } from 'svelte';
	import type { HTMLButtonAttributes, HTMLAnchorAttributes } from 'svelte/elements';

	export type ButtonVariant = 'primary' | 'outline' | 'outline-on-dark' | 'ghost-link' | 'disabled';
	export type ButtonSize = 'lg' | 'md' | 'sm';

	interface BaseProps {
		variant?: ButtonVariant;
		size?: ButtonSize;
		disabled?: boolean;
		text?: string;
		class?: string;
		children?: Snippet;
		ariaLabel?: string;
	}

	type ButtonAsButton = BaseProps &
		HTMLButtonAttributes & {
			href?: undefined;
		};

	type ButtonAsLink = BaseProps &
		HTMLAnchorAttributes & {
			href: string;
		};

	type Props = ButtonAsButton | ButtonAsLink;

	let {
		variant = 'primary',
		size = 'md',
		disabled = false,
		text,
		class: className = '',
		children,
		ariaLabel,
		href,
		...restProps
	}: Props = $props();

	const isEffectivelyDisabled = $derived(disabled || variant === 'disabled');

	const variantClasses: Record<ButtonVariant, string> = {
		primary:
			'bg-primary text-on-primary hover:bg-primary-dark active:bg-primary-dark outline-none focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary',
		outline:
			'bg-transparent text-ink border-2 border-primary hover:bg-surface-soft active:bg-surface-soft outline-none focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary',
		'outline-on-dark':
			'bg-transparent text-on-dark border border-on-dark hover:bg-white/10 active:bg-white/20 outline-none focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary',
		'ghost-link':
			'bg-transparent text-primary hover:underline active:opacity-80 outline-none focus-visible:underline rounded-none',
		disabled: 'bg-surface-soft text-ash cursor-not-allowed outline-none pointer-events-none'
	};

	const sizeClasses: Record<ButtonSize, string> = {
		lg: 'type-button-lg min-h-touch px-btn-x py-md',
		md: 'type-button-md min-h-touch px-btn-x py-btn-y',
		sm: 'type-button-sm min-h-touch px-pill-x py-pill-y'
	};

	const radiusClass = $derived(variant === 'ghost-link' ? 'rounded-none' : 'rounded-sm');

	const computedClasses = $derived(
		[
			'inline-flex items-center justify-center text-center transition-colors select-none',
			radiusClass,
			isEffectivelyDisabled ? variantClasses.disabled : variantClasses[variant],
			variant === 'ghost-link' ? 'type-button-md' : sizeClasses[size],
			className
		]
			.filter(Boolean)
			.join(' ')
	);
</script>

{#if href && !isEffectivelyDisabled}
	<a {href} class={computedClasses} aria-label={ariaLabel} {...restProps as HTMLAnchorAttributes}>
		{#if children}
			{@render children()}
		{:else if text}
			{text}
		{/if}
	</a>
{:else}
	<button
		type={(restProps as HTMLButtonAttributes).type ?? 'button'}
		class={computedClasses}
		disabled={isEffectivelyDisabled}
		aria-disabled={isEffectivelyDisabled ? 'true' : undefined}
		aria-label={ariaLabel}
		{...restProps as HTMLButtonAttributes}
	>
		{#if children}
			{@render children()}
		{:else if text}
			{text}
		{/if}
	</button>
{/if}
