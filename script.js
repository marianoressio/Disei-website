const carouselInner = document.querySelector('.carousel-inner');
const items = document.querySelectorAll('.carousel-item');
const prevBtn = document.querySelector('.prev');
const nextBtn = document.querySelector('.next');
let currentIndex = 0;

function showSlide(index) {
    if (items.length === 0) return;
    if (index >= items.length) {
        currentIndex = 0;
    } else if (index < 0) {
        currentIndex = items.length - 1;
    } else {
        currentIndex = index;
    }
    carouselInner.style.transform = `translateX(-${currentIndex * 100}%)`;
}

// Auto-slide
if (carouselInner && items.length > 0) {
    setInterval(() => {
        showSlide(currentIndex + 1);
    }, 3000);
}

// Manual controls
if (prevBtn && nextBtn) {
    nextBtn.addEventListener('click', () => showSlide(currentIndex + 1));
    prevBtn.addEventListener('click', () => showSlide(currentIndex - 1));
}

// Password protection
function checkPassword() {
    const passwordInput = document.getElementById('training-password');
    const trainingMaterials = document.getElementById('training-materials');
    const correctPassword = 'disei2025';

    if (passwordInput && trainingMaterials) {
        if (passwordInput.value === correctPassword) {
            trainingMaterials.classList.remove('hidden');
            passwordInput.parentElement.style.display = 'none';
        } else {
            alert('Contraseña incorrecta. Por favor, intenta de nuevo.');
            passwordInput.value = '';
        }
    }
}

// 🌐 Menú responsive (hamburguesa + cierre automático)
document.addEventListener('DOMContentLoaded', () => {
    const menuBtn = document.getElementById('menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');

    if (menuBtn && mobileMenu) {
        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Cerrar el menú al hacer clic en un enlace dentro de él
        const menuLinks = mobileMenu.querySelectorAll('a');
        menuLinks.forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
            });
        });
    }
});

// Inicializar AOS
document.addEventListener('DOMContentLoaded', function () {
    if (typeof AOS !== 'undefined') { 
        AOS.init({
            duration: 800,
            once: true,
            offset: 50,
            disable: 'mobile'
        });

    }
});