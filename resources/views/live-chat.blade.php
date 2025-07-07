{{-- === BOOTSTRAP ICONS & ANIMATE.CSS === --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

{{-- === CUSTOM STYLE === --}}
<style>
    #minimizedBar {
        position: fixed;
        bottom: 20px;
        right: 90px;
        z-index: 9999;
        display: none;
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-radius: 999px;
        box-shadow: 0 0.25rem 0.5rem rgba(0,0,0,.1);
        padding: 6px 12px;
        font-size: 14px;
        cursor: pointer;
        align-items: center;
        gap: 8px;
    }

    .show-flex {
        display: flex !important;
    }
</style>

{{-- === TOMBOL CHAT (SELALU TAMPIL) === --}}
<button type="button" class="btn bg-warning text-dark rounded-circle position-fixed shadow d-flex justify-content-center align-items-center"
    style="bottom: 20px; right: 20px; width: 60px; height: 60px; z-index: 1050;"
    id="openRulesBtn" title="Butuh Bantuan?">
    <i class="bi bi-chat-dots-fill fs-4"></i>
</button>

{{-- === MINI NAVBAR SETELAH MINIMIZE === --}}
<div id="minimizedBar">
    <i class="bi bi-chat-left-dots me-2 text-primary"></i>
    <span class="small">Live Chat Minimize</span>
</div>

{{-- === POPUP ATURAN LIVE CHAT === --}}
<div class="card position-fixed shadow animate__animated animate__fadeInUp" id="rulesPopup"
    style="bottom: 90px; right: 20px; width: 340px; display: none; z-index: 1051; border-radius: 1rem; overflow: hidden;">
    <div class="card-header bg-warning d-flex justify-content-between align-items-center py-2 px-3 text-dark">
        <strong><i class="bi bi-info-circle-fill"></i> Aturan Live Chat</strong>
        <div>
            <button type="button" class="btn btn-sm btn-light me-1" id="minimizeRulesBtn" title="Minimize">
                <i class="bi bi-dash-lg"></i>
            </button>
            <button type="button" class="btn-close btn-sm" id="closeRulesBtn" title="Tutup"></button>
        </div>
    </div>
    <div class="card-body bg-light">
        <p class="small mb-2">Gunakan bahasa yang sopan. Admin akan membalas pesan Anda secepatnya.</p>
        <p class="small mb-0">Klik tombol di bawah untuk melanjutkan.</p>
    </div>
    <div class="card-footer bg-white text-end">
        @auth
        <button id="continueToChat" class="btn btn-sm btn-primary">
            <i class="bi bi-chat-right-text-fill"></i> Mulai Live Chat
        </button>
        @endauth
        @guest
        <a href="{{ route('login') }}" class="btn btn-sm btn-primary">
            <i class="bi bi-box-arrow-in-right"></i> Login Dulu
        </a>
        @endguest
    </div>
</div>

{{-- === CHAT BOX UTAMA (HANYA JIKA LOGIN) === --}}
@auth
    <div class="card position-fixed shadow animate__animated animate__fadeInUp" id="chatBox"
        style="bottom: 90px; right: 20px; width: 340px; max-height: 500px; display: none; z-index: 1051; border-radius: 1rem; overflow: hidden;">
        
        {{-- === HEADER SAMA SEPERTI RULES POPUP === --}}
        <div class="card-header bg-warning d-flex justify-content-between align-items-center py-2 px-3 text-dark">
            <strong><i class="bi bi-info-circle-fill me-1"></i> Live Chat</strong>
            <div>
                <button type="button" class="btn btn-sm btn-light me-1" id="minimizeChatBtn" title="Minimize">
                    <i class="bi bi-dash-lg"></i>
                </button>
                <button type="button" class="btn-close btn-sm" id="closeChatBtn" title="Tutup"></button>
            </div>
        </div>

        {{-- === ISI PESAN === --}}
        <div class="card-body bg-light" id="chatBody" style="height: 300px; overflow-y: auto;">
            <p class="text-muted small text-center mt-2">Memuat pesan...</p>
        </div>

        {{-- === FOOTER INPUT PESAN === --}}
        <div class="card-footer bg-white text-end border-top">
            <form id="chatForm">
                <div class="input-group">
                    <input type="text" name="message" id="chatInput" class="form-control rounded-start-pill" placeholder="Tulis pesan..." required>
                    <button class="btn btn-outline-primary rounded-end-pill" type="submit">
                        <i class="bi bi-send-fill"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endauth



{{-- === SCRIPT === --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const rulesPopup = document.getElementById('rulesPopup');
    const chatBox = document.getElementById('chatBox');
    const openRulesBtn = document.getElementById('openRulesBtn');
    const minimizedBar = document.getElementById('minimizedBar');

    const minimizeRulesBtn = document.getElementById('minimizeRulesBtn');
    const closeRulesBtn = document.getElementById('closeRulesBtn');

    let minimizedState = null;

    openRulesBtn.addEventListener('click', function () {
        rulesPopup.style.display = 'block';
        if (chatBox) chatBox.style.display = 'none';
        minimizedBar.classList.remove('show-flex');
        minimizedState = null;
    });

    minimizeRulesBtn.addEventListener('click', function () {
        rulesPopup.style.display = 'none';
        if (chatBox) chatBox.style.display = 'none';
        minimizedBar.classList.add('show-flex');
        minimizedState = 'rules';
    });

    closeRulesBtn.addEventListener('click', function () {
        rulesPopup.style.display = 'none';
        if (chatBox) chatBox.style.display = 'none';
        minimizedBar.classList.remove('show-flex');
        minimizedState = null;
    });

    minimizedBar.addEventListener('click', function () {
        if (minimizedState === 'rules') {
            rulesPopup.style.display = 'block';
        } else if (minimizedState === 'chat') {
            if (chatBox) {
                chatBox.style.display = 'block';
                loadChat && loadChat();
            }
        }
        minimizedBar.classList.remove('show-flex');
        minimizedState = null;
    });

    @auth
    const continueToChat = document.getElementById('continueToChat');
    const closeChatBtn = document.getElementById('closeChatBtn');
    const minimizeChatBtn = document.getElementById('minimizeChatBtn');
    const chatBody = document.getElementById('chatBody');
    const chatForm = document.getElementById('chatForm');
    const chatInput = document.getElementById('chatInput');

    continueToChat.addEventListener('click', function () {
        rulesPopup.style.display = 'none';
        chatBox.style.display = 'block';
        minimizedBar.classList.remove('show-flex');
        minimizedState = null;
        loadChat();
    });

    minimizeChatBtn.addEventListener('click', function () {
        chatBox.style.display = 'none';
        rulesPopup.style.display = 'none';
        minimizedBar.classList.add('show-flex');
        minimizedState = 'chat';
    });

    closeChatBtn.addEventListener('click', function () {
        chatBox.style.display = 'none';
        rulesPopup.style.display = 'none';
        minimizedBar.classList.remove('show-flex');
        minimizedState = null;
    });

    function loadChat() {
        fetch('{{ route('livechat.fetch') }}')
            .then(response => response.json())
            .then(data => {
                chatBody.innerHTML = '';

                if (data.length === 0 && !sessionStorage.getItem('chat_welcome_sent')) {
                    const welcomeMsg = `
                        <div class="text-start mb-2">
                            <span class="d-inline-block px-3 py-2 rounded-pill bg-white border" style="max-width: 80%; word-break: break-word;">
                                Halo 👋 Selamat datang di layanan live chat kami. Ada yang bisa kami bantu?
                            </span>
                        </div>
                    `;
                    chatBody.innerHTML = welcomeMsg;
                    sessionStorage.setItem('chat_welcome_sent', 'true');
                } else {
                    data.forEach(chat => {
                        // Jika pesan dari admin atau sistem: kiri, jika dari user: kanan
                        const isUser = !chat.is_from_admin;
                        const align = isUser ? 'text-end' : 'text-start';
                        const bg = isUser ? 'bg-primary text-white' : 'bg-white border';

                        const bubble = `
                            <div class="${align} mb-2">
                                <span class="d-inline-block px-3 py-2 rounded-pill ${bg}" style="max-width: 80%; word-break: break-word;">
                                    ${chat.message}
                                </span>
                            </div>`;
                        chatBody.innerHTML += bubble;
                    });

                    // Scroll otomatis ke bawah
                    chatBody.scrollTop = chatBody.scrollHeight;
                }
            });
    }



    chatForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const message = chatInput.value.trim();
        if (!message) return;

        fetch('{{ route('livechat.send') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ message })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                chatInput.value = '';
                loadChat();
            }
        });
    });
    @endauth
});
</script>
