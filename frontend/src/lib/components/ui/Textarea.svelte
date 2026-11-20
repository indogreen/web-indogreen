<script lang="ts">
	import type { HTMLTextareaAttributes } from 'svelte/elements';

	interface Props extends HTMLTextareaAttributes {
		label?: string;
		error?: string;
		hint?: string;
		id?: string;
		class?: string;
		value?: string;
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
		rows = 4,
		...restProps
	}: Props = $props();

	const textareaId = $derived(
		id ?? (label ? `textarea-${label.toLowerCase().replace(/\s+/g, '-')}` : undefined)
	);
	const errorId = $derived(error && textareaId ? `${textareaId}-error` : undefined);
	const hintId = $derived(hint && textareaId ? `${textareaId}-hint` : undefined);
	const describedBy = $derived([errorId, hintId].filter(Boolean).join(' ') || undefined);

	const borderClass = $derived(
		error
			? 'border border-error focus:border-2 focus:border-error focus:outline-none'
			: 'border border-hairline focus:border-2 focus:border-primary focus:outline-none'
	);
</script>

<div class="flex w-full flex-col gap-xs">
	{#if label}
		<label for={textareaId} class="type-caption-md flex items-center gap-xxs text-ink">
			{label}
			{#if required}
				<span class="text-error" aria-hidden="true">*</span>
			{/if}
		</label>
	{/if}

	<textarea
		id={textareaId}
		{rows}
		bind:value
		{disabled}
		{required}
		aria-invalid={error ? 'true' : undefined}
		aria-describedby={describedBy}
		class={[
			'type-body-md min-h-textarea-min w-full rounded-sm bg-canvas px-input-x py-input-y text-ink transition-colors outline-none placeholder:text-stone',
			disabled ? 'cursor-not-allowed bg-surface-soft text-ash' : '',
			borderClass,
			className
		]
			.filter(Boolean)
			.join(' ')}
		{...restProps}></textarea>

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
