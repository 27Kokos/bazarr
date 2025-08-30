// scripts/main.js
const burger = document.querySelector('.burger');
const nav = document.querySelector('.nav-links');
const backdrop = document.querySelector('.backdrop');

// Проверяем, что элементы бургер-меню существуют
if (burger && nav && backdrop) {
    function openMenu() {
        nav.classList.add('is-open');
        backdrop.hidden = false;
        burger.setAttribute('aria-expanded', 'true');
        document.body.style.overflow = 'hidden'; // Блокируем прокрутку фона
    }

    function closeMenu() {
        nav.classList.remove('is-open');
        backdrop.hidden = true;
        burger.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = ''; // Разблокируем прокрутку
    }

    // Открытие/закрытие по клику на бургер
    burger.addEventListener('click', () => {
        if (nav.classList.contains('is-open')) {
            closeMenu();
        } else {
            openMenu();
        }
    });

    // Закрытие по клику на подложку
    backdrop.addEventListener('click', closeMenu);

    // Обработка кликов по ссылкам в меню
    nav.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', function(e) {
            // Закрываем меню при клике на любую ссылку
            closeMenu();
            
            // Для якорных ссылок (которые начинаются с #) - плавная прокрутка
            const href = this.getAttribute('href');
            if (href && href.startsWith('#')) {
                e.preventDefault();
                const targetId = href.substring(1);
                const targetElement = document.getElementById(targetId);
                if (targetElement) {
                    targetElement.scrollIntoView({ 
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
            // Для обычных ссылок (например, на catalog.php) - разрешаем стандартный переход
        });
    });

    // Закрытие меню при изменении размера окна на desktop
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768 && nav.classList.contains('is-open')) {
            closeMenu();
        }
    });

} else {
    console.log('Элементы бургер-меню не найдены (возможно, desktop версия)');
}