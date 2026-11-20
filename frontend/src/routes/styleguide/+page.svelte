<script lang="ts">
	import {
		Button,
		TextInput,
		Textarea,
		Select,
		Badge,
		PillTabs,
		CornerSquare,
		ProductCard,
		FeatureCard,
		ResourceCard,
		CalloutStat,
		Container,
		Section,
		Icon
	} from '#lib';

	let isDark = $state(false);

	function toggleDarkMode() {
		isDark = !isDark;
		if (typeof document !== 'undefined') {
			document.documentElement.classList.toggle('dark', isDark);
			document.documentElement.setAttribute('data-theme', isDark ? 'dark' : 'light');
		}
	}

	let sampleTab = $state('pju-all');
	let interactiveTextValue = $state('Helios Series 60W');
	let interactiveEmailValue = $state('rekayasa@indogreen.id');
	let interactiveTextareaValue = $state(
		'Mohon informasi penawaran teknis sistem PLTS On-Grid 50 kWp untuk area industri.'
	);
	let interactiveSelectValue = $state('tio');

	const tabList = [
		{ id: 'pju-all', label: 'Semua Produk' },
		{ id: 'pju-tio', label: 'Two-In-One (TIO)' },
		{ id: 'pju-aio', label: 'All-In-One (AIO)' },
		{ id: 'plts-rooftop', label: 'PLTS Atap Surya' },
		{ id: 'shs-pedesaan', label: 'Solar Home System' }
	];

	const selectOptions = [
		{ value: 'tio', label: 'PJU Tenaga Surya Two-In-One (TIO)' },
		{ value: 'aio', label: 'PJU Tenaga Surya All-In-One (AIO)' },
		{ value: 'shs', label: 'Solar Home System (SHS)' },
		{ value: 'ongrid', label: 'PLTS On-Grid Komersial / Residensial' }
	];

	const colorTokens = [
		{
			name: 'primary',
			hex: '#00b100',
			bg: 'bg-primary',
			text: 'text-on-primary',
			role: 'Brand green CTA & active'
		},
		{
			name: 'on-primary',
			hex: '#000000',
			bg: 'bg-on-primary',
			text: 'text-on-dark',
			role: 'Teks tombol hijau'
		},
		{
			name: 'primary-dark',
			hex: '#008a00',
			bg: 'bg-primary-dark',
			text: 'text-on-dark',
			role: 'Pressed CTA state'
		},
		{
			name: 'accent-yellow',
			hex: '#ffff00',
			bg: 'bg-accent-yellow',
			text: 'text-ink',
			role: 'Highlight gelap only'
		},
		{
			name: 'accent-yellow-pale',
			hex: '#ffffb3',
			bg: 'bg-accent-yellow-pale',
			text: 'text-ink',
			role: 'Editorial wash'
		},
		{
			name: 'accent-green-pale',
			hex: '#8cf03c',
			bg: 'bg-accent-green-pale',
			text: 'text-ink',
			role: 'Highlight aksen'
		},
		{
			name: 'canvas',
			hex: '#ffffff',
			bg: 'bg-canvas',
			text: 'text-ink',
			role: 'Badan halaman',
			border: true
		},
		{
			name: 'surface-dark',
			hex: '#000000',
			bg: 'bg-surface-dark',
			text: 'text-on-dark',
			role: 'Hero / Footer / Nav'
		},
		{
			name: 'surface-soft',
			hex: '#f7f7f7',
			bg: 'bg-surface-soft',
			text: 'text-ink',
			role: 'Sub-nav / Panel',
			border: true
		},
		{
			name: 'surface-elevated',
			hex: '#1a1a1a',
			bg: 'bg-surface-elevated',
			text: 'text-on-dark',
			role: 'Nested footer'
		},
		{
			name: 'hairline',
			hex: '#cccccc',
			bg: 'bg-hairline',
			text: 'text-ink',
			role: 'Border kartu / tabel'
		},
		{
			name: 'hairline-strong',
			hex: '#5e5e5e',
			bg: 'bg-hairline-strong',
			text: 'text-on-dark',
			role: 'Border gelap'
		},
		{ name: 'ink', hex: '#000000', bg: 'bg-ink', text: 'text-on-dark', role: 'Teks utama heading' },
		{ name: 'body', hex: '#1a1a1a', bg: 'bg-body', text: 'text-on-dark', role: 'Teks paragraf' },
		{
			name: 'mute',
			hex: '#757575',
			bg: 'bg-mute',
			text: 'text-on-dark',
			role: 'Metadata / Caption'
		},
		{ name: 'stone', hex: '#898989', bg: 'bg-stone', text: 'text-on-dark', role: 'Teks non-aktif' },
		{ name: 'ash', hex: '#a7a7a7', bg: 'bg-ash', text: 'text-ink', role: 'Ikon disabled' },
		{
			name: 'on-dark',
			hex: '#ffffff',
			bg: 'bg-on-dark',
			text: 'text-ink',
			role: 'Teks kanvas gelap',
			border: true
		},
		{
			name: 'link-blue',
			hex: '#0046a4',
			bg: 'bg-link-blue',
			text: 'text-on-dark',
			role: 'Tautan inline body'
		},
		{ name: 'error', hex: '#e52020', bg: 'bg-error', text: 'text-on-dark', role: 'Validasi error' },
		{
			name: 'warning',
			hex: '#df6500',
			bg: 'bg-warning',
			text: 'text-on-dark',
			role: 'Peringatan / Deprecated'
		},
		{
			name: 'success-deep',
			hex: '#007a00',
			bg: 'bg-success-deep',
			text: 'text-on-dark',
			role: 'Konfirmasi sukses'
		}
	];

	const typographyScale = [
		{
			token: 'display-xl',
			cssClass: 'type-display-xl',
			size: '48px',
			weight: '700',
			lh: '1.25',
			text: 'Teknologi Surya Terintegrasi'
		},
		{
			token: 'display-lg',
			cssClass: 'type-display-lg',
			size: '36px',
			weight: '700',
			lh: '1.25',
			text: 'Solusi Energi Terbarukan Masa Depan'
		},
		{
			token: 'heading-xl',
			cssClass: 'type-heading-xl',
			size: '24px',
			weight: '700',
			lh: '1.25',
			text: 'Lampu Penerangan Jalan Umum (PJU)'
		},
		{
			token: 'heading-lg',
			cssClass: 'type-heading-lg',
			size: '22px',
			weight: '400',
			lh: '1.75',
			text: 'Pengembangan sistem elektrifikasi terdesentralisasi untuk kemandirian energi nasional.'
		},
		{
			token: 'heading-md',
			cssClass: 'type-heading-md',
			size: '18px',
			weight: '700',
			lh: '1.4',
			text: 'Spesifikasi Rekayasa Elektrikal & Mekanikal'
		},
		{
			token: 'heading-sm',
			cssClass: 'type-heading-sm',
			size: '16px',
			weight: '700',
			lh: '1.5',
			text: 'Modul Panel Surya Monocrystalline Tier-1'
		},
		{
			token: 'subhead-lg',
			cssClass: 'type-subhead-lg',
			size: '17px',
			weight: '400',
			lh: '1.5',
			text: 'Dirancang untuk ketahanan operasi berkelanjutan pada kondisi iklim tropis Indonesia.'
		},
		{
			token: 'subhead-md',
			cssClass: 'type-subhead-md',
			size: '15px',
			weight: '400',
			lh: '1.5',
			text: 'Komponen bersertifikasi SNI dan uji laboratorium kelistrikan terakreditasi.'
		},
		{
			token: 'body-lg',
			cssClass: 'type-body-lg',
			size: '16px',
			weight: '400',
			lh: '1.5',
			text: 'Efisiensi konversi modul fotovoltaik mencapai lebih dari 21% dengan performa optimal radiasi rendah.'
		},
		{
			token: 'body-md',
			cssClass: 'type-body-md',
			size: '15px',
			weight: '400',
			lh: '1.5',
			text: 'Baterai LiFePO4 terintegrasi baterai cerdas dengan manajemen proteksi suhu dan siklus hingga 3.000 kali pengisian.'
		},
		{
			token: 'body-strong',
			cssClass: 'type-body-strong',
			size: '15px',
			weight: '700',
			lh: '1.5',
			text: 'Garansi resmi performa output sistem hingga 10 tahun.'
		},
		{
			token: 'body-sm',
			cssClass: 'type-body-sm',
			size: '14px',
			weight: '400',
			lh: '1.5',
			text: 'Instalasi praktis tanpa galian kabel bawah tanah yang rumit.'
		},
		{
			token: 'card-title',
			cssClass: 'type-card-title',
			size: '17px',
			weight: '700',
			lh: '1.25',
			text: 'Helios All-In-One 100W'
		},
		{
			token: 'button-lg',
			cssClass: 'type-button-lg',
			size: '16px',
			weight: '700',
			lh: '1',
			text: 'Minta Penawaran Teknis'
		},
		{
			token: 'button-md',
			cssClass: 'type-button-md',
			size: '14px',
			weight: '700',
			lh: '1',
			text: 'Lihat Brosur'
		},
		{
			token: 'button-sm',
			cssClass: 'type-button-sm',
			size: '13px',
			weight: '700',
			lh: '1',
			text: 'Unduh PDF'
		},
		{
			token: 'caption-md',
			cssClass: 'type-caption-md',
			size: '13px',
			weight: '700',
			lh: '1.25',
			text: 'Kategori: PJU Solar Cell'
		},
		{
			token: 'caption-sm',
			cssClass: 'type-caption-sm',
			size: '12px',
			weight: '400',
			lh: '1.25',
			text: 'Toleransi daya output: ±3%'
		},
		{
			token: 'caption-xs',
			cssClass: 'type-caption-xs',
			size: '11px',
			weight: '700',
			lh: '1',
			text: 'IP66 WEATHERPROOF'
		},
		{
			token: 'utility-xs',
			cssClass: 'type-utility-xs',
			size: '10px',
			weight: '700',
			lh: '1.5',
			text: 'STANDAR TENDER LPSE 2026'
		}
	];
