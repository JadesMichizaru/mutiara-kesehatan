/* ============================================
   KLINIK SEHATSEJAHTERA - MAIN JAVASCRIPT
   ============================================
   Struktur:
   1. DOM Ready & Initialization
   2. Header/Navbar Scroll Behavior
   3. Mobile Navigation Toggle
   4. Smooth Scroll & Active Nav Link
   5. Statistics Counter Animation
   6. Appointment Form Validation
   7. AI Chatbot Logic
   8. Scroll to Top Button
   9. Utility Functions
   ============================================ */

// ============================================
// 1. DOM READY & INITIALIZATION
// ============================================
document.addEventListener('DOMContentLoaded', () => {
    // Initialize all modules
    initHeaderScroll();
    initMobileNav();
    initSmoothScroll();
    initStatsCounter();
    initAppointmentForm();
    initChatbot();
    initScrollTop();
    setMinDate();
});


// ============================================
// 2. HEADER SCROLL BEHAVIOR
// ============================================
function initHeaderScroll() {
    const header = document.getElementById('header');
    let lastScroll = 0;

    window.addEventListener('scroll', () => {
        const currentScroll = window.pageYOffset;

        // Add/remove scrolled class for styling
        if (currentScroll > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }

        lastScroll = currentScroll;
    });
}


// ============================================
// 3. MOBILE NAVIGATION TOGGLE
// ============================================
function initMobileNav() {
    const toggle = document.getElementById('mobileToggle');
    const menu = document.getElementById('navMenu');
    const navLinks = document.querySelectorAll('.nav-link');

    toggle.addEventListener('click', () => {
        toggle.classList.toggle('active');
        menu.classList.toggle('open');
        document.body.style.overflow = menu.classList.contains('open') ? 'hidden' : '';
    });

    // Close menu when a link is clicked
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            toggle.classList.remove('active');
            menu.classList.remove('open');
            document.body.style.overflow = '';
        });
    });

    // Close menu when clicking outside
    document.addEventListener('click', (e) => {
        if (!menu.contains(e.target) && !toggle.contains(e.target) && menu.classList.contains('open')) {
            toggle.classList.remove('active');
            menu.classList.remove('open');
            document.body.style.overflow = '';
        }
    });
}


// ============================================
// 4. SMOOTH SCROLL & ACTIVE NAV LINK
// ============================================
function initSmoothScroll() {
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('.nav-link');

    // Intersection Observer for active link highlighting
    const observerOptions = {
        root: null,
        rootMargin: '-20% 0px -80% 0px',
        threshold: 0
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const id = entry.target.getAttribute('id');
                navLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href') === `#${id}`) {
                        link.classList.add('active');
                    }
                });
            }
        });
    }, observerOptions);

    sections.forEach(section => observer.observe(section));
}


// ============================================
// 5. STATISTICS COUNTER ANIMATION
// ============================================
function initStatsCounter() {
    const statNumbers = document.querySelectorAll('.stat-number');
    let animated = false;

    const animateCounter = (element, target) => {
        const duration = 2000; // 2 seconds
        const steps = 60;
        const increment = target / steps;
        let current = 0;
        let step = 0;

        const timer = setInterval(() => {
            step++;
            current = Math.min(Math.round(increment * step), target);
            element.textContent = current.toLocaleString('id-ID');

            if (step >= steps) {
                clearInterval(timer);
                element.textContent = target.toLocaleString('id-ID');
            }
        }, duration / steps);
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !animated) {
                animated = true;
                statNumbers.forEach(stat => {
                    const target = parseInt(stat.getAttribute('data-target'));
                    animateCounter(stat, target);
                });
            }
        });
    }, { threshold: 0.5 });

    const statsBar = document.querySelector('.stats-bar');
    if (statsBar) observer.observe(statsBar);
}


