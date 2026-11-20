<script lang="ts">
  interface Props {
    value: string | number;
    unit?: string;
    caption: string;
    label?: string;
    class?: string;
  }

  let { value, unit, caption, label, class: className = '' }: Props = $props();
</script>

<div
  class={[
    'flex flex-col justify-between rounded-sm border border-hairline bg-canvas p-xxl select-none',
    className
  ]
    .filter(Boolean)
    .join(' ')}
>
  {#if label}
    <span class="type-caption-md mb-sm font-bold tracking-normal text-mute uppercase">
      {label}
    </span>
  {/if}

  <div class="flex items-baseline gap-xxs">
    <span class="type-display-lg font-bold text-primary">
      {value}
    </span>
    {#if unit}
      <span class="type-heading-md font-bold text-primary">
        {unit}
      </span>
    {/if}
  </div>

  <p class="type-body-md mt-xs text-body">
    {caption}
  </p>
</div>
