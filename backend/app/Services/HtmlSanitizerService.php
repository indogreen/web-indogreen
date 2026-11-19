<?php

namespace App\Services;

class HtmlSanitizerService
{
    /**
     * Allowed HTML tags for rich content.
     */
    protected const ALLOWED_TAGS = '<p><br><b><strong><i><em><u><s><h1><h2><h3><h4><h5><h6><ul><ol><li><blockquote><code><pre><a><img><table><thead><tbody><tr><th><td><hr>';

    /**
     * Sanitize HTML content by stripping disallowed tags and dangerous attributes.
     */
    public static function sanitize(?string $html): ?string
    {
        if (empty($html)) {
            return $html;
        }

        // 1. Remove entire <script> and <style> blocks including their contents
        $clean = (string) preg_replace('/<(script|style)\b[^>]*>(.*?)<\/\1>/is', '', $html);

        // 2. Strip disallowed tags
        $clean = strip_tags($clean, self::ALLOWED_TAGS);

        // 2. Remove dangerous attributes (on*, javascript:, data:)
        $clean = (string) preg_replace('/<([a-z][a-z0-9]*)[^>]*?(\bon\w+=[^>]+)/i', '<$1', $clean);
        $clean = (string) preg_replace('/\s*on\w+\s*=\s*(["\']).*?\1/i', '', $clean);
        $clean = (string) preg_replace('/\s*on\w+\s*=\s*[^>\s]+/i', '', $clean);

        // 3. Prevent javascript: in href or src
        $clean = (string) preg_replace('/(href|src)\s*=\s*(["\'])\s*javascript:[^"\']*\2/i', '$1="#"', $clean);

        return trim($clean);
    }
}
