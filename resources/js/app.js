
// MightyWeb Admin Panel JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Mobile sidebar toggle
    const sidebarToggle = document.querySelector('[data-sidebar-toggle]');
    const sidebar = document.querySelector('[data-sidebar]');
    const sidebarOverlay = document.querySelector('[data-sidebar-overlay]');

    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('translate-x-0');
            sidebar.classList.toggle('-translate-x-full');
            if (sidebarOverlay) {
                sidebarOverlay.classList.toggle('hidden');
            }
        });
    }

    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            sidebar.classList.remove('translate-x-0');
            sidebarOverlay.classList.add('hidden');
        });
    }

    // Auto-hide flash messages after 5 seconds
    const flashMessages = document.querySelectorAll('[data-flash-message]');
    flashMessages.forEach(message => {
        setTimeout(() => {
            message.style.transition = 'opacity 0.5s ease-out';
            message.style.opacity = '0';
            setTimeout(() => message.remove(), 500);
        }, 5000);
    });

    // Confirm delete actions
    const deleteButtons = document.querySelectorAll('[data-confirm-delete]');
    deleteButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            if (!confirm('Are you sure you want to delete this item? This action cannot be undone.')) {
                e.preventDefault();
            }
        });
    });

    // Image preview on file input
    const imageInputs = document.querySelectorAll('input[type="file"][accept*="image"]');
    imageInputs.forEach(input => {
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const preview = document.querySelector(`[data-preview-for="${input.id}"]`);
                    if (preview) {
                        preview.src = event.target.result;
                        preview.classList.remove('hidden');
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    });

    // Dark mode toggle
    const darkModeToggle = document.querySelector('[data-dark-mode-toggle]');
    if (darkModeToggle) {
        darkModeToggle.addEventListener('click', () => {
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('darkMode', document.documentElement.classList.contains('dark'));
        });

        // Load dark mode preference
        if (localStorage.getItem('darkMode') === 'true') {
            document.documentElement.classList.add('dark');
        }
    }

    // Sortable tables
    const sortableHeaders = document.querySelectorAll('[data-sortable]');
    sortableHeaders.forEach(header => {
        header.style.cursor = 'pointer';
        header.addEventListener('click', function() {
            const column = this.dataset.sortable;
            const currentUrl = new URL(window.location);
            const currentSort = currentUrl.searchParams.get('sort');
            const currentDirection = currentUrl.searchParams.get('direction');

            let newDirection = 'asc';
            if (currentSort === column && currentDirection === 'asc') {
                newDirection = 'desc';
            }

            currentUrl.searchParams.set('sort', column);
            currentUrl.searchParams.set('direction', newDirection);
            window.location.href = currentUrl.toString();
        });
    });

    // Search input debounce
    const searchInputs = document.querySelectorAll('[data-search]');
    searchInputs.forEach(input => {
        let timeout;
        input.addEventListener('input', function() {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                this.form.submit();
            }, 500);
        });
    });

    // Copy to clipboard
    const copyButtons = document.querySelectorAll('[data-copy]');
    copyButtons.forEach(button => {
        button.addEventListener('click', function() {
            const text = this.dataset.copy;
            navigator.clipboard.writeText(text).then(() => {
                const originalText = this.textContent;
                this.textContent = 'Copied!';
                setTimeout(() => {
                    this.textContent = originalText;
                }, 2000);
            });
        });
    });

    // Toggle password visibility
    const passwordToggles = document.querySelectorAll('[data-toggle-password]');
    passwordToggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const targetId = this.dataset.togglePassword;
            const target = document.getElementById(targetId);
            if (target) {
                const type = target.type === 'password' ? 'text' : 'password';
                target.type = type;
                this.querySelector('svg').classList.toggle('hidden');
            }
        });
    });
});

// Export utilities for Livewire components
window.MightyWeb = {
    confirmDelete: function(message = 'Are you sure you want to delete this item?') {
        return confirm(message);
    },
    
    showNotification: function(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 px-6 py-4 rounded-lg shadow-lg z-50 animate-slide-in-right ${
            type === 'success' ? 'bg-green-500' : 
            type === 'error' ? 'bg-red-500' : 
            type === 'warning' ? 'bg-yellow-500' : 
            'bg-blue-500'
        } text-white`;
        notification.textContent = message;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.transition = 'opacity 0.5s ease-out';
            notification.style.opacity = '0';
            setTimeout(() => notification.remove(), 500);
        }, 3000);
    },
    
    scrollToTop: function() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
};