</script>

<!-- Top Sticky Dev Toolbar with Dark Mode Toggle -->
<div
	class="sticky top-0 z-50 flex items-center justify-between border-b border-hairline bg-canvas/95 px-lg py-xs backdrop-blur select-none tablet:px-xl"
>
	<div class="flex items-center gap-sm">
		<div class="h-3 w-3 bg-primary"></div>
		<span class="type-caption-md font-bold tracking-wider text-ink uppercase">
			INDOGREEN Styleguide
		</span>
		<Badge variant="primary" class="hidden mobile:inline-flex">DEV ONLY</Badge>
	</div>

	<div class="flex items-center gap-sm">
		<span class="type-caption-sm hidden text-mute tablet:inline">Pratinjau Mode:</span>
		<button
			type="button"
			onclick={toggleDarkMode}
			class="type-button-sm flex cursor-pointer items-center gap-xs rounded-sm border border-hairline bg-surface-soft px-md py-xs text-ink transition-colors select-none hover:border-primary"
			aria-label={isDark ? 'Ganti ke Mode Terang' : 'Ganti ke Mode Gelap'}
		>
			{#if isDark}
				<Icon name="sun" size={16} class="text-accent-yellow" />
				<span class="font-bold">Mode Terang (Light)</span>
			{:else}
				<Icon name="moon" size={16} class="text-ink" />
				<span class="font-bold">Mode Gelap (Dark)</span>
			{/if}
		</button>
	</div>
</div>

<!-- Hero Section (Surface Dark) -->
<Section tone="dark" class="border-b border-hairline-strong">
	<Container>
		<div class="relative flex flex-col gap-lg py-xl">
			<CornerSquare position="top-left" size="lg" />
			<div class="flex items-center gap-sm">
				<Badge variant="primary">DEV ONLY</Badge>
				<span class="type-caption-md font-bold tracking-normal text-accent-yellow uppercase">
					DESIGN SYSTEM V1.0 (FROZEN SPECIFICATION)
				</span>
			</div>

			<h1 class="type-display-xl font-bold text-on-dark">INDOGREEN Design System</h1>

			<p class="type-heading-lg max-w-3xl text-on-dark-mute">
				Katalog token visual resmi, skala tipografi, dan pustaka komponen antarmuka rekayasa EBT
				berdasarkan <code class="font-mono text-primary">docs/DESIGN.md</code> dan
				<code class="font-mono text-primary">docs/05-design-decisions.md</code>.
			</p>

			<!-- Clean Hero Buttons: Zero Double Border -->
			<div class="flex flex-wrap items-center gap-md pt-sm">
				<Button variant="primary" size="lg" href="#buttons">
					<span>Telusuri Komponen</span>
					<Icon name="arrow-right" size={18} class="ml-xs" />
				</Button>
				<Button variant="outline-on-dark" size="lg" href="#typography">
					<span>Skala Tipografi</span>
				</Button>
			</div>
		</div>
	</Container>
</Section>

<!-- Color Palette Section (Canvas Light) -->
<Section tone="light" id="colors">
	<Container>
		<div class="flex flex-col gap-xl">
			<div>
				<div class="flex items-center gap-xs">
					<CornerSquare position="inline" size="sm" class="mr-xs" />
					<span class="type-caption-md font-bold text-primary uppercase">
						01. PALET WARNA RESMI
					</span>
				</div>
				<h2 class="type-display-lg mt-xs font-bold text-ink">Warna Brand, Permukaan & Semantik</h2>
				<p class="type-body-md mt-xs text-mute">
					Warna disampel langsung dari logo resmi INDOGREEN: Hijau (#00b100) dan Kuning (#ffff00).
					Tanpa gradien dekoratif.
				</p>
			</div>

			<div class="grid grid-cols-1 gap-lg tablet:grid-cols-2 desktop:grid-cols-4">
				{#each colorTokens as col (col.name)}
					<div class="flex flex-col overflow-hidden rounded-sm border border-hairline bg-canvas">
						<div
							class={`flex h-touch w-full items-center justify-between px-md ${col.bg} ${col.border ? 'border-b border-hairline' : ''}`}
						>
							<span class={`type-caption-xs font-bold uppercase ${col.text}`}>
								{col.hex}
							</span>
						</div>
						<div class="flex flex-col gap-xxs bg-canvas p-md">
							<span class="type-card-title font-bold text-ink">
								{col.name}
							</span>
							<span class="type-caption-sm text-mute">
								{col.role}
							</span>
						</div>
					</div>
				{/each}
			</div>
		</div>
	</Container>
</Section>

<!-- Typography Scale Section (Canvas Light) -->
<Section tone="soft" id="typography">
	<Container>
		<div class="flex flex-col gap-xl">
			<div>
				<div class="flex items-center gap-xs">
					<CornerSquare position="inline" size="sm" class="mr-xs" />
					<span class="type-caption-md font-bold text-primary uppercase">
						02. HIERARKI TIPOGRAFI
					</span>
				</div>
				<h2 class="type-display-lg mt-xs font-bold text-ink">18-Tier Inter Sans-Serif Scale</h2>
				<p class="type-body-md mt-xs text-mute">
					Inter (400 regular & 700 bold) self-hosted dengan font-display swap dan fallback Arial.
					Kontras hierarki mengandalkan bobot dan ukuran, bukan pewarnaan.
				</p>
			</div>

			<div
				class="flex flex-col divide-y divide-hairline overflow-hidden rounded-sm border border-hairline bg-canvas"
			>
				{#each typographyScale as type (type.token)}
					<div
						class="flex flex-col justify-between gap-md p-lg transition-colors hover:bg-surface-soft/60 tablet:flex-row tablet:items-baseline"
					>
						<div class="flex w-64 shrink-0 flex-col">
							<span class="type-body-strong text-ink">{type.token}</span>
							<span class="type-caption-sm text-mute">
								{type.size} · w{type.weight} · lh {type.lh}
							</span>
						</div>
						<div class={`flex-1 text-ink ${type.cssClass}`}>
							{type.text}
						</div>
					</div>
				{/each}
			</div>
		</div>
	</Container>
</Section>

<!-- Buttons & Affordances Section (Specimen Cards Layout per Image 4) -->
<Section tone="light" id="buttons">
	<Container>
		<div class="flex flex-col gap-xl">
			<div>
				<div class="flex items-center gap-xs">
					<CornerSquare position="inline" size="sm" class="mr-xs" />
					<span class="type-caption-md font-bold text-primary uppercase">
						03 — KOMPONEN & AFFORDANCE
					</span>
				</div>
				<h2 class="type-display-lg mt-xs font-bold text-ink">Button Variants & Specifications</h2>
				<p class="type-body-md mt-xs text-mute">
					Single-accent button system. Primary fill (#00b100) diperuntukkan bagi aksi utama; outline
					dan ghost-link membawa aksi sekunder. Radius 2px (rounded-sm), tinggi 44px WCAG AA, teks
					tombol hijau wajib hitam pekat (#000000). Tanpa pill button dan tanpa double border.
				</p>
			</div>

			<!-- 6-Card Specimen Grid (Engineering Layout matching Image 4) -->
			<div class="grid grid-cols-1 gap-xl tablet:grid-cols-2 desktop:grid-cols-3">
				<!-- Card 1: BUTTON-PRIMARY -->
				<div
					class="relative flex flex-col justify-between rounded-sm border border-hairline bg-canvas p-xl"
				>
					<CornerSquare position="top-left" size="sm" />
					<div class="flex min-h-[96px] items-center justify-start pt-sm">
						<Button variant="primary" size="md">Get Started</Button>
					</div>
					<div class="flex flex-col gap-xxs border-t border-hairline pt-md">
						<span class="type-caption-md font-bold text-ink uppercase">BUTTON-PRIMARY</span>
						<span class="type-caption-sm font-mono text-mute">
							bg primary · text on-primary · rounded sm · 44px height · pad 0/24
						</span>
					</div>
				</div>

				<!-- Card 2: BUTTON-PRIMARY-ACTIVE -->
				<div
					class="relative flex flex-col justify-between rounded-sm border border-hairline bg-canvas p-xl"
				>
					<CornerSquare position="top-left" size="sm" />
					<div class="flex min-h-[96px] items-center justify-start pt-sm">
						<button
							type="button"
							class="type-button-md min-h-touch rounded-sm bg-primary-dark px-btn-x py-btn-y font-bold text-on-primary transition-colors select-none"
						>
							Pressed
						</button>
					</div>
					<div class="flex flex-col gap-xxs border-t border-hairline pt-md">
						<span class="type-caption-md font-bold text-ink uppercase">
							BUTTON-PRIMARY-ACTIVE
						</span>
						<span class="type-caption-sm font-mono text-mute">
							bg primary-dark · text on-primary
						</span>
					</div>
				</div>

				<!-- Card 3: BUTTON-OUTLINE -->
				<div
					class="relative flex flex-col justify-between rounded-sm border border-hairline bg-canvas p-xl"
				>
					<CornerSquare position="top-left" size="sm" />
					<div class="flex min-h-[96px] items-center justify-start pt-sm">
						<Button variant="outline" size="md">Read the Docs</Button>
					</div>
					<div class="flex flex-col gap-xxs border-t border-hairline pt-md">
						<span class="type-caption-md font-bold text-ink uppercase">BUTTON-OUTLINE</span>
						<span class="type-caption-sm font-mono text-mute">
							transparent · text ink · 2px primary border · rounded sm
						</span>
					</div>
				</div>

				<!-- Card 4: BUTTON-OUTLINE-ON-DARK -->
				<div
					class="relative flex flex-col justify-between rounded-sm border border-hairline bg-surface-dark p-xl text-on-dark"
				>
					<CornerSquare position="top-left" size="sm" />
					<div class="flex min-h-[96px] items-center justify-start pt-sm">
						<Button variant="outline-on-dark" size="md">Watch Video</Button>
					</div>
					<div class="flex flex-col gap-xxs border-t border-hairline-strong pt-md">
						<span class="type-caption-md font-bold text-on-dark uppercase">
							BUTTON-OUTLINE-ON-DARK
						</span>
						<span class="type-caption-sm font-mono text-on-dark-mute">
							transparent · text on-dark · 1px on-dark border
						</span>
					</div>
				</div>

				<!-- Card 5: BUTTON-GHOST-LINK -->
				<div
					class="relative flex flex-col justify-between rounded-sm border border-hairline bg-canvas p-xl"
				>
					<CornerSquare position="top-left" size="sm" />
					<div class="flex min-h-[96px] items-center justify-start pt-sm">
						<Button variant="ghost-link" class="type-button-md font-bold uppercase">
							<span>LEARN MORE</span>
							<Icon name="arrow-right" size={16} class="ml-xs" />
						</Button>
					</div>
					<div class="flex flex-col gap-xxs border-t border-hairline pt-md">
						<span class="type-caption-md font-bold text-ink uppercase">BUTTON-GHOST-LINK</span>
						<span class="type-caption-sm font-mono text-mute">
							text primary · no bg · button-md weight
						</span>
					</div>
				</div>

				<!-- Card 6: BUTTON-DISABLED -->
				<div
					class="relative flex flex-col justify-between rounded-sm border border-hairline bg-canvas p-xl"
				>
					<CornerSquare position="top-left" size="sm" />
					<div class="flex min-h-[96px] items-center justify-start pt-sm">
						<Button variant="disabled" size="md">Disabled</Button>
					</div>
					<div class="flex flex-col gap-xxs border-t border-hairline pt-md">
						<span class="type-caption-md font-bold text-ink uppercase">BUTTON-DISABLED</span>
						<span class="type-caption-sm font-mono text-mute">bg surface-soft · text ash</span>
					</div>
				</div>
			</div>

			<!-- Touch Target Scale Comparison -->
			<div class="flex flex-col gap-md rounded-sm border border-hairline bg-canvas p-xl">
				<h3 class="type-heading-md font-bold text-ink">
					Touch Target Scale (WCAG 2.1 AA Compliant)
				</h3>
				<div class="flex flex-wrap items-center gap-md">
					<Button variant="primary" size="lg">Large (lg · 48px)</Button>
					<Button variant="primary" size="md">Medium (md · 44px)</Button>
					<Button variant="primary" size="sm">Small (sm · 44px touch)</Button>
				</div>
			</div>
		</div>
	</Container>
</Section>

<!-- Form Components Section (Specimen Layout per Image 6) -->
<Section tone="soft" id="forms">
	<Container>
		<div class="flex flex-col gap-xl">
			<div>
				<div class="flex items-center gap-xs">
					<CornerSquare position="inline" size="sm" class="mr-xs" />
					<span class="type-caption-md font-bold text-primary uppercase">
						04 — KOMPONEN FORMULIR
					</span>
				</div>
				<h2 class="type-display-lg mt-xs font-bold text-ink">Form Elements & States</h2>
				<p class="type-body-md mt-xs text-mute">
					2px-radius inputs with a Hairline border by default; on focus the border becomes a 2px
					INDOGREEN Green outline — the only focus signal in the system. Tanpa double border.
				</p>
			</div>

			<!-- Form Specimens Grid matching Image 6 -->
			<div class="grid grid-cols-1 gap-xl tablet:grid-cols-2">
				<!-- Specimen 1: DEFAULT INPUT -->
				<div
					class="relative flex flex-col justify-between rounded-sm border border-hairline bg-canvas p-xl"
				>
					<CornerSquare position="top-left" size="sm" />
					<div class="flex flex-col gap-xs pt-xs">
						<span class="type-caption-md font-bold text-ink uppercase">DEFAULT INPUT</span>
						<input
							type="text"
							placeholder="Email address"
							class="type-body-md h-touch w-full rounded-sm border border-hairline bg-canvas px-input-x py-input-y text-ink transition-colors outline-none placeholder:text-stone focus:border-2 focus:border-primary"
						/>
					</div>
					<div class="mt-lg border-t border-hairline pt-md">
						<span class="type-caption-sm font-mono text-mute">
							canvas bg · 1px hairline · rounded sm · 44px height
						</span>
					</div>
				</div>

				<!-- Specimen 2: FOCUSED INPUT -->
				<div
					class="relative flex flex-col justify-between rounded-sm border border-hairline bg-canvas p-xl"
				>
					<CornerSquare position="top-left" size="sm" />
					<div class="flex flex-col gap-xs pt-xs">
						<span class="type-caption-md font-bold text-ink uppercase">FOCUSED INPUT</span>
						<!-- Visual representation of clean focused input with 2px primary border, zero double outline -->
						<input
							type="text"
							value="user@example.com"
							readonly
							class="type-body-md h-touch w-full rounded-sm border-2 border-primary bg-canvas px-input-x py-input-y text-ink outline-none select-none"
						/>
					</div>
					<div class="mt-lg border-t border-hairline pt-md">
						<span class="type-caption-sm font-mono text-mute">2px primary border</span>
					</div>
				</div>

				<!-- Specimen 3: ERROR INPUT -->
				<div
					class="relative flex flex-col justify-between rounded-sm border border-hairline bg-canvas p-xl"
				>
					<CornerSquare position="top-left" size="sm" />
					<div class="flex flex-col gap-xs pt-xs">
						<span class="type-caption-md font-bold text-ink uppercase">ERROR INPUT</span>
						<input
							type="text"
							value="invalid email"
							readonly
							aria-invalid="true"
							class="type-body-md h-touch w-full rounded-sm border border-error bg-canvas px-input-x py-input-y text-ink outline-none select-none"
						/>
					</div>
					<div class="mt-lg border-t border-hairline pt-md">
						<span class="type-caption-sm font-mono text-mute">1px error border</span>
					</div>
				</div>

				<!-- Specimen 4: SEARCH INPUT -->
				<div
					class="relative flex flex-col justify-between rounded-sm border border-hairline bg-canvas p-xl"
				>
					<CornerSquare position="top-left" size="sm" />
					<div class="flex flex-col gap-xs pt-xs">
						<span class="type-caption-md font-bold text-ink uppercase">SEARCH INPUT</span>
						<div class="relative w-full">
							<input
								type="text"
								placeholder="Search INDOGREEN..."
								class="type-body-md h-search w-full rounded-sm border border-hairline bg-canvas pr-input-x pl-touch text-ink transition-colors outline-none placeholder:text-stone focus:border-2 focus:border-primary"
							/>
							<div
								class="pointer-events-none absolute top-1/2 left-3 -translate-y-1/2 text-mute"
								aria-hidden="true"
							>
								<Icon name="search" size={16} />
							</div>
						</div>
					</div>
					<div class="mt-lg border-t border-hairline pt-md">
						<span class="type-caption-sm font-mono text-mute">
							canvas bg · 1px hairline · 40px height
						</span>
					</div>
				</div>

				<!-- Specimen 5: TEXTAREA -->
				<div
					class="relative flex flex-col justify-between rounded-sm border border-hairline bg-canvas p-xl"
				>
					<CornerSquare position="top-left" size="sm" />
					<div class="flex flex-col gap-xs pt-xs">
						<span class="type-caption-md font-bold text-ink uppercase">TEXTAREA</span>
						<textarea
							rows={3}
							placeholder="Describe your use case..."
							class="type-body-md min-h-[96px] w-full rounded-sm border border-hairline bg-canvas px-input-x py-input-y text-ink transition-colors outline-none placeholder:text-stone focus:border-2 focus:border-primary"
						></textarea>
					</div>
					<div class="mt-lg border-t border-hairline pt-md">
						<span class="type-caption-sm font-mono text-mute">
							canvas bg · 1px hairline · rounded sm · min-height 96px
						</span>
					</div>
				</div>

				<!-- Specimen 6: SUBMIT BUTTON -->
				<div
					class="relative flex flex-col justify-between rounded-sm border border-hairline bg-canvas p-xl"
				>
					<CornerSquare position="top-left" size="sm" />
					<div class="flex flex-col gap-xs pt-xs">
						<span class="type-caption-md font-bold text-ink uppercase">SUBMIT</span>
						<Button variant="primary" size="md" class="w-full">Submit Form</Button>
					</div>
					<div class="mt-lg border-t border-hairline pt-md">
						<span class="type-caption-sm font-mono text-mute">
							button-primary · always full-width below stacked fields
						</span>
					</div>
				</div>
			</div>

			<!-- Interactive Form Component Sandbox -->
			<div class="flex flex-col gap-lg rounded-sm border border-hairline bg-canvas p-xl">
				<h3 class="type-heading-md font-bold text-ink">Interactive Form Sandbox</h3>
				<div class="grid grid-cols-1 gap-xl tablet:grid-cols-2">
					<TextInput
						label="Nama Produk atau Komponen"
						bind:value={interactiveTextValue}
						hint="Masukkan seri lampu atau spesifikasi daya"
						required={true}
					/>
					<TextInput
						label="Alamat Email Kontak"
						bind:value={interactiveEmailValue}
						hint="Masukkan email resmi perusahaan"
						required={true}
					/>
					<Select
						label="Kategori Sistem EBT"
						bind:value={interactiveSelectValue}
						options={selectOptions}
						hint="Pilih jenis paket kelistrikan surya"
						required={true}
					/>
					<TextInput
						label="Status Otorisasi Tender"
						value="TERVERIFIKASI SISTEM"
						disabled={true}
						hint="Field ini dikunci otomatis oleh sistem pengadaan"
					/>
					<div class="col-span-1 tablet:col-span-2">
						<Textarea
							label="Catatan Teknis Rekayasa / Deskripsi Proyek"
							bind:value={interactiveTextareaValue}
							hint="Minimal tinggi 120px dengan scroll otomatis"
							required={true}
						/>
					</div>
				</div>
			</div>
		</div>
	</Container>
</Section>

<!-- Badges, PillTabs & Decorative Section (Specimens matching Image 8) -->
<Section tone="light" id="decorative">
	<Container>
		<div class="flex flex-col gap-xl">
			<div>
				<div class="flex items-center gap-xs">
					<CornerSquare position="inline" size="sm" class="mr-xs" />
					<span class="type-caption-md font-bold text-primary uppercase">
						05 — BADGE, TABS & ORNAMEN
					</span>
				</div>
				<h2 class="type-display-lg mt-xs font-bold text-ink">
					PillTabs, Badges & Signature Square
				</h2>
				<p class="type-body-md mt-xs text-mute">
					PillTabs dengan batas 1px hairline saat inaktif dan isian solid ink (#000000) saat aktif.
					Badge Tag dengan latar surface-soft (#f7f7f7) dan tipografi kapital caption-md.
					CornerSquare 12x12px hijau brand #00b100.
				</p>
			</div>

			<!-- Specimen Card 1: PILL-TAB + PILL-TAB-ACTIVE (Image 8 style) -->
			<div
				class="relative flex flex-col justify-between rounded-sm border border-hairline bg-canvas p-xl"
			>
				<CornerSquare position="top-left" size="sm" />
				<div class="flex flex-col gap-md pt-xs">
					<span class="type-heading-md font-bold text-ink">PILL-TAB + PILL-TAB-ACTIVE</span>
					<div class="pt-xs">
						<PillTabs tabs={tabList} bind:activeTab={sampleTab} />
					</div>
					<p class="type-caption-sm text-mute">
						Tab aktif saat ini: <strong class="text-ink">{sampleTab}</strong>
					</p>
				</div>
				<div class="mt-lg border-t border-hairline pt-md">
					<span class="type-caption-sm font-mono text-mute">
						default: transparent + 1px hairline · active: ink fill + on-dark text
					</span>
				</div>
			</div>

			<!-- Specimen Card 2: BADGE-TAG (Image 8 style) -->
			<div
				class="relative flex flex-col justify-between rounded-sm border border-hairline bg-canvas p-xl"
			>
				<CornerSquare position="top-left" size="sm" />
				<div class="flex flex-col gap-md pt-xs">
					<span class="type-heading-md font-bold text-ink">BADGE-TAG</span>
					<div class="flex flex-wrap items-center gap-sm pt-xs">
						<Badge variant="default">WHITE PAPER</Badge>
						<Badge variant="default">WEBINAR</Badge>
						<Badge variant="default">BLOG</Badge>
						<Badge variant="default">STUDI KASUS</Badge>
						<Badge variant="default">DOCUMENTATION</Badge>
					</div>
				</div>
				<div class="mt-lg border-t border-hairline pt-md">
					<span class="type-caption-sm font-mono text-mute">
						bg surface-soft · text body · uppercase caption-md · rounded sm
					</span>
				</div>
			</div>

			<!-- Secondary Semantic Badges Row -->
			<div class="flex flex-col gap-md rounded-sm border border-hairline bg-canvas p-xl">
				<h3 class="type-heading-md font-bold text-ink">Semantic Highlight Badges</h3>
				<div class="flex flex-wrap items-center gap-sm">
					<Badge variant="primary">PRODUK BARU</Badge>
					<Badge variant="dark">OFF-GRID SYSTEM</Badge>
					<Badge variant="outline">SNI / TKDN</Badge>
					<Badge variant="default">KATALOG 2026</Badge>
				</div>
			</div>

			<!-- Specimen Card 3: Corner Square Motif -->
			<div
				class="relative flex flex-col justify-between rounded-sm border border-hairline bg-canvas p-xl"
			>
				<CornerSquare position="top-left" size="sm" />
				<div class="flex flex-col gap-md pt-xs">
					<span class="type-heading-md font-bold text-ink">CORNER SQUARE (SIGNATURE MOTIF)</span>
					<div class="flex flex-wrap items-center gap-xl pt-xs">
						<div class="relative h-20 w-36 border border-hairline bg-surface-soft p-sm">
							<CornerSquare position="top-left" size="sm" />
							<span class="type-caption-xs absolute bottom-2 left-2 text-mute">Top-Left 12x12</span>
						</div>
						<div class="relative h-20 w-36 border border-hairline bg-surface-soft p-sm">
							<CornerSquare position="bottom-right" size="sm" />
							<span class="type-caption-xs absolute top-2 left-2 text-mute">
								Bottom-Right 12x12
							</span>
						</div>
						<div class="relative h-20 w-36 bg-surface-dark p-sm">
							<CornerSquare position="top-left" size="lg" />
							<span class="type-caption-xs absolute bottom-2 left-2 text-on-dark-mute">
								Hero Square 16x16
							</span>
						</div>
					</div>
				</div>
				<div class="mt-lg border-t border-hairline pt-md">
					<span class="type-caption-sm font-mono text-mute">
						solid brand green #00b100 · 12x12 card motif / 16x16 hero motif
					</span>
				</div>
			</div>
		</div>
	</Container>
</Section>

<!-- Cards & Stats Section -->
<Section tone="soft" id="cards">
	<Container>
		<div class="flex flex-col gap-xl">
			<div>
				<div class="flex items-center gap-xs">
					<CornerSquare position="inline" size="sm" class="mr-xs" />
					<span class="type-caption-md font-bold text-primary uppercase">
						06. KARTU & METRIK CALLOUT
					</span>
				</div>
				<h2 class="type-display-lg mt-xs font-bold text-ink">
					ProductCard, FeatureCard, ResourceCard & CalloutStat
				</h2>
				<p class="type-body-md mt-xs text-mute">
					Seluruh kartu memiliki elevasi datar (flat hairline border 1px #cccccc) tanpa drop shadow.
					Hover border aktif #00b100.
				</p>
			</div>

			<!-- Product Cards Grid -->
			<div class="flex flex-col gap-md">
				<h3 class="type-heading-md font-bold text-ink">Product Cards (4-Up Desktop Grid)</h3>
				<div class="grid grid-cols-1 gap-xl tablet:grid-cols-2 desktop:grid-cols-3">
					<ProductCard
						title="Helios Two-In-One 60W"
						category="PJU TWO-IN-ONE"
						description="Lampu jalan tenaga surya efisiensi tinggi dengan baterai LiFePO4 terpisah pada modul arm."
						href="#katalog"
						ctaText="Lihat Spesifikasi"
					/>
					<ProductCard
						title="Jupiter All-In-One 100W"
						category="PJU ALL-IN-ONE"
						description="Desain ringkas dan kokoh dengan panel surya, lampu LED, dan kontroler cerdas terintegrasi."
						href="#katalog"
						ctaText="Lihat Spesifikasi"
					/>
					<ProductCard
						title="Mars Hybrid 120W"
						category="PJU HYBRID"
						description="Sistem penerangan jalan surya dengan kemampuan backup daya ganda untuk keandalan maksimal."
						href="#katalog"
						ctaText="Lihat Spesifikasi"
					/>
				</div>
			</div>

			<!-- Feature Cards Grid -->
			<div class="flex flex-col gap-md">
				<h3 class="type-heading-md font-bold text-ink">Feature Cards (Spesifikasi Teknis)</h3>
				<div class="grid grid-cols-1 gap-xl tablet:grid-cols-2 desktop:grid-cols-3">
					<FeatureCard
						icon="battery-charging"
						title="Baterai LiFePO4 Mutakhir"
						description="Daya tahan siklus hidup lebih dari 3.000 cycle dengan proteksi cerdas terhadap suhu ekstrem dan overcharge."
					/>
					<FeatureCard
						icon="sun"
						title="Panel Surya Monocrystalline"
						description="Efisiensi konversi modul fotovoltaik mencapai >21% menjamin pengisian daya optimal pada cuaca mendung."
					/>
					<FeatureCard
						icon="shield-check"
						title="Standar Proteksi IP66 / IK08"
						description="Ketahanan korosi tingkat tinggi dengan bodi aluminium die-cast yang mampu bertahan di lingkungan pantai."
					/>
				</div>
			</div>

			<!-- Resource Cards Grid -->
			<div class="flex flex-col gap-md">
				<h3 class="type-heading-md font-bold text-ink">Resource Cards (Unduhan Dokumen)</h3>
				<div class="grid grid-cols-1 gap-xl tablet:grid-cols-2 desktop:grid-cols-3">
					<ResourceCard
						typeLabel="BROSUR TEKNIS"
						title="Katalog PJU Tenaga Surya 2026"
						description="Spesifikasi elektrikal dan mekanikal lengkap seri Helios, Jupiter, dan Mars."
						href="#unduh"
						ctaText="Unduh Katalog PDF"
					/>
					<ResourceCard
						typeLabel="PANDUAN SISTEM"
						title="White Paper Rekayasa PLTS On-Grid"
						description="Panduan implementasi PLTS atap industri dan integrasi net-metering PLN."
						href="#unduh"
						ctaText="Baca White Paper"
					/>
					<ResourceCard
						typeLabel="SERTIFIKASI"
						title="Laporan Uji UPT & TKDN"
						description="Sertifikasi kepatuhan standar SNI dan tingkat komponen dalam negeri produk INDOGREEN."
						href="#unduh"
						ctaText="Unduh Sertifikat"
					/>
				</div>
			</div>

			<!-- Callout Stats Grid -->
			<div class="flex flex-col gap-md">
				<h3 class="type-heading-md font-bold text-ink">Callout Statistics</h3>
				<div class="grid grid-cols-1 gap-xl tablet:grid-cols-2 desktop:grid-cols-4">
					<CalloutStat
						value="21.5%"
						label="Efisiensi Modul PV"
						caption="Standar pengujian radiasi STC"
					/>
					<CalloutStat value="3,000+" label="Siklus Baterai" caption="Kapasitas LiFePO4 >80% DoD" />
					<CalloutStat
						value="50,000"
						label="Jam Masa Pakai LED"
						caption="L70B10 pada suhu ambien 35°C"
					/>
					<CalloutStat
						value="IP66"
						label="Indeks Proteksi"
						caption="Tahan debu & semprotan air kuat"
					/>
				</div>
			</div>
		</div>
	</Container>
</Section>
