{{--
Anti-spam fields — include inside any public <form>.
    1. Honeypot: invisible field bots auto-fill (humans never see it)
    2. Timestamp: encoded token to reject instant form submissions
    --}}

    {{-- Honeypot: positioned off-screen, invisible to humans --}}
    <div style="position: absolute; left: -9999px; top: -9999px;" aria-hidden="true" tabindex="-1">
        <label for="website_url">Sitio web</label>
        <input type="text" name="website_url" id="website_url" value="" autocomplete="off" tabindex="-1">
    </div>

    {{-- Timestamp token --}}
    <input type="hidden" name="_form_token" value="{{ \App\Http\Middleware\SpamProtection::generateToken() }}">