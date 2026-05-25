// Слайдер
function initSlider(sliderId) {
    const slider = document.querySelector(`#${sliderId} .slider`);
    const slides = document.querySelectorAll(`#${sliderId} .slide`);
    const prevBtn = document.querySelector(`#${sliderId} .prev`);
    const nextBtn = document.querySelector(`#${sliderId} .next`);
    const dotsContainer = document.querySelector(`#${sliderId} .dots`);
    if (!slider || slides.length === 0) return;

    let index = 0;
    let autoInterval;

    function updateSlider() {
        slider.style.transform = `translateX(-${index * 100}%)`;
        document.querySelectorAll(`#${sliderId} .dot`).forEach((dot, i) => {
            dot.classList.toggle('active', i === index);
        });
    }

    function next() { index = (index + 1) % slides.length; updateSlider(); resetAuto(); }
    function prev() { index = (index - 1 + slides.length) % slides.length; updateSlider(); resetAuto(); }
    function resetAuto() { clearInterval(autoInterval); autoInterval = setInterval(next, 3000); }

    if (prevBtn) prevBtn.addEventListener('click', prev);
    if (nextBtn) nextBtn.addEventListener('click', next);

    // Создание точек
    if (dotsContainer) {
        dotsContainer.innerHTML = '';
        slides.forEach((_, i) => {
            const dot = document.createElement('span');
            dot.classList.add('dot');
            if (i === index) dot.classList.add('active');
            dot.addEventListener('click', () => { index = i; updateSlider(); resetAuto(); });
            dotsContainer.appendChild(dot);
        });
    }
    resetAuto();
    updateSlider();
}

// Уведомление (toast)
function showToast(message, isError = false) {
    let toast = document.querySelector('.toast');
    if (!toast) {
        toast = document.createElement('div');
        toast.className = 'toast';
        document.body.appendChild(toast);
    }
    toast.textContent = message;
    toast.style.background = isError ? '#dc3545' : '#28a745';
    toast.classList.add('show');
    setTimeout(() => toast.classList.remove('show'), 3000);
}

// Валидация регистрации
function validateRegisterForm() {
    const login = document.getElementById('login')?.value;
    const password = document.getElementById('password')?.value;
    let valid = true;
    if (login && !/^[a-zA-Z0-9]{6,}$/.test(login)) {
        document.getElementById('loginError').innerText = 'Логин: лат. буквы/цифры, мин 6';
        valid = false;
    } else if (login) document.getElementById('loginError').innerText = '';
    if (password && password.length < 8) {
        document.getElementById('passwordError').innerText = 'Пароль не менее 8 символов';
        valid = false;
    } else if (password) document.getElementById('passwordError').innerText = '';
    return valid;
}

// Маска для даты ДД.ММ.ГГГГ
function maskDate(input) {
    let value = input.value.replace(/\D/g, '');
    if (value.length > 2) value = value.slice(0,2) + '.' + value.slice(2);
    if (value.length > 5) value = value.slice(0,5) + '.' + value.slice(5,9);
    input.value = value;
}