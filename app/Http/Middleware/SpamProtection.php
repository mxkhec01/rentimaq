<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

/**
 * Multi-layer anti-spam protection for public forms.
 *
 * Layer 1: Honeypot — hidden field that must remain EMPTY (bots auto-fill it)
 * Layer 2: Timestamp — form must take at least N seconds to fill (bots are instant)
 * Layer 3: Rate Limiting — handled at route level via Laravel throttle middleware
 */
class SpamProtection
{
    /** Minimum seconds a human needs to fill a form */
    private const MIN_FORM_TIME_SECONDS = 3;

    /** Honeypot field name (looks like a real field to bots) */
    public const HONEYPOT_FIELD = 'website_url';

    /** Timestamp field name */
    public const TIMESTAMP_FIELD = '_form_token';

    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->isMethod('POST')) {
            return $next($request);
        }

        // Layer 1: Honeypot check — must be empty
        if ($request->filled(self::HONEYPOT_FIELD)) {
            Log::warning('Spam blocked (honeypot)', [
                'ip' => $request->ip(),
                'uri' => $request->path(),
                'honeypot_value' => substr($request->input(self::HONEYPOT_FIELD), 0, 50),
            ]);

            return $this->spamResponse($request);
        }

        // Layer 2: Timestamp validation — form must take >N seconds
        $formToken = $request->input(self::TIMESTAMP_FIELD);

        if ($formToken) {
            $timestamp = $this->decodeTimestamp($formToken);

            if ($timestamp !== null) {
                $elapsed = time() - $timestamp;

                if ($elapsed < self::MIN_FORM_TIME_SECONDS) {
                    Log::warning('Spam blocked (too fast)', [
                        'ip' => $request->ip(),
                        'uri' => $request->path(),
                        'elapsed_seconds' => $elapsed,
                    ]);

                    return $this->spamResponse($request);
                }
            }
        }

        // Remove anti-spam fields before passing to controller
        $request->request->remove(self::HONEYPOT_FIELD);
        $request->request->remove(self::TIMESTAMP_FIELD);

        return $next($request);
    }

    /**
     * Encode a timestamp into an obfuscated token (not security-critical, just obscure).
     */
    public static function generateToken(): string
    {
        return base64_encode(time() . '|' . mt_rand(1000, 9999));
    }

    /**
     * Decode the obfuscated timestamp token.
     */
    private function decodeTimestamp(string $token): ?int
    {
        $decoded = base64_decode($token, true);

        if ($decoded === false) {
            return null;
        }

        $parts = explode('|', $decoded);

        if (count($parts) !== 2 || !is_numeric($parts[0])) {
            return null;
        }

        return (int) $parts[0];
    }

    /**
     * Return a fake "success" response to not alert the bot that it was caught.
     */
    private function spamResponse(Request $request): Response
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Mensaje enviado correctamente.']);
        }

        return back()->with('success', 'Mensaje enviado correctamente.');
    }
}