// ============================================
// 6. APPOINTMENT FORM VALIDATION
// ============================================
function initAppointmentForm() {
    const form = document.getElementById('appointmentForm');
    const submitBtn = document.getElementById('submitBtn');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        // Clear previous errors
        clearFormErrors();

        // Validate all fields
        const isValid = validateForm();

        if (isValid) {
            // Show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> <span>Mengirim...</span>';

            // Simulate API call (replace with actual API endpoint)
            try {
                await simulateAPICall();

                // Show success message
                const successMsg = document.getElementById('formSuccess');
                successMsg.classList.add('show');
                form.reset();

                // Scroll to success message
                successMsg.scrollIntoView({ behavior: 'smooth', block: 'center' });

                // Reset button after 3 seconds
                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> <span>Kirim Pendaftaran</span>';
                }, 3000);

            } catch (error) {
                alert('Terjadi kesalahan. Silakan coba lagi.');
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> <span>Kirim Pendaftaran</span>';
            }
        }
    });

    // Real-time validation on blur
    const inputs = form.querySelectorAll('.form-input');
    inputs.forEach(input => {
        input.addEventListener('blur', () => {
            validateSingleField(input);
        });
        input.addEventListener('input', () => {
            if (input.classList.contains('error')) {
                validateSingleField(input);
            }
        });
    });
}

function validateForm() {
    let isValid = true;

    // Name validation
    const name = document.getElementById('patientName');
    if (!name.value.trim() || name.value.trim().length < 3) {
        showFieldError(name, 'nameError', 'Nama minimal 3 karakter');
        isValid = false;
    }

    // Email validation
    const email = document.getElementById('patientEmail');
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!email.value.trim() || !emailRegex.test(email.value)) {
        showFieldError(email, 'emailError', 'Format email tidak valid');
        isValid = false;
    }

    // Phone validation
    const phone = document.getElementById('patientPhone');
    const phoneRegex = /^(\+62|62|0)8[1-9][0-9]{7,10}$/;
    if (!phone.value.trim() || !phoneRegex.test(phone.value.replace(/[\s-]/g, ''))) {
        showFieldError(phone, 'phoneError', 'Masukkan nomor WhatsApp yang valid');
        isValid = false;
    }

    // Date validation
    const date = document.getElementById('appointmentDate');
    if (!date.value) {
        showFieldError(date, 'dateError', 'Pilih tanggal kunjungan');
        isValid = false;
    } else {
        const selectedDate = new Date(date.value);
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        if (selectedDate < today) {
            showFieldError(date, 'dateError', 'Tanggal tidak boleh di masa lalu');
            isValid = false;
        }
    }

    // Service validation
    const service = document.getElementById('serviceSelect');
    if (!service.value) {
        showFieldError(service, 'serviceError', 'Pilih layanan yang diinginkan');
        isValid = false;
    }

    return isValid;
}

function validateSingleField(input) {
    const id = input.id;
    let errorId = '';
    let errorMsg = '';

    switch(id) {
        case 'patientName':
            errorId = 'nameError';
            if (!input.value.trim() || input.value.trim().length < 3) {
                errorMsg = 'Nama minimal 3 karakter';
            }
            break;
        case 'patientEmail':
            errorId = 'emailError';
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!input.value.trim() || !emailRegex.test(input.value)) {
                errorMsg = 'Format email tidak valid';
            }
            break;
        case 'patientPhone':
            errorId = 'phoneError';
            const phoneRegex = /^(\+62|62|0)8[1-9][0-9]{7,10}$/;
            if (!input.value.trim() || !phoneRegex.test(input.value.replace(/[\s-]/g, ''))) {
                errorMsg = 'Masukkan nomor WhatsApp yang valid';
            }
            break;
        case 'appointmentDate':
            errorId = 'dateError';
            if (!input.value) {
                errorMsg = 'Pilih tanggal kunjungan';
            }
            break;
        case 'serviceSelect':
            errorId = 'serviceError';
            if (!input.value) {
                errorMsg = 'Pilih layanan yang diinginkan';
            }
            break;
    }

    if (errorMsg) {
        showFieldError(input, errorId, errorMsg);
    } else {
        clearFieldError(input, errorId);
    }
}

function showFieldError(input, errorId, message) {
    input.classList.add('error');
    const errorElement = document.getElementById(errorId);
    if (errorElement) {
        errorElement.textContent = message;
    }
}

function clearFieldError(input, errorId) {
    input.classList.remove('error');
    const errorElement = document.getElementById(errorId);
    if (errorElement) {
        errorElement.textContent = '';
    }
}

function clearFormErrors() {
    document.querySelectorAll('.form-input').forEach(input => {
        input.classList.remove('error');
    });
    document.querySelectorAll('.form-error').forEach(error => {
        error.textContent = '';
    });
}

