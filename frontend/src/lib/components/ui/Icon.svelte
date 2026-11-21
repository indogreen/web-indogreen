<script lang="ts">
  import type { IconName } from './types.js';
  import {
    ArrowRight,
    ChevronRight,
    ChevronDown,
    ChevronUp,
    ChevronLeft,
    Search,
    Menu,
    X,
    Sun,
    Moon,
    Battery,
    BatteryCharging,
    Zap,
    Check,
    Phone,
    Mail,
    Clock,
    MapPin,
    FileText,
    Download,
    Shield,
    ShieldCheck,
    Layers,
    Wrench,
    Settings,
    Info,
    AlertCircle,
    AlertTriangle,
    CheckCircle,
    ExternalLink,
    Share2,
    Globe,
    Calendar,
    Building,
    Building2,
    HelpCircle,
    Play,
    Pause,
    Home,
    Cpu,
    Truck,
    PackageOpen
  } from '@lucide/svelte';

  interface Props {
    name: IconName;
    size?: number | string;
    strokeWidth?: number | string;
    class?: string;
    ariaLabel?: string;
    ariaHidden?: boolean;
  }

  let {
    name,
    size = 20,
    strokeWidth = 2,
    class: className = '',
    ariaLabel,
    ariaHidden = !ariaLabel
  }: Props = $props();

  // Explicit mapping to keep tree-shaking intact and predictable
  const iconMap = {
    'arrow-right': ArrowRight,
    'chevron-right': ChevronRight,
    'chevron-down': ChevronDown,
    'chevron-up': ChevronUp,
    'chevron-left': ChevronLeft,
    search: Search,
    menu: Menu,
    x: X,
    sun: Sun,
    moon: Moon,
    battery: Battery,
    'battery-charging': BatteryCharging,
    zap: Zap,
    check: Check,
    phone: Phone,
    mail: Mail,
    clock: Clock,
    'map-pin': MapPin,
    'file-text': FileText,
    download: Download,
    shield: Shield,
    'shield-check': ShieldCheck,
    layers: Layers,
    wrench: Wrench,
    settings: Settings,
    info: Info,
    'alert-circle': AlertCircle,
    'alert-triangle': AlertTriangle,
    'check-circle': CheckCircle,
    'external-link': ExternalLink,
    'share-2': Share2,
    globe: Globe,
    calendar: Calendar,
    building: Building,
    'building-2': Building2,
    'help-circle': HelpCircle,
    play: Play,
    pause: Pause,
    home: Home,
    cpu: Cpu,
    truck: Truck,
    'package-open': PackageOpen
  } as const;

  const SelectedIcon = $derived(iconMap[name] ?? HelpCircle);
</script>

<SelectedIcon
  {size}
  {strokeWidth}
  class={className}
  aria-label={ariaLabel}
  aria-hidden={ariaHidden ? 'true' : undefined}
  role={ariaLabel ? 'img' : undefined}
/>
