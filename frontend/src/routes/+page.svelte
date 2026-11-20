<script lang="ts">
  import { Container, Section, Button, CornerSquare } from '#lib';
</script>

<svelte:head>
  <title>PT. Indogreen Technology And Management</title>
</svelte:head>

<Section tone="dark" class="flex min-h-screen items-center justify-center">
  <Container>
    <div
      class="relative mx-auto flex max-w-2xl flex-col items-center justify-center gap-lg rounded-sm border border-hairline-strong bg-surface-elevated p-xxl text-center"
    >
      <CornerSquare position="top-left" size="lg" />

      <span class="type-caption-md font-bold tracking-normal text-accent-yellow uppercase">
        FASE 5 · FRONTEND FONDASI & TOKEN DESAIN
      </span>

      <h1 class="type-display-lg font-bold text-on-dark">
        PT. Indogreen Technology And Management
      </h1>

      <p class="type-body-md text-on-dark-mute">
        Fondasi SvelteKit, token desain <code class="font-mono text-primary">tokens.css</code>, dan
        pustaka komponen UI telah terpasang sesuai dokumen
        <code class="font-mono text-primary">DESIGN.md</code>.
      </p>

      <div class="pt-md">
        <Button variant="primary" size="lg" href="/styleguide">
          <span>Buka Verifikasi /styleguide</span>
        </Button>
      </div>
    </div>
  </Container>
</Section>