function setMinDate() {
    const dateInput = document.getElementById('appointmentDate');
    if (dateInput) {
        const today = new Date().toISOString().split('T')[0];
        dateInput.setAttribute('min', today);
    }
}

function simulateAPICall() {
    return new Promise((resolve) => {
        setTimeout(resolve, 1500);
    });
}


// ============================================
// 7. AI CHATBOT LOGIC
// ============================================
function initChatbot() {
    const toggle = document.getElementById('chatbotToggle');
    const window_ = document.getElementById('chatbotWindow');
    const closeBtn = document.getElementById('chatbotClose');
    const minimizeBtn = document.getElementById('chatbotMinimize');
    const input = document.getElementById('chatbotInput');
    const sendBtn = document.getElementById('chatbotSend');
    const messagesArea = document.getElementById('chatbotMessages');
    const quickReplies = document.querySelectorAll('.quick-reply-btn');
    const badge = document.getElementById('chatbotBadge');

    let isFirstOpen = true;

    // Toggle chat window
    toggle.addEventListener('click', () => {
        const isOpen = window_.classList.contains('open');

        if (isOpen) {
            window_.classList.remove('open');
            toggle.classList.remove('active');
        } else {
            window_.classList.add('open');
            toggle.classList.add('active');
            badge.classList.add('hidden');

            // Send welcome message on first open
            if (isFirstOpen) {
                isFirstOpen = false;
                setTimeout(() => {
                    addBotMessage(getWelcomeMessage());
                }, 500);
            }
        }
    });

    // Close button
    closeBtn.addEventListener('click', () => {
        window_.classList.remove('open');
        toggle.classList.remove('active');
    });

    // Minimize button
    minimizeBtn.addEventListener('click', () => {
        window_.classList.remove('open');
        toggle.classList.remove('active');
    });

    // Send message on button click
    sendBtn.addEventListener('click', () => {
        sendMessage();
    });

    // Send message on Enter key
    input.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            sendMessage();
        }
    });

    // Quick reply buttons
    quickReplies.forEach(btn => {
        btn.addEventListener('click', () => {
            const query = btn.getAttribute('data-query');
            input.value = query;
            sendMessage();
        });
    });

    // Main send function
    function sendMessage() {
        const message = input.value.trim();
        if (!message) return;

        // Add user message to chat
        addUserMessage(message);
        input.value = '';

        // Show typing indicator
        showTypingIndicator();

        // Generate bot response (simulated AI)
        setTimeout(() => {
            removeTypingIndicator();
            const response = generateBotResponse(message);
            addBotMessage(response);
        }, 1000 + Math.random() * 1000); // Simulate thinking time
    }
}

// ============================================
// CHATBOT MESSAGE FUNCTIONS
// ============================================

function addUserMessage(text) {
    const messagesArea = document.getElementById('chatbotMessages');
    const time = getCurrentTime();

    const messageHTML = `
        <div class="message user">
            <div class="message-avatar">
                <i class="fas fa-user"></i>
            </div>
            <div>
                <div class="message-bubble">${escapeHTML(text)}</div>
                <span class="message-time">${time}</span>
            </div>
        </div>
    `;

    messagesArea.insertAdjacentHTML('beforeend', messageHTML);
    scrollToBottom();
}

function addBotMessage(text) {
    const messagesArea = document.getElementById('chatbotMessages');
    const time = getCurrentTime();

    const messageHTML = `
        <div class="message bot">
            <div class="message-avatar">
                <i class="fas fa-robot"></i>
            </div>
            <div>
                <div class="message-bubble">${text}</div>
                <span class="message-time">${time}</span>
            </div>
        </div>
    `;

    messagesArea.insertAdjacentHTML('beforeend', messageHTML);
    scrollToBottom();
}

function showTypingIndicator() {
    const messagesArea = document.getElementById('chatbotMessages');

    const typingHTML = `
        <div class="message bot" id="typingIndicator">
            <div class="message-avatar">
                <i class="fas fa-robot"></i>
            </div>
            <div>
                <div class="message-bubble">
                    <div class="typing-indicator">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
    `;

    messagesArea.insertAdjacentHTML('beforeend', typingHTML);
    scrollToBottom();
}

