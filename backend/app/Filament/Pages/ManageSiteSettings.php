<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

/**
 * @property-read Schema $form
 */
class ManageSiteSettings extends Page
{
    protected static ?string $title = 'Pengaturan Situs';

    protected static ?string $navigationLabel = 'Pengaturan Situs';

    protected static string|\UnitEnum|null $navigationGroup = 'Akses & Pengaturan';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static ?int $navigationSort = 3;

    /**
     * @var array<string, mixed>|null
     */
    public ?array $data = [];

    public static function canAccess(): bool
    {
        return auth()->user()?->can('settings.manage') ?? false;
    }

    public function mount(): void
    {
        $settings = SiteSetting::first();

        if (! $settings) {
            $settings = SiteSetting::create([
                'company_name' => 'PT. Indogreen Technology And Management',
                'tagline' => 'Solusi Terpercaya Energi Baru dan Terbarukan di Indonesia',
                'phone' => '+62 21 0000 0000',
                'email' => 'info@indogreen.id',
                'whatsapp' => '+62 812 0000 0000',
            ]);
        }

        $this->form->fill($settings->toArray());
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                Form::make([EmbeddedSchema::make('form')])
                    ->id('settings-form')
                    ->livewireSubmitHandler('save')
                    ->footer([
                        Actions::make([
                            Action::make('save')
                                ->label('Simpan Pengaturan')
                                ->submit('settings-form'),
                        ]),
                    ]),
            ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Section::make('Identitas Perusahaan')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('company_name')
                                    ->label('Nama Perusahaan')
                                    ->required()
                                    ->maxLength(255),

                                TextInput::make('tagline')
                                    ->label('Tagline')
                                    ->maxLength(255),
                            ]),
                    ]),

                Section::make('Kontak Resmi')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('phone')
                                    ->label('Telepon Kantor')
                                    ->tel()
                                    ->maxLength(50),

                                TextInput::make('email')
                                    ->label('Email Perusahaan')
                                    ->email()
                                    ->maxLength(255),

                                TextInput::make('whatsapp')
                                    ->label('Nomor WhatsApp')
                                    ->maxLength(50),
                            ]),
                    ]),

                Section::make('Alamat Kantor')
                    ->schema([
                        Textarea::make('head_office_address')
                            ->label('Alamat Kantor Utama')
                            ->rows(2),

                        Textarea::make('representative_office_address')
                            ->label('Alamat Kantor Perwakilan')
                            ->rows(2),
                    ]),

                Section::make('Media Sosial')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('facebook_url')
                                    ->label('Facebook URL')
                                    ->url()
                                    ->maxLength(255),

                                TextInput::make('instagram_url')
                                    ->label('Instagram URL')
                                    ->url()
                                    ->maxLength(255),

                                TextInput::make('youtube_url')
                                    ->label('YouTube URL')
                                    ->url()
                                    ->maxLength(255),
                            ]),
                    ]),
            ]);
    }

    public function save(): void
    {
        $state = $this->form->getState();

        $settings = SiteSetting::first();

        if ($settings) {
            $settings->update($state);
        } else {
            SiteSetting::create($state);
        }

        Notification::make()
            ->title('Pengaturan situs berhasil disimpan.')
            ->success()
            ->send();
    }
}
