<style>
    :root {
        --green-main: #00c853;
        --green-light: #03e78b;
        --shadow-soft: 0 6px 18px rgba(0, 0, 0, 0.15);
    }

    .fixed-contact-wrapper {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 99999;
    }

    .toggle-button {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--green-main), var(--green-light));
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        cursor: pointer;
        box-shadow: 0 10px 25px rgba(0, 200, 83, 0.4);
        transition: 0.25s ease;
        position: relative;
    }

    .toggle-button:hover {
        transform: scale(1.08);
    }

    .toggle-button::before {
        content: '';
        position: absolute;
        inset: -5px;
        border-radius: 50%;
        background: rgba(3, 231, 139, 0.3);
        animation: pulse 1.6s infinite;
        z-index: -1;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
            opacity: 1;
        }

        70% {
            transform: scale(1.8);
            opacity: 0;
        }

        100% {
            opacity: 0;
        }
    }

    .fixed-contact-buttons {
        position: absolute;
        bottom: 70px;
        right: 0;
        display: flex;
        flex-direction: column;
        gap: 12px;
        opacity: 0;
        transform: translateY(15px);
        pointer-events: none;
        transition: 0.3s ease;
    }

    .fixed-contact-buttons.show.single-mode {
        bottom: 25px;
    }

    .fixed-contact-buttons.show {
        opacity: 1;
        transform: translateY(0);
        pointer-events: auto;
    }

    .social-outside {
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        justify-content: flex-end;
    }

    .text-card {
        background: #fff;
        padding: 6px 14px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 14px;
        color: #4f5866;
        box-shadow: var(--shadow-soft);
        transition: transform 0.3s;
        white-space: nowrap;
    }

    .icon-circle {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        box-shadow: var(--shadow-soft);
        transition: 0.3s ease;
    }

    .social-outside:hover .text-card {
        transform: translateX(-4px);
    }

    .social-outside:hover .icon-circle {
        transform: scale(1.1);
    }

    .call .icon-circle {
        background: linear-gradient(135deg, var(--green-main), var(--green-light));
    }

    .whatsapp .icon-circle {
        background: #25d366;
    }

    .messenger .icon-circle {
        background: #1877f2;
    }

    @media (max-width: 480px) {
        .fixed-contact-wrapper {
            bottom: 75px;
            right: 20px;
        }

        .fixed-contact-buttons.show.single-mode {
            bottom: 0px;
            right: 10px;
        }
    }

    .fixed-contact-buttons.single-mode {
        opacity: 1;
        transform: none;
        pointer-events: auto;
    }

    .single-mode .social-outside {
        all: unset;
        width: 52px;
        height: 52px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        position: relative;
    }

    .single-mode .text-card {
        display: none !important;
    }

    .single-mode .icon-circle {
        width: 100%;
        height: 100%;
        background: transparent;
        box-shadow: none;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: #fff;
    }

    .single-mode .social-outside::before {
        content: '';
        position: absolute;
        inset: -5px;
        border-radius: 50%;
        animation: pulse 1.6s infinite;
        z-index: -1;
    }

    .single-mode.whatsapp {
        background: #25d366;
    }

    .single-mode.whatsapp::before {
        background: rgba(37, 211, 102, 0.3);
    }

    .single-mode.call {
        background: linear-gradient(135deg, #00c853, #03e78b);
    }

    .single-mode.call::before {
        background: rgba(3, 231, 139, 0.3);
    }

    .single-mode.messenger {
        background: #1877f2;
    }

    .single-mode.messenger::before {
        background: rgba(24, 119, 242, 0.3);
    }
</style>

<div class="fixed-contact-wrapper">
    <div class="fixed-contact-buttons" id="contactActions">
        @if ($web_settings->website_phone3)
            <a href="https://wa.me/88{{ $web_settings->website_phone3 }}" target="_blank" class="social-outside whatsapp">
                <div class="text-card">WhatsApp</div>
                <div class="icon-circle"><i class="fa fa-whatsapp"></i></div>
            </a>
        @endif
        @if ($web_settings->website_phone)
            <a href="tel:{{ $web_settings->website_phone }}" class="social-outside call">
                <div class="text-card">Call Us</div>
                <div class="icon-circle"><i class="fa fa-phone"></i></div>
            </a>
        @endif
        @if ($web_settings->website_facebook)
            <a href="{{ $web_settings->website_facebook }}" target="_blank" class="social-outside messenger">
                <div class="text-card">Messenger</div>
                <div class="icon-circle">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-messenger" viewBox="0 0 16 16">
                        <path
                            d="M0 7.76C0 3.301 3.493 0 8 0s8 3.301 8 7.76-3.493 7.76-8 7.76c-.81 0-1.586-.107-2.316-.307a.64.64 0 0 0-.427.03l-1.588.702a.64.64 0 0 1-.898-.566l-.044-1.423a.64.64 0 0 0-.215-.456C.956 12.108 0 10.092 0 7.76m5.546-1.459-2.35 3.728c-.225.358.214.761.551.506l2.525-1.916a.48.48 0 0 1 .578-.002l1.869 1.402a1.2 1.2 0 0 0 1.735-.32l2.35-3.728c.226-.358-.214-.761-.551-.506L9.728 7.381a.48.48 0 0 1-.578.002L7.281 5.98a1.2 1.2 0 0 0-1.735.32z" />
                    </svg>
                </div>
            </a>
        @endif

    </div>

    <a href="javascript:void(0)" id="mainToggle" class="toggle-button call-toggle" onclick="toggleContacts()">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"
            class="icon icon-tabler icons-tabler-filled icon-tabler-message-circle">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path
                d="M5.821 4.91c3.899 -2.765 9.468 -2.539 13.073 .535c3.667 3.129 4.168 8.238 1.152 11.898c-2.841 3.447 -7.965 4.583 -12.231 2.805l-.233 -.101l-4.374 .931l-.04 .006l-.035 .007h-.018l-.022 .005h-.038l-.033 .004l-.021 -.001l-.023 .001l-.033 -.003h-.035l-.022 -.004l-.022 -.002l-.035 -.007l-.034 -.005l-.016 -.004l-.024 -.005l-.049 -.016l-.024 -.005l-.011 -.005l-.022 -.007l-.045 -.02l-.03 -.012l-.011 -.006l-.014 -.006l-.031 -.018l-.045 -.024l-.016 -.011l-.037 -.026l-.04 -.027l-.002 -.004l-.013 -.009l-.043 -.04l-.025 -.02l-.006 -.007l-.056 -.062l-.013 -.014l-.011 -.014l-.039 -.056l-.014 -.019l-.005 -.01l-.042 -.073l-.007 -.012l-.004 -.008l-.007 -.012l-.014 -.038l-.02 -.042l-.004 -.016l-.004 -.01l-.017 -.061l-.007 -.018l-.002 -.015l-.005 -.019l-.005 -.033l-.008 -.042l-.002 -.031l-.003 -.01v-.016l-.004 -.054l.001 -.036l.001 -.023l.002 -.053l.004 -.025v-.019l.008 -.035l.005 -.034l.005 -.02l.004 -.02l.018 -.06l.003 -.013l1.15 -3.45l-.022 -.037c-2.21 -3.747 -1.209 -8.391 2.413 -11.119z" />
        </svg>
    </a>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const box = document.getElementById('contactActions');
        const toggleBtn = document.getElementById('mainToggle');
        const actions = box.querySelectorAll('.social-outside');

        if (!actions.length) toggleBtn.remove();

        if (actions.length === 1) {
            toggleBtn.remove();
            box.classList.add('show', 'single-mode');
            actions.forEach(a => a.classList.add('single-mode'));
            return;
        }

        toggleBtn.addEventListener('click', () => {
            box.classList.toggle('show');
        });
    });
</script>