function removeTypingIndicator() {
    const indicator = document.getElementById('typingIndicator');
    if (indicator) indicator.remove();
}

function scrollToBottom() {
    const messagesArea = document.getElementById('chatbotMessages');
    messagesArea.scrollTop = messagesArea.scrollHeight;
}

function getCurrentTime() {
    return new Date().toLocaleTimeString('id-ID', {
        hour: '2-digit',
        minute: '2-digit'
    });
}

function escapeHTML(str) {
    const div = document.createElement('div');
    div.textContent = str;
    return div.innerHTML;
}


// ============================================
// CHATBOT AI RESPONSE ENGINE
// ============================================

function getWelcomeMessage() {
    return `Halo! 👋 Saya <strong>SehatBot</strong>, asisten virtual Klinik SehatSejahtera.<br><br>
    Saya siap membantu Anda dengan informasi seputar:<br>
    • 📅 Jadwal & Pendaftaran<br>
    • 🏥 Layanan & Fasilitas<br>
    • 👨‍⚕️ Jadwal Dokter<br>
    • 💰 Estimasi Biaya<br><br>
    Silakan ketik pertanyaan Anda atau pilih topik di bawah ini!`;
}

function generateBotResponse(userMessage) {
    const message = userMessage.toLowerCase().trim();

    // ============================================
    // KEYWORD-BASED RESPONSE SYSTEM
    // ============================================

    // --- JAM OPERASIONAL ---
    if (containsKeywords(message, ['jam', 'buka', 'operasional', 'buka jam', 'tutup', 'jam buka', 'jam operasional'])) {
        return `🕐 <strong>Jam Operasional Klinik:</strong><br><br>
        📌 <strong>Senin - Jumat:</strong> 08:00 - 21:00 WIB<br>
        📌 <strong>Sabtu:</strong> 08:00 - 17:00 WIB<br>
        📌 <strong>Minggu:</strong> 09:00 - 14:00 WIB<br>
        🚑 <strong>IGD:</strong> 24 Jam (Setiap Hari)<br><br>
        Apakah ada yang bisa saya bantu lagi?`;
    }

    // --- JADWAL DOKTER ---
    if (containsKeywords(message, ['jadwal dokter', 'dokter', 'praktek', 'praktik', 'jam dokter'])) {
        return `👨‍⚕️ <strong>Jadwal Dokter Spesialis:</strong><br><br>
        🔹 <strong>dr. Ahmad Fauzi, Sp.PD</strong> (Penyakit Dalam)<br>
        &nbsp;&nbsp;&nbsp;Senin, Rabu, Jumat | 08:00 - 14:00<br><br>
        🔹 <strong>dr. Siti Nurhaliza, Sp.A</strong> (Anak)<br>
        &nbsp;&nbsp;&nbsp;Selasa, Kamis, Sabtu | 09:00 - 15:00<br><br>
        🔹 <strong>drg. Budi Santoso, Sp.Ort</strong> (Gigi)<br>
        &nbsp;&nbsp;&nbsp;Senin, Selasa, Kamis, Jumat | 10:00 - 17:00<br><br>
        🔹 <strong>dr. Rina Wati, Sp.JP</strong> (Jantung)<br>
        &nbsp;&nbsp;&nbsp;Senin, Rabu, Jumat | 13:00 - 19:00<br><br>
        Ingin membuat janji temu? Ketik <em>"cara daftar"</em> untuk info pendaftaran.`;
    }

    // --- CARA PENDAFTARAN ---
    if (containsKeywords(message, ['daftar', 'pendaftaran', 'cara daftar', 'register', 'registrasi', 'buat janji', 'booking', 'reservasi'])) {
        return `📋 <strong>Cara Mendaftar Konsultasi:</strong><br><br>
        <strong>Opsi 1 - Online (Disarankan):</strong><br>
        1️⃣ Scroll ke bagian "Buat Janji" di website ini<br>
        2️⃣ Isi formulir pendaftaran<br>
        3️⃣ Tim kami akan konfirmasi via WhatsApp<br><br>
        <strong>Opsi 2 - Telepon:</strong><br>
        📞 Hubungi (021) 123-4567<br><br>
        <strong>Opsi 3 - Datang Langsung:</strong><br>
        📍 Jl. Kesehatan No. 123, Jakarta Selatan<br><br>
        💡 <em>Tips: Pendaftaran online lebih cepat dan Anda bisa memilih dokter sesuai preferensi!</em>`;
    }

    // --- BIAYA KONSULTASI ---
    if (containsKeywords(message, ['biaya', 'harga', 'tarif', 'bayar', 'ongkos', 'konsultasi', 'berapa', 'cost', 'price'])) {
        return `💰 <strong>Estimasi Biaya Layanan:</strong><br><br>
        🔹 Konsultasi Dokter Umum: <strong>Rp 100.000 - 150.000</strong><br>
        🔹 Konsultasi Dokter Spesialis: <strong>Rp 200.000 - 350.000</strong><br>
        🔹 Pemeriksaan Gigi: <strong>Rp 150.000 - 500.000</strong><br>
        🔹 Lab (Darah Lengkap): <strong>Rp 150.000 - 300.000</strong><br>
        🔹 USG: <strong>Rp 250.000 - 400.000</strong><br><br>
        ✅ Kami menerima: <strong>BPJS, Asuransi Swasta, & Pembayaran Tunai/Transfer</strong><br><br>
        <em>*Biaya dapat bervariasi tergantung tindakan medis yang diperlukan. Untuk info lebih detail, silakan hubungi kami.</em>`;
    }

    // --- LOKASI / ALAMAT ---
    if (containsKeywords(message, ['alamat', 'lokasi', 'dimana', 'where', 'tempat', 'maps', 'google maps', 'arah'])) {
        return `📍 <strong>Lokasi Klinik:</strong><br><br>
        🏥 Klinik SehatSejahtera<br>
        Jl. Kesehatan No. 123<br>
        Jakarta Selatan 12345<br><br>
        🚗 <strong>Akses:</strong><br>
        • Dekat Stasiun MRT Kebayoran (5 menit jalan kaki)<br>
        • Tersedia parkir luas (mobil & motor)<br>
        • Halte TransJakarta di depan klinik<br><br>
        📱 Navigasi: Cari "Klinik SehatSejahtera" di Google Maps<br><br>
        Butuh bantuan lain?`;
    }

    // --- LAYANAN ---
    if (containsKeywords(message, ['layanan', 'pelayanan', 'service', 'poli', 'poliklinik', 'fasilitas'])) {
        return `🏥 <strong>Layanan Kami:</strong><br><br>
        🔹 Poliklinik Umum<br>
        🔹 Klinik Gigi & Ortodonti<br>
        🔹 Klinik Anak & Imunisasi<br>
        🔹 Klinik Jantung & Kardiovaskular<br>
        🔹 Laboratorium (Hasil Cepat)<br>
        🔹 Radiologi (Rontgen, USG, CT Scan)<br>
        🔹 Medical Check-Up<br>
        🔹 Fisioterapi<br><br>
        Semua layanan ditangani dokter bersertifikat dengan peralatan modern. Mau tahu detail layanan tertentu?`;
    }

    // --- BPJS / ASURANSI ---
    if (containsKeywords(message, ['bpjs', 'asuransi', 'insurance', 'coverage', 'ditanggung', 'klaim'])) {
        return `🛡️ <strong>Informasi BPJS & Asuransi:</strong><br><br>
        ✅ <strong>BPJS Kesehatan:</strong> Kami menerima pasien BPJS dengan surat rujukan<br>
        ✅ <strong>Asuransi Swasta:</strong> Kami bekerja sama dengan 20+ perusahaan asuransi<br><br>
        <strong>Asuransi yang diterima:</strong><br>
        • Prudential, AIA, Allianz<br>
        • Manulife, AXA, Cigna<br>
        • Dan lainnya<br><br>
        📋 <strong>Dokumen yang diperlukan:</strong><br>
        1. KTP / Identitas<br>
        2. Kartu BPJS / Asuransi<br>
        3. Surat Rujukan (untuk BPJS)<br><br>
        Ada pertanyaan lain?`;
    }

    // --- GEJALA / KELUHAN UMUM ---
    if (containsKeywords(message, ['demam', 'sakit kepala', 'pusing', 'batuk', 'flu', 'pilek', 'diare', 'mual', 'gejala'])) {
        return `🩺 <strong>Saran Awal untuk Gejala Anda:</strong><br><br>
        Terima kasih sudah berbagi. Berikut saran umum:<br><br>
        ⚠️ <strong>PENTING:</strong> Informasi ini bukan pengganti diagnosa dokter.<br><br>
        💡 <strong>Langkah yang disarankan:</strong><br>
        1. Istirahat yang cukup<br>
        2. Minum air putih minimal 2 liter/hari<br>
        3. Konsumsi makanan bergizi<br>
        4. Jika gejala > 3 hari, segera konsultasi dokter<br><br>
        🚨 <strong>Segera ke IGD jika:</strong><br>
        • Demam > 39°C tidak turun<br>
        • Sesak napas<br>
        • Nyeri dada<br>
        • Penurunan kesadaran<br><br>
        Mau buat janji konsultasi? Ketik <em>"cara daftar"</em>`;
    }

    // --- IGU / DARURAT ---
    if (containsKeywords(message, ['darurat', 'emergency', 'igd', 'gawat', 'urgent'])) {
        return `🚨 <strong>Layanan Gawat Darurat (IGD):</strong><br><br>
        IGD Klinik SehatSejahtera beroperasi <strong>24 JAM</strong> setiap hari.<br><br>
        📞 <strong>Nomor Darurat:</strong> 0812-3456-7890<br>
        📍 <strong>Alamat:</strong> Jl. Kesehatan No. 123, Jaksel<br><br>
        ⚡ <strong>Langkah saat darurat:</strong><br>
        1. Hubungi nomor darurat di atas<br>
        2. Jelaskan kondisi pasien<br>
        3. Tim ambulans akan diarahkan jika diperlukan<br><br>
        <em>Jika kondisi mengancam jiwa, segera hubungi 118/119 (Ambulans Nasional).</em>`;
    }

    // --- TERIMA KASIH / PENUTUP ---
    if (containsKeywords(message, ['terima kasih', 'thanks', 'makasih', 'ok', 'oke', 'baik', 'sip', 'mantap'])) {
        return `Sama-sama! 😊 Senang bisa membantu Anda.<br><br>
        Jika ada pertanyaan lain di kemudian hari, jangan ragu untuk chat kembali. Saya selalu siap membantu 24/7!<br><br>
        🏥 Semoga lekas sembuh dan sehat selalu!<br>
        <em>- Tim SehatBot, Klinik SehatSejahtera</em>`;
    }

    // --- HALO / SALAM ---
    if (containsKeywords(message, ['halo', 'hai', 'hello', 'hi', 'selamat', 'pagi', 'siang', 'sore', 'malam'])) {
        return `Halo! 👋 Senang bertemu dengan Anda!<br><br>
        Saya SehatBot, siap membantu memberikan informasi seputar Klinik SehatSejahtera.<br><br>
        Apa yang bisa saya bantu hari ini? Anda bisa bertanya tentang:<br>
        • 📅 Jadwal dokter & pendaftaran<br>
        • 💰 Estimasi biaya<br>
        • 🏥 Layanan yang tersedia<br>
        • 📍 Lokasi & jam operasional`;
    }

    // --- MEDICAL CHECK UP ---
    if (containsKeywords(message, ['check up', 'medical check', 'mcu', 'paket', 'paket kesehatan'])) {
        return `🔬 <strong>Paket Medical Check-Up:</strong><br><br>
        🔹 <strong>Paket Basic</strong> - Rp 350.000<br>
        &nbsp;&nbsp;&nbsp;Darah lengkap, urine, gula darah, kolesterol<br><br>
        🔹 <strong>Paket Standard</strong> - Rp 750.000<br>
        &nbsp;&nbsp;&nbsp;Basic + EKG, Rontgen thorax, USG abdomen<br><br>
        🔹 <strong>Paket Executive</strong> - Rp 1.500.000<br>
        &nbsp;&nbsp;&nbsp;Standard + CT Scan, tumor marker, konsultasi spesialis<br><br>
        📌 Tersedia juga paket corporate untuk perusahaan.<br>
        Mau booking MCU? Ketik <em>"cara daftar"</em>`;
    }

    // ============================================
    // FALLBACK / DEFAULT RESPONSE
    // ============================================
    return `Terima kasih atas pertanyaan Anda! 🤔<br><br>
    Saya belum bisa menjawab pertanyaan tersebut secara spesifik. Namun, saya bisa membantu Anda dengan:<br><br>
    • 📅 <strong>Jam operasional</strong> - Ketik "jam buka"<br>
    • 👨‍⚕️ <strong>Jadwal dokter</strong> - Ketik "jadwal dokter"<br>
    • 📋 <strong>Cara pendaftaran</strong> - Ketik "cara daftar"<br>
    • 💰 <strong>Biaya layanan</strong> - Ketik "biaya"<br>
    • 📍 <strong>Lokasi klinik</strong> - Ketik "alamat"<br><br>
    Atau hubungi langsung tim kami di <strong>(021) 123-4567</strong> untuk pertanyaan lebih spesifik. 📞`;
}

