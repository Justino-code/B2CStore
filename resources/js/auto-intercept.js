// resources/js/auto-intercept.js
document.addEventListener('DOMContentLoaded', function() {
    // Interceptar automaticamente links com data-ajax-navigate
    document.addEventListener('click', function(e) {
        const link = e.target.closest('[data-ajax-navigate]');
        if (link && typeof Livewire !== 'undefined') {
            e.preventDefault();
            const url = link.getAttribute('data-url') || link.getAttribute('href');
            Livewire.navigate(url);
        }
    }, true);
});