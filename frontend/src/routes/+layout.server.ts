import type { LayoutServerLoad } from './$types';
import { api } from '$lib/server/api';

export const load: LayoutServerLoad = async ({ fetch }) => {
  const settings = await api.getSettings(fetch);

  return {
    settings
  };
};
