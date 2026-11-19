<script lang="ts">
	import type { HTMLSelectAttributes } from 'svelte/elements';
	import type { Snippet } from 'svelte';
	import Icon from './Icon.svelte';

	export interface SelectOption {
		value: string | number;
		label: string;
		disabled?: boolean;
	}

	interface Props extends HTMLSelectAttributes {
		label?: string;
		error?: string;
		hint?: string;
		id?: string;
		class?: string;
		value?: string | number;
		options?: SelectOption[];
		placeholder?: string;
		children?: Snippet;
	}

	let {
		label,
		error,
		hint,
		id,
		class: className = '',
		value = $bindable(''),
		options = [],
		placeholder,
		disabled = false,
		required = false,
		children,
		...restProps
	}: Props = $props();

	const selectId = $derived(
		id ?? (label ? `select-${label.toLowerCase().replace(/\s+/g, '-')}` : undefined)
	);
	const errorId = $derived(error && selectId ? `${selectId}-error` : undefined);
	const hintId = $derived(hint && selectId ? `${selectId}-hint` : undefined);
	const describedBy = $derived([errorId, hintId].filter(Boolean).join(' ') || undefined);

	const borderClass = $derived(
		error
			? 'border-2 border-error text-ink focus-ring'
			: 'border border-hairline focus:border-2 focus:border-primary focus-ring'
	);
</script>

<div class="flex w-full flex-col gap-xs">
	{#if label}
		<label for={selectId} class="type-caption-md flex items-center gap-xxs text-ink">
			{label}
			{#if required}
				<span class="text-error" aria-hidden="true">*</span>
			{/if}
		</label>
	{/if}

	<div class="relative w-full">
		<select
			id={selectId}
			bind:value
			{disabled}
			{required}
			aria-invalid={error ? 'true' : undefined}
			aria-describedby={describedBy}
			class={[
				'type-body-md h-touch w-full appearance-none rounded-sm bg-canvas py-input-y pr-touch pl-input-x text-ink transition-colors',
				disabled ? 'cursor-not-allowed bg-surface-soft text-ash' : 'bg-canvas',
				borderClass,
				className
			]
				.filter(Boolean)
				.join(' ')}
			{...restProps}
		>
			{#if placeholder}
				<option value="" disabled selected={!value}>
					{placeholder}
				</option>
			{/if}

			{#if options.length > 0}
				{#each options as opt (opt.value)}
					<option value={opt.value} disabled={opt.disabled}>
						{opt.label}
					</option>
				{/each}
			{:else if children}
				{@render children()}
			{/if}
		</select>

		<div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-md text-mute">
			<Icon name="chevron-down" size={18} ariaHidden={true} />
		</div>
	</div>

	{#if error}
		<p id={errorId} class="type-caption-sm text-error" role="alert">
			{error}
		</p>
	{:else if hint}
		<p id={hintId} class="type-caption-sm text-mute">
			{hint}
		</p>
	{/if}
</div>
