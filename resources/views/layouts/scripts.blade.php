{{-- MightyWeb Package Scripts - Footer --}}

{{-- Package JavaScript --}}
<script src="{{ asset('vendor/mightyweb/build/assets/app-Ce2q4hT9.js') }}" defer></script>
{{-- Additional Package Scripts --}}
<script>
    // Auto-dismiss success messages after 3 seconds
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            const successAlerts = document.querySelectorAll('[x-data*="show: true"]');
            successAlerts.forEach(function(alert) {
                if (alert.__x) {
                    alert.__x.$data.show = false;
                }
            });
        }, 3000);
    });
</script>
