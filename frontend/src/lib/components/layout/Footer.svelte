<script lang="ts">
  import type { SiteSettings } from '$lib/types';
  import Container from '$lib/components/ui/Container.svelte';
  import Button from '$lib/components/ui/Button.svelte';
  import Icon from '$lib/components/ui/Icon.svelte';
  import Logo from './Logo.svelte';

  interface Props {
    settings?: SiteSettings;
    class?: string;
  }

  let { settings, class: className = '' }: Props = $props();

  const currentYear = new Date().getFullYear();

  // Accordion state for mobile (< 768px)
  let openSections = $state<Record<string, boolean>>({
    produk: false,
    solusi: false,
    perusahaan: false,
    kontak: false
  });

  function toggleSection(sectionKey: string) {
    openSections[sectionKey] = !openSections[sectionKey];
  }

  let subscriberEmail = $state('');
  let isSubscribed = $state(false);

  function handleSubscribe(e: SubmitEvent) {
    e.preventDefault();
    if (subscriberEmail.trim()) {
      isSubscribed = true;
    }
  }

  const phone = $derived(settings?.phone || '+62 251 754 1234');
  const email = $derived(settings?.email || 'marketing@indogreen.id');
  const whatsapp = $derived(settings?.whatsapp || '+62 811 1234 5678');
  const headOffice = $derived(
    settings?.head_office_address ||
      'Ruko Taman Yasmin Sektor 6 No. 226, Kota Bogor, Jawa Barat 16113'
  );
  const social = $derived(settings?.social_links);
</script>

