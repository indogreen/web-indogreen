<script lang="ts">
  import FooterLayout from '../layout/Footer.svelte';
  import type { SiteSettings } from '$lib/types';

  interface Props {
    settings?: SiteSettings;
    class?: string;
  }

  let props: Props = $props();
</script>

<FooterLayout {...props} />
