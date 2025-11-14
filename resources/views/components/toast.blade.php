@php
    $toastTypes = [
        'success' => ['label' => config('app.name'), 'gradient' => 'linear-gradient(to right,#32bb71, #2a9d8f)'],
        'error' => ['label' => config('app.name'), 'gradient' => 'linear-gradient(to right,#f6743e, #d42525)'],
        'info' => ['label' => config('app.name'), 'gradient' => 'linear-gradient(to right,#2d82b2, #329abb)'],
    ];
@endphp

@foreach ($toastTypes as $type => $style)
    @if (session($type))
        <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999">
            <div class="bs-toast toast fade  bg-dark" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header text-white" style="background: {{ $style['gradient'] }};">
                    <i class="bx bx-bell me-2"></i>
                    <div class="me-auto fw-semibold">{{ $style['label'] }}</div>
                    <small>{{ now()->setTimezone('Asia/Jakarta')->format('H:i') }} WIB</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body text-white pt-2" style="background: {{ $style['gradient'] }};">
                    {{ session($type) }}
                </div>
            </div>
        </div>
    @endif
@endforeach
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const toastElList = document.querySelectorAll('.toast');
        toastElList.forEach(function(toastEl) {
            const toast = new bootstrap.Toast(toastEl, {
                delay: 3000
            });
            toast.show();

            // Hilang otomatis setelah 3 detik
            setTimeout(() => {
                toast.hide();
            }, 3000);
        });
    });
</script>

<style>
    .toast {
        animation: slideIn 0.4s ease-out;
    }

    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }

        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
</style>