<!-- Main Dark Footer Chapter (Surface Dark #000000) -->
<footer
  class={['relative w-full bg-surface-dark pt-section pb-xl text-on-dark select-none', className]
    .filter(Boolean)
    .join(' ')}
  aria-label="Footer Navigasi dan Informasi Perusahaan"
  data-testid="footer-section"
>
  <Container>
    <!-- 4-Column Technical Link Grid (Produk, Solusi, Perusahaan, Kontak) -->
    <div
      class="grid grid-cols-1 gap-md tablet:grid-cols-2 tablet:gap-xl desktop:grid-cols-4 desktop:gap-xxl"
    >
      <!-- Column 1: Produk -->
      <div class="border-b border-hairline-strong/50 pb-sm tablet:border-b-0 tablet:pb-0">
        <button
          type="button"
          onclick={() => toggleSection('produk')}
          class="focus-ring flex w-full items-center justify-between py-xs text-left font-bold tablet:cursor-default tablet:py-0"
          aria-expanded={openSections.produk}
          aria-controls="footer-col-produk"
          data-testid="footer-accordion-produk"
        >
          <span class="type-heading-md text-on-dark">Produk</span>
          <span class="text-primary tablet:hidden" aria-hidden="true">
            <Icon name={openSections.produk ? 'chevron-up' : 'chevron-down'} size={20} />
          </span>
        </button>

        <div
          id="footer-col-produk"
          class={['pt-xs tablet:block', openSections.produk ? 'block' : 'hidden'].join(' ')}
        >
          <ul class="flex flex-col gap-xs pt-xs">
            <li>
              <a
                href="/produk/pju-tenaga-surya/pju-two-in-one-helios-series"
                class="type-body-sm focus-ring inline-flex items-center py-xs text-primary transition-colors hover:text-accent-green-pale hover:underline"
              >
                PJU Two-In-One (TIO)
              </a>
            </li>
            <li>
              <a
                href="/produk/pju-tenaga-surya/pju-all-in-one-mars-series"
                class="type-body-sm focus-ring inline-flex items-center py-xs text-primary transition-colors hover:text-accent-green-pale hover:underline"
              >
                PJU All-In-One (AIO)
              </a>
            </li>
            <li>
              <a
                href="/produk/plts-residential"
                class="type-body-sm focus-ring inline-flex items-center py-xs text-primary transition-colors hover:text-accent-green-pale hover:underline"
              >
                PLTS Residensial & Atap
              </a>
            </li>
            <li>
              <a
                href="/produk/solar-home-system"
                class="type-body-sm focus-ring inline-flex items-center py-xs text-primary transition-colors hover:text-accent-green-pale hover:underline"
              >
                Solar Home System (SHS 3T)
              </a>
            </li>
            <li>
              <a
                href="/produk/aksesoris-kelistrikan"
                class="type-body-sm focus-ring inline-flex items-center py-xs text-primary transition-colors hover:text-accent-green-pale hover:underline"
              >
                Inverter & Baterai LiFePO4
              </a>
            </li>
          </ul>
        </div>
      </div>

      <!-- Column 2: Solusi -->
      <div class="border-b border-hairline-strong/50 pb-sm tablet:border-b-0 tablet:pb-0">
        <button
          type="button"
          onclick={() => toggleSection('solusi')}
          class="focus-ring flex w-full items-center justify-between py-xs text-left font-bold tablet:cursor-default tablet:py-0"
          aria-expanded={openSections.solusi}
          aria-controls="footer-col-solusi"
          data-testid="footer-accordion-solusi"
        >
          <span class="type-heading-md text-on-dark">Solusi</span>
          <span class="text-primary tablet:hidden" aria-hidden="true">
            <Icon name={openSections.solusi ? 'chevron-up' : 'chevron-down'} size={20} />
          </span>
        </button>

        <div
          id="footer-col-solusi"
          class={['pt-xs tablet:block', openSections.solusi ? 'block' : 'hidden'].join(' ')}
        >
          <ul class="flex flex-col gap-xs pt-xs">
            <li>
              <a
                href="/solusi/plts-on-grid"
                class="type-body-sm focus-ring inline-flex items-center py-xs text-primary transition-colors hover:text-accent-green-pale hover:underline"
              >
                PLTS On-Grid System
              </a>
            </li>
            <li>
              <a
                href="/solusi/plts-on-grid-hybrid"
                class="type-body-sm focus-ring inline-flex items-center py-xs text-primary transition-colors hover:text-accent-green-pale hover:underline"
              >
                PLTS On-Grid Hybrid
              </a>
            </li>
            <li>
              <a
                href="/solusi/plts-off-grid"
                class="type-body-sm focus-ring inline-flex items-center py-xs text-primary transition-colors hover:text-accent-green-pale hover:underline"
              >
                PLTS Off-Grid Mandiri
              </a>
            </li>
            <li>
              <a
                href="/solusi/plts-off-grid-hybrid"
                class="type-body-sm focus-ring inline-flex items-center py-xs text-primary transition-colors hover:text-accent-green-pale hover:underline"
              >
                PLTS Off-Grid Hybrid
              </a>
            </li>
            <li>
              <a
                href="/solusi/backup-power-ups"
                class="type-body-sm focus-ring inline-flex items-center py-xs text-primary transition-colors hover:text-accent-green-pale hover:underline"
              >
                Backup Power / UPS Surya
              </a>
            </li>
          </ul>
        </div>
      </div>

      <!-- Column 3: Perusahaan -->
      <div class="border-b border-hairline-strong/50 pb-sm tablet:border-b-0 tablet:pb-0">
        <button
          type="button"
          onclick={() => toggleSection('perusahaan')}
          class="focus-ring flex w-full items-center justify-between py-xs text-left font-bold tablet:cursor-default tablet:py-0"
          aria-expanded={openSections.perusahaan}
          aria-controls="footer-col-perusahaan"
          data-testid="footer-accordion-perusahaan"
        >
          <span class="type-heading-md text-on-dark">Perusahaan</span>
          <span class="text-primary tablet:hidden" aria-hidden="true">
            <Icon name={openSections.perusahaan ? 'chevron-up' : 'chevron-down'} size={20} />
          </span>
        </button>

        <div
          id="footer-col-perusahaan"
          class={['pt-xs tablet:block', openSections.perusahaan ? 'block' : 'hidden'].join(' ')}
        >
          <ul class="flex flex-col gap-xs pt-xs">
            <li>
              <a
                href="/tentang-kami"
                class="type-body-sm focus-ring inline-flex items-center py-xs text-primary transition-colors hover:text-accent-green-pale hover:underline"
              >
                Tentang Kami
              </a>
            </li>
            <li>
              <a
                href="/tentang-kami#visi-misi"
                class="type-body-sm focus-ring inline-flex items-center py-xs text-primary transition-colors hover:text-accent-green-pale hover:underline"
              >
                Visi & Misi Hijau
              </a>
            </li>
            <li>
              <a
                href="/tentang-kami#legalitas"
                class="type-body-sm focus-ring inline-flex items-center py-xs text-primary transition-colors hover:text-accent-green-pale hover:underline"
              >
                Legalitas & Sertifikasi EBT
              </a>
            </li>
            <li>
              <a
                href="/tentang-kami#rekayasa"
                class="type-body-sm focus-ring inline-flex items-center py-xs text-primary transition-colors hover:text-accent-green-pale hover:underline"
              >
                Tim Rekayasa Sistem
              </a>
            </li>
            <li>
              <a
                href="/tentang-kami#after-sales"
                class="type-body-sm focus-ring inline-flex items-center py-xs text-primary transition-colors hover:text-accent-green-pale hover:underline"
              >
                Layanan Purna Jual
              </a>
            </li>
          </ul>
        </div>
      </div>

      <!-- Column 4: Kontak -->
      <div>
        <button
          type="button"
          onclick={() => toggleSection('kontak')}
          class="focus-ring flex w-full items-center justify-between py-xs text-left font-bold tablet:cursor-default tablet:py-0"
          aria-expanded={openSections.kontak}
          aria-controls="footer-col-kontak"
          data-testid="footer-accordion-kontak"
        >
          <span class="type-heading-md text-on-dark">Kontak</span>
          <span class="text-primary tablet:hidden" aria-hidden="true">
            <Icon name={openSections.kontak ? 'chevron-up' : 'chevron-down'} size={20} />
          </span>
        </button>

        <div
          id="footer-col-kontak"
          class={['pt-xs tablet:block', openSections.kontak ? 'block' : 'hidden'].join(' ')}
        >
          <ul class="type-body-sm flex flex-col gap-xs pt-xs text-on-dark-mute">
            <li class="flex items-start gap-xs">
              <Icon name="map-pin" size={16} class="mt-1 shrink-0 text-primary" />
              <span>{headOffice}</span>
            </li>
            <li class="flex items-center gap-xs">
              <Icon name="phone" size={16} class="shrink-0 text-primary" />
              <a
                href="tel:{phone.replace(/\s+/g, '')}"
                class="focus-ring text-primary transition-colors hover:text-accent-green-pale hover:underline"
              >
                {phone}
              </a>
            </li>
            <li class="flex items-center gap-xs">
              <Icon name="phone" size={16} class="shrink-0 text-primary" />
              <a
                href="https://wa.me/{whatsapp.replace(/[^0-9]/g, '')}"
                target="_blank"
                rel="noopener noreferrer"
                class="focus-ring text-primary transition-colors hover:text-accent-green-pale hover:underline"
              >
                WhatsApp: {whatsapp}
              </a>
            </li>
            <li class="flex items-center gap-xs">
              <Icon name="mail" size={16} class="shrink-0 text-primary" />
              <a
                href="mailto:{email}"
                class="focus-ring text-primary transition-colors hover:text-accent-green-pale hover:underline"
              >
                {email}
              </a>
            </li>
            <li class="pt-xs">
              <a
                href="/kontak"
                class="type-caption-md focus-ring inline-flex items-center gap-xs rounded-sm border border-primary px-sm py-xs font-bold text-primary transition-colors hover:bg-primary/10"
              >
                <span>Formulir Konsultasi Proyek</span>
                <Icon name="arrow-right" size={14} />
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Newsletter & Social Media Bar -->
    <div
      class="mt-section flex flex-col items-center justify-between gap-xl border-t border-hairline-strong/50 pt-xl desktop:flex-row"
    >
      <!-- Newsletter Subscription Form -->
      <form
        onsubmit={handleSubscribe}
        class="flex w-full flex-wrap items-center gap-md desktop:w-auto"
      >
        <div class="flex items-center gap-sm">
          <Icon name="mail" size={24} class="shrink-0 text-primary" />
          <span class="type-body-strong font-bold text-on-dark">Buletin Resmi INDOGREEN</span>
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
          Ikuti INDOGREEN
        </span>
        <div class="flex items-center gap-xs text-on-dark-mute">
          <!-- Facebook -->
          <a
            href={social?.facebook || 'https://facebook.com/indogreen.id'}
            target="_blank"
            rel="noopener noreferrer"
            aria-label="Facebook INDOGREEN"
            class="focus-ring flex h-touch w-touch items-center justify-center transition-colors hover:text-primary"
          >
            <svg class="h-5 w-5 fill-current" viewBox="0 0 24 24" aria-hidden="true">
              <path
                d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"
              />
            </svg>
          </a>

          <!-- Instagram -->
          <a
            href={social?.instagram || 'https://instagram.com/indogreen.id'}
            target="_blank"
            rel="noopener noreferrer"
            aria-label="Instagram INDOGREEN"
            class="focus-ring flex h-touch w-touch items-center justify-center transition-colors hover:text-primary"
          >
            <svg class="h-5 w-5 fill-current" viewBox="0 0 24 24" aria-hidden="true">
              <path
                d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"
              />
            </svg>
          </a>

          <!-- LinkedIn -->
          <a
            href={social?.linkedin || 'https://linkedin.com/company/indogreen'}
            target="_blank"
            rel="noopener noreferrer"
            aria-label="LinkedIn INDOGREEN"
            class="focus-ring flex h-touch w-touch items-center justify-center transition-colors hover:text-primary"
          >
            <svg class="h-5 w-5 fill-current" viewBox="0 0 24 24" aria-hidden="true">
              <path
                d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"
              />
            </svg>
          </a>

          <!-- YouTube -->
          <a
            href={social?.youtube || 'https://youtube.com/@indogreentechnology'}
            target="_blank"
            rel="noopener noreferrer"
            aria-label="YouTube INDOGREEN"
            class="focus-ring flex h-touch w-touch items-center justify-center transition-colors hover:text-primary"
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
<div
  class="w-full border-t border-hairline bg-canvas py-lg text-ink select-none"
  data-testid="footer-subbar"
>
  <Container>
    <div class="flex flex-col gap-md">
      <!-- Official Brand Logo -->
      <div class="flex items-center">
        <Logo imgClass="h-7 w-auto object-contain" />
      </div>

      <!-- Legal Links & Copyright Row (utility-xs typography) -->
      <div
        class="type-utility-xs flex flex-col justify-between gap-sm text-mute tablet:flex-row tablet:items-center"
      >
        <div class="flex flex-wrap items-center gap-xs">
          <a href="/kebijakan-privasi" class="focus-ring transition-colors hover:text-primary">
            Privacy Policy
          </a>
          <span aria-hidden="true" class="text-hairline">|</span>
          <a
            href="/kebijakan-privasi#syarat"
            class="focus-ring transition-colors hover:text-primary"
          >
            Terms of Service
          </a>
          <span aria-hidden="true" class="text-hairline">|</span>
          <a
            href="/kebijakan-privasi#aksesibilitas"
            class="focus-ring transition-colors hover:text-primary"
          >
            Accessibility
          </a>
          <span aria-hidden="true" class="text-hairline">|</span>
          <a
            href="/kebijakan-privasi#keamanan"
            class="focus-ring transition-colors hover:text-primary"
          >
            Product Security
          </a>
          <span aria-hidden="true" class="text-hairline">|</span>
          <a href="/kontak" class="focus-ring transition-colors hover:text-primary">Contact</a>
        </div>

        <span class="text-stone">
          Copyright &copy; {currentYear} PT. Indogreen Technology And Management. All rights reserved.
        </span>
      </div>
    </div>
  </Container>
</div>
