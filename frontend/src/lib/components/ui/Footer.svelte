<script lang="ts">
  import Container from './Container.svelte';
  import Button from './Button.svelte';
  import Icon from './Icon.svelte';

  interface Props {
    class?: string;
  }

  let { class: className = '' }: Props = $props();

  let subscriberEmail = $state('');
  let isSubscribed = $state(false);

  function handleSubscribe(e: SubmitEvent) {
    e.preventDefault();
    if (subscriberEmail.trim()) {
      isSubscribed = true;
    }
  }
</script>

<!-- Main Dark Footer Section (Surface Dark #000000) -->
<footer
  class={['relative w-full bg-surface-dark pt-section pb-xl text-on-dark select-none', className]
    .filter(Boolean)
    .join(' ')}
>
  <Container>
    <!-- 3-Column Technical Link Grid (per reference architecture) -->
    <div class="grid grid-cols-1 gap-xl tablet:grid-cols-3 desktop:gap-xxl">
      <!-- Column 1: Company Information -->
      <div class="flex flex-col gap-sm">
        <h3 class="type-heading-md border-b border-hairline-strong/60 pb-xs font-bold text-on-dark">
          Company Information
        </h3>
        <ul class="flex flex-col gap-xs pt-xs">
          <li>
            <a
              href="/tentang-kami"
              class="type-body-sm inline-flex items-center py-xs text-primary transition-colors hover:text-accent-green-pale hover:underline"
            >
              About Us
            </a>
          </li>
          <li>
            <a
              href="/tentang-kami#legalitas"
              class="type-body-sm inline-flex items-center py-xs text-primary transition-colors hover:text-accent-green-pale hover:underline"
            >
              Investors & Legalitas
            </a>
          </li>
          <li>
            <a
              href="/tentang-kami#rekayasa"
              class="type-body-sm inline-flex items-center py-xs text-primary transition-colors hover:text-accent-green-pale hover:underline"
            >
              Tim Rekayasa EBT
            </a>
          </li>
          <li>
            <a
              href="/tentang-kami#keberlanjutan"
              class="type-body-sm inline-flex items-center py-xs text-primary transition-colors hover:text-accent-green-pale hover:underline"
            >
              INDOGREEN Foundation
            </a>
          </li>
          <li>
            <a
              href="/tentang-kami#riset"
              class="type-body-sm inline-flex items-center py-xs text-primary transition-colors hover:text-accent-green-pale hover:underline"
            >
              Research & Development
            </a>
          </li>
          <li>
            <a
              href="/tentang-kami#sertifikasi"
              class="type-body-sm inline-flex items-center py-xs text-primary transition-colors hover:text-accent-green-pale hover:underline"
            >
              Corporate Sustainability
            </a>
          </li>
          <li>
            <a
              href="/tentang-kami#teknologi"
              class="type-body-sm inline-flex items-center py-xs text-primary transition-colors hover:text-accent-green-pale hover:underline"
            >
              Technologies
            </a>
          </li>
          <li>
            <a
              href="/karir"
              class="type-body-sm inline-flex items-center py-xs text-primary transition-colors hover:text-accent-green-pale hover:underline"
            >
              Careers
            </a>
          </li>
        </ul>
      </div>

      <!-- Column 2: News and Events -->
      <div class="flex flex-col gap-sm">
        <h3 class="type-heading-md border-b border-hairline-strong/60 pb-xs font-bold text-on-dark">
          News and Events
        </h3>
        <ul class="flex flex-col gap-xs pt-xs">
          <li>
            <a
              href="/berita"
              class="type-body-sm inline-flex items-center py-xs text-primary transition-colors hover:text-accent-green-pale hover:underline"
            >
              Newsroom
            </a>
          </li>
          <li>
            <a
              href="/berita/blog"
              class="type-body-sm inline-flex items-center py-xs text-primary transition-colors hover:text-accent-green-pale hover:underline"
            >
              Company Blog
            </a>
          </li>
          <li>
            <a
              href="/resources"
              class="type-body-sm inline-flex items-center py-xs text-primary transition-colors hover:text-accent-green-pale hover:underline"
            >
              Technical Blog
            </a>
          </li>
          <li>
            <a
              href="/resources/webinar"
              class="type-body-sm inline-flex items-center py-xs text-primary transition-colors hover:text-accent-green-pale hover:underline"
            >
              Webinars
            </a>
          </li>
          <li>
            <a
              href="/berita#buletin"
              class="type-body-sm inline-flex items-center py-xs text-primary transition-colors hover:text-accent-green-pale hover:underline"
            >
              Stay Informed
            </a>
          </li>
          <li>
            <a
              href="/berita/agenda"
              class="type-body-sm inline-flex items-center py-xs text-primary transition-colors hover:text-accent-green-pale hover:underline"
            >
              Events Calendar
            </a>
          </li>
          <li>
            <a
              href="/solusi"
              class="type-body-sm inline-flex items-center py-xs text-primary transition-colors hover:text-accent-green-pale hover:underline"
            >
              GTC AI & EBT Conference
            </a>
          </li>
          <li>
            <a
              href="/resources#katalog"
              class="type-body-sm inline-flex items-center py-xs text-primary transition-colors hover:text-accent-green-pale hover:underline"
            >
              INDOGREEN On-Demand
            </a>
          </li>
        </ul>
      </div>

      <!-- Column 3: Popular Links -->
      <div class="flex flex-col gap-sm">
        <h3 class="type-heading-md border-b border-hairline-strong/60 pb-xs font-bold text-on-dark">
          Popular Links
        </h3>
        <ul class="flex flex-col gap-xs pt-xs">
          <li>
            <a
              href="/produk/pju-solar-cell-two-in-one"
              class="type-body-sm inline-flex items-center py-xs text-primary transition-colors hover:text-accent-green-pale hover:underline"
            >
              PJU Two-In-One (TIO)
            </a>
          </li>
          <li>
            <a
              href="/produk/pju-solar-cell-all-in-one"
              class="type-body-sm inline-flex items-center py-xs text-primary transition-colors hover:text-accent-green-pale hover:underline"
            >
              PJU All-In-One (AIO)
            </a>
          </li>
          <li>
            <a
              href="/solusi/plts-atap-surya"
              class="type-body-sm inline-flex items-center py-xs text-primary transition-colors hover:text-accent-green-pale hover:underline"
            >
              PLTS Atap Surya
            </a>
          </li>
          <li>
            <a
              href="/produk/solar-home-system"
              class="type-body-sm inline-flex items-center py-xs text-primary transition-colors hover:text-accent-green-pale hover:underline"
            >
              Solar Home System (SHS 3T)
            </a>
          </li>
          <li>
            <a
              href="/produk/komponen-baterai"
              class="type-body-sm inline-flex items-center py-xs text-primary transition-colors hover:text-accent-green-pale hover:underline"
            >
              Inverter & Baterai LiFePO4
            </a>
          </li>
          <li>
            <a
              href="/kontak#tender"
              class="type-body-sm inline-flex items-center py-xs text-primary transition-colors hover:text-accent-green-pale hover:underline"
            >
              Konsultasi Pengadaan LPSE
            </a>
          </li>
          <li>
            <a
              href="/resources/katalog-2026.pdf"
              class="type-body-sm inline-flex items-center py-xs text-primary transition-colors hover:text-accent-green-pale hover:underline"
            >
              Unduh Katalog 2026
            </a>
          </li>
        </ul>
      </div>
    </div>

    <!-- Newsletter & Social Media Bar -->
    <div
      class="mt-section flex flex-col items-center justify-between gap-xl border-t border-hairline-strong/50 pt-xl desktop:flex-row"
    >
      <!-- Newsletter Form -->
      <form
        onsubmit={handleSubscribe}
        class="flex w-full flex-wrap items-center gap-md desktop:w-auto"
      >
        <div class="flex items-center gap-sm">
          <Icon name="mail" size={26} class="shrink-0 text-primary" />
          <span class="type-body-strong font-bold text-on-dark"> Sign Up for INDOGREEN News </span>
        </div>

        {#if isSubscribed}
          <div
            class="type-caption-md flex items-center gap-xs rounded-sm bg-primary/20 px-md py-xs font-bold text-primary"
          >
            <Icon name="check" size={16} />
            <span>Terima kasih telah berlangganan buletin resmi INDOGREEN.</span>
          </div>
        {:else}
          <div class="flex flex-wrap items-center gap-xs">
            <input
              type="email"
              bind:value={subscriberEmail}
              placeholder="Alamat email Anda..."
              required
              aria-label="Alamat email buletin"
              class="type-body-sm h-touch min-w-60 rounded-sm border border-hairline-strong bg-surface-elevated px-input-x text-on-dark transition-colors outline-none placeholder:text-stone focus:border-2 focus:border-primary"
            />
            <Button variant="primary" size="md" type="submit">Subscribe</Button>
          </div>
        {/if}
      </form>

      <!-- Social Media Icons Strip -->
      <div class="flex items-center gap-md self-start desktop:self-center">
        <span class="type-caption-md font-bold tracking-wider text-on-dark-mute uppercase">
          Follow INDOGREEN
        </span>
        <div class="flex items-center gap-xs">
          <!-- Facebook -->
          <a
            href="https://facebook.com"
            target="_blank"
            rel="noopener noreferrer"
            aria-label="Facebook INDOGREEN"
            class="flex h-touch w-touch items-center justify-center text-on-dark-mute transition-colors hover:text-primary"
          >
            <svg class="h-5 w-5 fill-current" viewBox="0 0 24 24" aria-hidden="true">
              <path
                d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"
              />
            </svg>
          </a>

          <!-- Instagram -->
          <a
            href="https://instagram.com"
            target="_blank"
            rel="noopener noreferrer"
            aria-label="Instagram INDOGREEN"
            class="flex h-touch w-touch items-center justify-center text-on-dark-mute transition-colors hover:text-primary"
          >
            <svg class="h-5 w-5 fill-current" viewBox="0 0 24 24" aria-hidden="true">
              <path
                d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"
              />
            </svg>
          </a>

          <!-- LinkedIn -->
          <a
            href="https://linkedin.com"
            target="_blank"
            rel="noopener noreferrer"
            aria-label="LinkedIn INDOGREEN"
            class="flex h-touch w-touch items-center justify-center text-on-dark-mute transition-colors hover:text-primary"
          >
            <svg class="h-5 w-5 fill-current" viewBox="0 0 24 24" aria-hidden="true">
              <path
                d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"
              />
            </svg>
          </a>

          <!-- X (formerly Twitter) -->
          <a
            href="https://x.com"
            target="_blank"
            rel="noopener noreferrer"
            aria-label="X (formerly Twitter) INDOGREEN"
            class="flex h-touch w-touch items-center justify-center text-on-dark-mute transition-colors hover:text-primary"
          >
            <svg class="h-5 w-5 fill-current" viewBox="0 0 24 24" aria-hidden="true">
              <path
                d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"
              />
            </svg>
          </a>

          <!-- YouTube -->
          <a
            href="https://youtube.com"
            target="_blank"
            rel="noopener noreferrer"
            aria-label="YouTube INDOGREEN"
            class="flex h-touch w-touch items-center justify-center text-on-dark-mute transition-colors hover:text-primary"
          >
            <svg class="h-5 w-5 fill-current" viewBox="0 0 24 24" aria-hidden="true">
              <path
                d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"
              />
            </svg>
          </a>
        </div>
      </div>
    </div>
  </Container>
</footer>

<!-- Bottom Sub-Footer / Legal Bar (Canvas Surface per reference specification) -->
<div class="w-full border-t border-hairline bg-canvas py-lg text-ink select-none">
  <Container>
    <div class="flex flex-col gap-md">
      <!-- Official Brand Logo -->
      <div class="flex items-center">
        <img src="/indogreen.png" alt="Logo Resmi INDOGREEN" class="h-7 w-auto object-contain" />
      </div>

      <!-- Legal Links & Copyright Row -->
      <div
        class="type-utility-xs flex flex-col justify-between gap-sm text-mute tablet:flex-row tablet:items-center"
      >
        <div class="flex flex-wrap items-center gap-xs">
          <a href="/privasi" class="transition-colors hover:text-primary">Privacy Policy</a>
          <span aria-hidden="true" class="text-hairline">|</span>
          <a href="/privasi#pilihan" class="transition-colors hover:text-primary">
            Your Privacy Choices
          </a>
          <span aria-hidden="true" class="text-hairline">|</span>
          <a href="/syarat" class="transition-colors hover:text-primary">Terms of Service</a>
          <span aria-hidden="true" class="text-hairline">|</span>
          <a href="/aksesibilitas" class="transition-colors hover:text-primary">Accessibility</a>
          <span aria-hidden="true" class="text-hairline">|</span>
          <a href="/kebijakan" class="transition-colors hover:text-primary">Corporate Policies</a>
          <span aria-hidden="true" class="text-hairline">|</span>
          <a href="/keamanan" class="transition-colors hover:text-primary">Product Security</a>
          <span aria-hidden="true" class="text-hairline">|</span>
          <a href="/kontak" class="transition-colors hover:text-primary">Contact</a>
        </div>

        <span class="text-stone">
          Copyright &copy; 2026 PT. Indogreen Technology And Management. All rights reserved.
        </span>
      </div>
    </div>
  </Container>
</div>
