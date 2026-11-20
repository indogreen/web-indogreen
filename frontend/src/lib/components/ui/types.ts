export type ButtonVariant = 'primary' | 'outline' | 'outline-on-dark' | 'ghost-link' | 'disabled';
export type ButtonSize = 'lg' | 'md' | 'sm';

export type BadgeVariant = 'default' | 'primary' | 'dark' | 'outline';

export type CornerSquarePosition =
  'top-left' | 'bottom-right' | 'top-right' | 'bottom-left' | 'inline';
export type CornerSquareSize = 'sm' | 'lg';

export type SectionTone = 'light' | 'dark' | 'soft';

export interface SelectOption {
  value: string | number;
  label: string;
  disabled?: boolean;
}

export interface TabItem {
  id: string;
  label: string;
  disabled?: boolean;
}

export type IconName =
  | 'arrow-right'
  | 'chevron-right'
  | 'chevron-down'
  | 'chevron-up'
  | 'chevron-left'
  | 'search'
  | 'menu'
  | 'x'
  | 'sun'
  | 'moon'
  | 'battery'
  | 'battery-charging'
  | 'zap'
  | 'check'
  | 'phone'
  | 'mail'
  | 'clock'
  | 'map-pin'
  | 'file-text'
  | 'download'
  | 'shield'
  | 'shield-check'
  | 'layers'
  | 'wrench'
  | 'settings'
  | 'info'
  | 'alert-circle'
  | 'alert-triangle'
  | 'check-circle'
  | 'external-link'
  | 'share-2'
  | 'globe'
  | 'calendar'
  | 'building'
  | 'building-2'
  | 'help-circle';
