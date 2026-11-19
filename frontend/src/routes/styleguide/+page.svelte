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

	let sampleTab = $state('pju-all');
	let textValue = $state('Helios Series 60W');
	let errorTextValue = $state('invalid-input');
	let textareaValue = $state('Mohon informasi penawaran teknis sistem PLTS On-Grid 50 kWp.');
	let selectValue = $state('tio');

	const tabList = [
		{ id: 'pju-all', label: 'SEMUA PRODUK' },
		{ id: 'pju-tio', label: 'TWO-IN-ONE (TIO)' },
		{ id: 'pju-aio', label: 'ALL-IN-ONE (AIO)' },
		{ id: 'plts-rooftop', label: 'PLTS ATAP SURYA' }
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
			size: '20px',
			weight: '700',
			lh: '1.25',
			text: 'Sistem All-In-One Seri Jupiter'
		},
		{
			token: 'heading-sm',
			cssClass: 'type-heading-sm',
			size: '18px',
			weight: '700',
			lh: '1.4',
			text: 'Filter Spesifikasi Teknis Baterai'
		},
		{
			token: 'card-title',
			cssClass: 'type-card-title',
			size: '17px',
			weight: '700',
			lh: '1.47',
			text: 'Helios TIO Solar Street Light 120W'
		},
		{
			token: 'body-md',
			cssClass: 'type-body-md',
			size: '16px',
			weight: '400',
			lh: '1.5',
			text: 'Standar baterai LiFePO4 dengan proteksi BMS ganda dan efisiensi modul surya monokristalin.'
		},
		{
			token: 'body-strong',
			cssClass: 'type-body-strong',
			size: '16px',
			weight: '700',
			lh: '1.5',
			text: 'Garansi Operasional 3 Tahun dan Layanan Purna Jual Resmi'
		},
		{
			token: 'body-sm',
			cssClass: 'type-body-sm',
			size: '15px',
			weight: '400',
			lh: '1.67',
			text: 'Instalasi tiang oktagonal tahan korosi dengan proteksi ingress IP66.'
		},
		{
			token: 'button-lg',
			cssClass: 'type-button-lg',
			size: '18px',
			weight: '700',
			lh: '1.25',
			text: 'KONSULTASI SEKARANG'
		},
		{
			token: 'button-md',
			cssClass: 'type-button-md',
			size: '16px',
			weight: '700',
			lh: '1.25',
			text: 'LIHAT SPESIFIKASI'
		},
		{
			token: 'button-sm',
			cssClass: 'type-button-sm',
			size: '14.4px',
			weight: '700',
			lh: '1',
			text: 'UNDUH BROSUR'
		},
		{
			token: 'link-md',
			cssClass: 'type-link-md',
			size: '15px',
			weight: '400',
			lh: '1.5',
			text: 'Pelajari sertifikasi TKDN kementerian perindustrian'
		},
		{
			token: 'caption-md',
			cssClass: 'type-caption-md',
			size: '14px',
			weight: '700',
			lh: '1.43',
			text: 'SPESIFIKASI ELEKTRIKAL'
		},
		{
			token: 'caption-sm',
			cssClass: 'type-caption-sm',
			size: '12px',
			weight: '400',
			lh: '1.25',
			text: 'Dihitung berdasarkan rata-rata insolasi surya 4,5 jam per hari.'
		},
		{
			token: 'caption-xs',
			cssClass: 'type-caption-xs',
			size: '11px',
			weight: '700',
			lh: '1',
			text: 'BATERAI LIFEPO4'
		},
		{
			token: 'utility-xs',
			cssClass: 'type-utility-xs',
			size: '10px',
			weight: '700',
			lh: '1.5',
			text: 'HAK CIPTA 2026 PT. INDOGREEN TECHNOLOGY AND MANAGEMENT'
		}
	];
</script>

<svelte:head>
	<title>INDOGREEN Styleguide — Token Desain & Komponen UI</title>
</svelte:head>

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

			<div class="flex flex-wrap items-center gap-md pt-sm">
				<Button variant="primary" size="lg">
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

