<footer class="d-flex justify-content-between py-4 my-4 bg-light">
    <div class="px-2 px-md-4">
        <p>&copy; {{ date('Y') }} {{ __('Eugene Ilchenko') }}</p>
    </div>
    <div class="px-2 px-md-4 social-links">
        <a href="{{ config('app.social.telegram') }}" target="_blank" class="me-2">
            <i class="fa-brands fa-telegram fa-2xl"></i>
        </a>
        <a href="{{ config('app.social.github') }}" target="_blank" class="me-2">
            <i class="fa-brands fa-github-square fa-2xl"></i>
        </a>
        <a href="{{ config('app.social.instagram') }}" target="_blank" class="me-2">
            <i class="fa-brands fa-instagram-square fa-2xl"></i>
        </a>
        <a href="{{ config('app.social.vk') }}" target="_blank" class="me-2">
            <i class="fa-brands fa-vk fa-2xl"></i>
        </a>
    </div>
</footer>
