function copyToClipboard(text, btnId) {
            navigator.clipboard.writeText(text).then(() => {
                const btn = document.getElementById(btnId);
                const icon = btn.querySelector('svg');
                
                // Success State
                btn.classList.add('bg-green-500/20', 'text-green-400', 'border-green-500/50');
                btn.classList.remove('text-neutral-400');
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>';
                
                // Revert
                setTimeout(() => {
                    btn.classList.remove('bg-green-500/20', 'text-green-400', 'border-green-500/50');
                    btn.classList.add('text-neutral-400');
                    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>';
                }, 2000);
            });
        }