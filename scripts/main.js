const products = [
  { name: 'Bizim Tarla ,,Белая черешня’’', price: '₽255', img: 'bottle1.jpg' },
  { name: 'Bizim Tarla ,,Слива’’', price: '₽255', img: 'bottle2.jpg' },
  { name: 'Золото Азербайджана', price: '₽135', img: 'bottle3.jpg' },
  { name: 'Натахтари', price: '₽150', img: 'bottle4.jpg' },
];

const grid = document.querySelector('.product-grid');

products.forEach(p => {
  const card = document.createElement('div');
  card.className = 'product-card';
  card.innerHTML = `
    <img src="assets/images/${p.img}" alt="${p.name}" />
    <h3>${p.name}</h3>
    <div class="price">${p.price}</div>
  `;
  grid.appendChild(card);
});


const burger = document.querySelector('.burger');
const nav = document.querySelector('.nav-links');
const backdrop = document.querySelector('.backdrop');

function openMenu() {
  nav.classList.add('is-open');
  backdrop.hidden = false;
  burger.setAttribute('aria-expanded', 'true');
}

function closeMenu() {
  nav.classList.remove('is-open');
  backdrop.hidden = true;
  burger.setAttribute('aria-expanded', 'false');
}

burger.addEventListener('click', () => {
  nav.classList.contains('is-open') ? closeMenu() : openMenu();
});

backdrop.addEventListener('click', closeMenu);

nav.querySelectorAll('a').forEach(link => {
  link.addEventListener('click', e => {
    e.preventDefault();
    const targetId = link.getAttribute('href').substring(1);
    document.getElementById(targetId).scrollIntoView({ behavior: 'smooth' });
    closeMenu();
  });
});

