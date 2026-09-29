{{--
Anti-spam fields — include inside any public <form>.
    1. Honeypot 1: website_url (off-screen)
    2. Honeypot 2: business_fax (zero-dimension, non-interactive)
    3. Timestamp: HMAC-signed token to reject instant submissions & replay attacks
--}}

{{-- Honeypot 1: positioned off-screen, invisible to humans --}}
<div style="position: absolute; left: -9999px; top: -9999px;" aria-hidden="true" tabindex="-1">
    <label for="website_url">Sitio web</label>
    <input type="text" name="website_url" id="website_url" value="" autocomplete="off" tabindex="-1">
</div>

{{-- Honeypot 2: hidden with modern CSS properties to catch bots avoiding off-screen CSS --}}
<div style="opacity: 0; position: absolute; top: 0; left: 0; height: 0; width: 0; z-index: -1; pointer-events: none;" aria-hidden="true" tabindex="-1">
    <label for="business_fax">Fax</label>
    <input type="text" name="business_fax" id="business_fax" value="" autocomplete="off" tabindex="-1">
</div>

{{-- Timestamp token signed with HMAC --}}
<input type="hidden" name="_form_token" value="{{ \App\Http\Middleware\SpamProtection::generateToken() }}">