/**
 * Helper: Check if message contains any of the given keywords
 */
function containsKeywords(message, keywords) {
    return keywords.some(keyword => message.includes(keyword));
}


// ============================================
// 8. SCROLL TO TOP BUTTON
// ============================================
function initScrollTop() {
    const scrollTopBtn = document.getElementById('scrollTop');

    window.addEventListener('scroll', () => {
        if (window.pageYOffset > 500) {
            scrollTopBtn.classList.add('visible');
        } else {
            scrollTopBtn.classList.remove('visible');
        }
    });

    scrollTopBtn.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
}


// ============================================
// 9. PLACEHOLDER: API INTEGRATION
// ============================================
/*
 * ============================================
 * INTEGRASI AI API (OPENAI / GEMINI)
 * ============================================
 *
 * Untuk menghubungkan chatbot ke AI API sesungguhnya,
 * ganti fungsi generateBotResponse() dengan kode berikut:
 *
 * async function generateBotResponseAPI(userMessage) {
 *     try {
 *         // === OPSI 1: OpenAI API ===
 *         const response = await fetch('https://api.openai.com/v1/chat/completions', {
 *             method: 'POST',
 *             headers: {
 *                 'Content-Type': 'application/json',
 *                 'Authorization': `Bearer ${YOUR_OPENAI_API_KEY}`
 *             },
 *             body: JSON.stringify({
 *                 model: 'gpt-3.5-turbo',
 *                 messages: [
 *                     {
 *                         role: 'system',
 *                         content: `Anda adalah SehatBot, asisten virtual Klinik SehatSejahtera.
 *                         Berikan informasi seputar layanan klinik, jadwal dokter, biaya, dan pendaftaran.
 *                         Selalu ingatkan bahwa untuk diagnosa medis, pasien harus konsultasi langsung ke dokter.
 *                         Jawab dalam bahasa Indonesia, ramah, dan profesional.`
 *                     },
 *                     {
 *                         role: 'user',
 *                         content: userMessage
 *                     }
 *                 ],
 *                 max_tokens: 500,
 *                 temperature: 0.7
 *             })
 *         });
 *
 *         const data = await response.json();
 *         return data.choices[0].message.content;
 *
 *         // === OPSI 2: Google Gemini API ===
 *         // const response = await fetch(
 *         //     `https://generativelanguage.googleapis.com/v1/models/gemini-pro:generateContent?key=${YOUR_GEMINI_API_KEY}`,
 *         //     {
 *         //         method: 'POST',
 *         //         headers: { 'Content-Type': 'application/json' },
 *         //         body: JSON.stringify({
 *         //             contents: [{
 *         //                 parts: [{
 *         //                     text: `Sebagai asisten Klinik SehatSejahtera, jawab: ${userMessage}`
 *         //                 }]
 *         //             }]
 *         //         })
 *         //     }
 *         // );
 *         // const data = await response.json();
 *         // return data.candidates[0].content.parts[0].text;
 *
 *     } catch (error) {
 *         console.error('API Error:', error);
 *         return 'Maaf, terjadi kendala teknis. Silakan hubungi kami di (021) 123-4567.';
 *     }
 * }
 *
 * CATATAN PENTING:
 * - Jangan expose API key di frontend untuk production!
 * - Gunakan backend server sebagai proxy untuk API calls
 * - Implementasi rate limiting untuk mencegah penyalahgunaan
 */
