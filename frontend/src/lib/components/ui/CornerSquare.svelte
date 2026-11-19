<script lang="ts">
	export type CornerSquarePosition =
		'top-left' | 'bottom-right' | 'top-right' | 'bottom-left' | 'inline';
	export type CornerSquareSize = 'sm' | 'lg';

	interface Props {
		position?: CornerSquarePosition;
		size?: CornerSquareSize;
		class?: string;
	}

	let { position = 'top-left', size = 'sm', class: className = '' }: Props = $props();

	const positionClasses: Record<CornerSquarePosition, string> = {
		'top-left': 'absolute top-0 left-0',
		'bottom-right': 'absolute bottom-0 right-0',
		'top-right': 'absolute top-0 right-0',
		'bottom-left': 'absolute bottom-0 left-0',
		inline: 'inline-block'
	};

	const sizeClasses: Record<CornerSquareSize, string> = {
		sm: 'w-corner h-corner',
		lg: 'w-corner-lg h-corner-lg'
	};
</script>

<div
	class={[
		'pointer-events-none z-10 rounded-none bg-primary select-none',
		sizeClasses[size],
		positionClasses[position],
		className
	]
		.filter(Boolean)
		.join(' ')}
	aria-hidden="true"
></div>
