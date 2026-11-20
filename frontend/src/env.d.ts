declare module '$env/dynamic/private' {
  export const env: Record<string, string | undefined>;
}

declare module '$app/env/private' {
  export const env: Record<string, string | undefined>;
}
