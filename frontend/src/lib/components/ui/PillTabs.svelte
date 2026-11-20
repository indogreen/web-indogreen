<script lang="ts">
  export interface TabItem {
    id: string;
    label: string;
    disabled?: boolean;
  }

  interface Props {
    tabs: TabItem[];
    activeTab?: string;
    class?: string;
    onchange?: (tabId: string) => void;
  }

  let {
    tabs = [],
    activeTab = $bindable(tabs[0]?.id ?? ''),
    class: className = '',
    onchange
  }: Props = $props();

  function selectTab(id: string) {
    activeTab = id;
    onchange?.(id);
  }

  function handleKeydown(event: KeyboardEvent, currentIndex: number) {
    let newIndex: number;
    if (event.key === 'ArrowRight') {
      newIndex = (currentIndex + 1) % tabs.length;
    } else if (event.key === 'ArrowLeft') {
      newIndex = (currentIndex - 1 + tabs.length) % tabs.length;
    } else if (event.key === 'Home') {
      newIndex = 0;
    } else if (event.key === 'End') {
      newIndex = tabs.length - 1;
    } else {
      return;
    }

    event.preventDefault();
    const targetTab = tabs[newIndex];
    if (targetTab && !targetTab.disabled) {
      selectTab(targetTab.id);
    }
  }
</script>

<div
  role="tablist"
  class={['inline-flex flex-wrap items-center gap-xs rounded-sm', className]
    .filter(Boolean)
    .join(' ')}
>
  {#each tabs as tab, index (tab.id)}
    {@const isActive = activeTab === tab.id}
    <button
      type="button"
      role="tab"
      id={`tab-${tab.id}`}
      aria-selected={isActive}
      aria-controls={`tabpanel-${tab.id}`}
      tabindex={isActive ? 0 : -1}
      disabled={tab.disabled}
      onclick={() => selectTab(tab.id)}
      onkeydown={(e) => handleKeydown(e, index)}
      class={[
        'type-button-sm min-h-touch rounded-sm px-pill-x py-pill-y transition-colors outline-none select-none focus-visible:outline-2 focus-visible:outline-primary',
        isActive
          ? 'border border-ink bg-ink font-bold text-on-dark dark:border-on-dark dark:bg-on-dark dark:text-on-primary'
          : 'border border-hairline bg-transparent text-ink hover:bg-surface-soft active:bg-hairline/40 dark:border-hairline-strong dark:text-on-dark dark:hover:bg-surface-elevated',
        tab.disabled ? 'cursor-not-allowed text-ash opacity-50' : 'cursor-pointer'
      ]
        .filter(Boolean)
        .join(' ')}
    >
      {tab.label}
    </button>
  {/each}
</div>