<!-- Buttons & Affordances Section (Canvas Light) -->
<Section tone="light" id="buttons">
	<Container>
		<div class="flex flex-col gap-xl">
			<div>
				<div class="flex items-center gap-xs">
					<CornerSquare position="inline" size="sm" class="mr-xs" />
					<span class="type-caption-md font-bold text-primary uppercase">
						03. TOMBOL & AFFORDANCE
					</span>
				</div>
				<h2 class="type-display-lg mt-xs font-bold text-ink">Button Variants & Touch Targets</h2>
				<p class="type-body-md mt-xs text-mute">
					Radius 2px (rounded-sm), tinggi minimal 44px WCAG AA, teks tombol hijau wajib hitam
					(#000000). Tanpa pill button.
				</p>
			</div>

			<!-- Buttons on Light Surface -->
			<div class="flex flex-col gap-md rounded-sm border border-hairline bg-canvas p-xl">
				<h3 class="type-heading-md font-bold text-ink">Kanvas Terang (Canvas Surface)</h3>
				<div class="flex flex-wrap items-center gap-md">
					<Button variant="primary" size="lg">Primary (lg)</Button>
					<Button variant="primary" size="md">Primary (md)</Button>
					<Button variant="primary" size="sm">Primary (sm)</Button>
					<Button variant="outline" size="md">Outline (md)</Button>
					<Button variant="ghost-link">
						<span>Ghost Link</span>
						<Icon name="arrow-right" size={16} class="ml-xs" />
					</Button>
					<Button variant="disabled" size="md">Disabled</Button>
				</div>
			</div>

			<!-- Buttons on Dark Surface -->
			<div class="flex flex-col gap-md rounded-sm bg-surface-dark p-xl text-on-dark">
				<div class="flex items-center justify-between">
					<h3 class="type-heading-md font-bold text-on-dark">Kanvas Gelap (Surface Dark)</h3>
					<span class="type-caption-sm text-accent-yellow">Hero / Footer / CTA Strips</span>
				</div>
				<div class="flex flex-wrap items-center gap-md">
					<Button variant="primary" size="lg">Hero Primary CTA</Button>
					<Button variant="outline-on-dark" size="lg">Outline On Dark</Button>
					<Button variant="primary" size="md">Primary (md)</Button>
					<Button variant="outline-on-dark" size="md">Outline On Dark (md)</Button>
					<Button variant="ghost-link" class="text-accent-yellow">
						<span>Learn More</span>
						<Icon name="arrow-right" size={16} class="ml-xs" />
					</Button>
				</div>
			</div>
		</div>
	</Container>
</Section>

<!-- Form Components Section -->
<Section tone="soft" id="forms">
	<Container>
		<div class="flex flex-col gap-xl">
			<div>
				<div class="flex items-center gap-xs">
					<CornerSquare position="inline" size="sm" class="mr-xs" />
					<span class="type-caption-md font-bold text-primary uppercase">
						04. KOMPONEN FORMULIR
					</span>
				</div>
				<h2 class="type-display-lg mt-xs font-bold text-ink">
					Input Teks, Textarea & Select Dropdown
				</h2>
				<p class="type-body-md mt-xs text-mute">
					Focus state: border 2px solid #00b100 + outline 2px offset. Validasi error terikat
					aria-describedby dan role="alert".
				</p>
			</div>

			<div
				class="grid grid-cols-1 gap-xl rounded-sm border border-hairline bg-canvas p-xl tablet:grid-cols-2"
			>
				<!-- Standard TextInput -->
				<TextInput
					label="Nama Produk atau Komponen"
					bind:value={textValue}
					hint="Masukkan seri lampu atau spesifikasi daya (contoh: 60W)"
					required={true}
				/>

				<!-- Error TextInput -->
				<TextInput
					label="Alamat Email Kontak"
					bind:value={errorTextValue}
					error="Format email tidak valid. Masukkan alamat email perusahaan yang benar."
					required={true}
				/>

				<!-- Select Dropdown -->
				<Select
					label="Kategori Sistem EBT"
					bind:value={selectValue}
					options={selectOptions}
					hint="Pilih jenis paket kelistrikan surya yang diinginkan"
					required={true}
				/>

				<!-- Disabled TextInput -->
				<TextInput
					label="Status Otorisasi Tender"
					value="TERVERIFIKASI SISTEM"
					disabled={true}
					hint="Field ini dikunci otomatis oleh sistem pengadaan"
				/>

				<!-- Full width Textarea -->
				<div class="col-span-1 tablet:col-span-2">
					<Textarea
						label="Catatan Teknis Rekayasa / Deskripsi Proyek"
						bind:value={textareaValue}
						hint="Minimal tinggi 120px dengan scroll otomatis"
						required={true}
					/>
				</div>
			</div>
		</div>
	</Container>
</Section>

<!-- Badges, PillTabs & Decorative Section -->
<Section tone="light" id="decorative">
	<Container>
		<div class="flex flex-col gap-xl">
			<div>
				<div class="flex items-center gap-xs">
					<CornerSquare position="inline" size="sm" class="mr-xs" />
					<span class="type-caption-md font-bold text-primary uppercase">
						05. BADGE, TABS & ORNAMEN
					</span>
				</div>
				<h2 class="type-display-lg mt-xs font-bold text-ink">Badge Tag, PillTabs & CornerSquare</h2>
				<p class="type-body-md mt-xs text-mute">
					PillTabs menggunakan rounded-sm (2px) bukan pill/rounded-full. CornerSquare 12x12px warna
					hijau brand #00b100.
				</p>
			</div>

			<div class="flex flex-col gap-lg rounded-sm border border-hairline bg-canvas p-xl">
				<div class="flex flex-col gap-sm">
					<span class="type-caption-md text-mute uppercase">Varian Badge (badge-tag)</span>
					<div class="flex flex-wrap items-center gap-sm">
						<Badge variant="default">WHITE PAPER</Badge>
						<Badge variant="primary">SOLAR PV</Badge>
						<Badge variant="dark">OFF-GRID</Badge>
						<Badge variant="outline">STUDI KASUS</Badge>
						<Badge variant="default">KATALOG 2026</Badge>
					</div>
				</div>

				<div class="flex flex-col gap-sm border-t border-hairline pt-md">
					<span class="type-caption-md text-mute uppercase">Segmented Tabs (pill-tab)</span>
					<PillTabs tabs={tabList} bind:activeTab={sampleTab} />
					<p class="type-caption-sm mt-xs text-mute">
						Tab aktif saat ini: <strong class="text-ink">{sampleTab}</strong>
					</p>
				</div>

				<div class="flex flex-col gap-sm border-t border-hairline pt-md">
					<span class="type-caption-md text-mute uppercase">Corner Square (Signature Motif)</span>
					<div class="flex items-center gap-xl">
						<div class="relative h-20 w-32 border border-hairline bg-surface-soft p-sm">
							<CornerSquare position="top-left" size="sm" />
							<span class="type-caption-xs absolute bottom-2 left-2 text-mute">Top-Left 12x12</span>
						</div>
						<div class="relative h-20 w-32 border border-hairline bg-surface-soft p-sm">
							<CornerSquare position="bottom-right" size="sm" />
							<span class="type-caption-xs absolute top-2 left-2 text-mute">
								Bottom-Right 12x12
							</span>
						</div>
						<div class="relative h-20 w-32 bg-surface-dark p-sm">
							<CornerSquare position="top-left" size="lg" />
							<span class="type-caption-xs absolute bottom-2 left-2 text-on-dark-mute">
								Hero Square 16x16
							</span>
						</div>
					</div>
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
						title="Helios Series 120W (TIO)"
						category="PJU TWO-IN-ONE"
						description="Sistem penerangan jalan umum terpisah modul dan lampu untuk efisiensi penangkapan radiasi optimal."
						href="#pju-helios"
						ctaText="Lihat Detail Produk"
					/>
					<ProductCard
						title="Jupiter Series 80W (AIO)"
						category="PJU ALL-IN-ONE"
						description="Desain ringkas terintegrasi panel surya monokristalin, baterai LiFePO4, dan kontroler cerdas MPPT."
						href="#pju-jupiter"
						ctaText="Lihat Detail Produk"
					/>
					<ProductCard
						title="Mars Series 60W (AIO)"
						category="PJU ALL-IN-ONE"
						description="Penerangan hemat daya untuk jalan perumahan, pedesaan, dan area operasional industri."
						href="#pju-mars"
						ctaText="Lihat Detail Produk"
					/>
				</div>
			</div>

			<!-- Feature Cards Grid -->
			<div class="mt-lg flex flex-col gap-md">
				<h3 class="type-heading-md font-bold text-ink">Feature Cards (3-Up Grid)</h3>
				<div class="grid grid-cols-1 gap-xl tablet:grid-cols-3">
					<FeatureCard
						icon="sun"
						title="Fotovoltaik Surya Efisiensi Tinggi"
						description="Modul PV Monokristalin Tier 1 dengan efisiensi konversi sel > 21,5% tahan kondisi cuaca ekstrem tropis."
						hasCornerSquare={true}
					/>
					<FeatureCard
						icon="battery-charging"
						title="Penyimpanan Baterai LiFePO4"
						description="Siklus hidup lebih dari 3.000 cycle dengan sistem proteksi Battery Management System (BMS) ganda."
					/>
					<FeatureCard
						icon="shield-check"
						title="Layanan Purna Jual Resmi"
						description="Jaminan ketersediaan suku cadang, pemeliharaan preventif, dan dukungan tim sales engineering bersertifikat."
					/>
				</div>
			</div>

			<!-- Resource Cards Grid -->
			<div class="mt-lg flex flex-col gap-md">
				<h3 class="type-heading-md font-bold text-ink">Resource Cards (Dokumen & Panduan)</h3>
				<div class="grid grid-cols-1 gap-xl tablet:grid-cols-2 desktop:grid-cols-3">
					<ResourceCard
						typeLabel="BROSUR TEKNIS"
						title="Katalog Lengkap PJU Tenaga Surya 2026"
						description="Spesifikasi teknis mendalam seri Helios, Jupiter, dan Mars beserta kurva fotometrik distribusi cahaya."
						href="#katalog-2026"
						ctaText="Unduh Dokumen PDF"
					/>
					<ResourceCard
						typeLabel="STUDI KASUS"
						title="Elektrifikasi Mandiri Wilayah 3T Papua"
						description="Implementasi 250 unit Solar Home System (SHS) untuk penerangan pemukiman terpencil secara mandiri."
						href="#studi-kasus"
						ctaText="Baca Laporan Lapangan"
					/>
					<ResourceCard
						typeLabel="PANDUAN TEKNIS"
						title="Kalkulasi Kebutuhan Beban PLTS Atap"
						description="Metodologi perancangan kapasitas inverter, sudut kemiringan PV, dan proteksi proteksi grid terhubung."
						href="#panduan-beban"
						ctaText="Pelajari Panduan"
					/>
				</div>
			</div>

			<!-- Callout Stats Grid -->
			<div class="mt-lg flex flex-col gap-md">
				<h3 class="type-heading-md font-bold text-ink">Callout Stats (Metrik Pencapaian Bisnis)</h3>
				<div class="grid grid-cols-1 gap-xl tablet:grid-cols-2 desktop:grid-cols-4">
					<CalloutStat
						label="KAPASITAS TERPASANG"
						value="2.500"
						unit="kWp"
						caption="Total kapasitas pembangkit surya terpasang di seluruh Indonesia."
					/>
					<CalloutStat
						label="TITIK PENERANGAN"
						value="15.000+"
						unit="Unit"
						caption="Lampu PJU tenaga surya beroperasi menerangi jalan nusantara."
					/>
					<CalloutStat
						label="TITIK ELEKTRIFIKASI"
						value="120+"
						unit="Lokasi"
						caption="Desa dan pulau terluar terlayani listrik tenaga surya mandiri."
					/>
					<CalloutStat
						label="REDUKSI KARBON"
						value="3.200"
						unit="Ton"
						caption="Estimasi pengurangan emisi CO2 per tahun dari sistem terpasang."
					/>
				</div>
			</div>
		</div>
	</Container>
</Section>

<!-- Footer Section (Surface Dark) -->
<Section tone="dark" class="border-t border-hairline-strong">
	<Container>
		<div class="flex flex-col items-center justify-between gap-md py-lg tablet:flex-row">
			<div class="flex items-center gap-sm">
				<CornerSquare position="inline" size="sm" />
				<span class="type-body-strong font-bold text-on-dark">
					PT. Indogreen Technology And Management
				</span>
			</div>
			<span class="type-utility-xs text-mute uppercase">
				VERIFIKASI VISUAL STYLEGUIDE · FASE 5 FRONTEND
			</span>
		</div>
	</Container>
</Section>
