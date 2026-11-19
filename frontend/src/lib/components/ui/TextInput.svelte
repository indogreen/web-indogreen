<script lang="ts">
	import type { HTMLInputAttributes } from 'svelte/elements';

	interface Props extends HTMLInputAttributes {
		label?: string;
		error?: string;
		hint?: string;
		id?: string;
		class?: string;
		value?: string | number;
	}

	let {
		label,
		error,
		hint,
		id,
		class: className = '',
		value = $bindable(''),
		disabled = false,
		required = false,
		type = 'text',
		...restProps
	}: Props = $props();

	const inputId = $derived(
		id ?? (label ? `input-${label.toLowerCase().replace(/\s+/g, '-')}` : undefined)
	);
	const errorId = $derived(error && inputId ? `${inputId}-error` : undefined);
	const hintId = $derived(hint && inputId ? `${inputId}-hint` : undefined);
	const describedBy = $derived([errorId, hintId].filter(Boolean).join(' ') || undefined);

	const borderClass = $derived(
		error
			? 'border-2 border-error text-ink focus-ring'
			: 'border border-hairline focus:border-2 focus:border-primary focus-ring'
	);
</script>

<div class="flex w-full flex-col gap-xs">
	{#if label}
		<label for={inputId} class="type-caption-md flex items-center gap-xxs text-ink">
			{label}
			{#if required}
				<span class="text-error" aria-hidden="true">*</span>
			{/if}
		</label>
	{/if}

	<input
		id={inputId}
		{type}
		bind:value
		{disabled}
		{required}
		aria-invalid={error ? 'true' : undefined}
		aria-describedby={describedBy}
		class={[
			'type-body-md h-touch w-full rounded-sm bg-canvas px-input-x py-input-y text-ink transition-colors placeholder:text-stone',
			disabled ? 'cursor-not-allowed bg-surface-soft text-ash' : 'bg-canvas',
			borderClass,
			className
		]
			.filter(Boolean)
			.join(' ')}
		{...restProps}
	/>

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
