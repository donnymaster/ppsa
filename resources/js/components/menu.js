
const menu = () => {
    const openMobileMenu = document.querySelector('#open-menu');
    const closeMobileMenu = document.querySelector('#close-menu');
    const menu = document.querySelector('.mobile-menu');
    const html = document.querySelector('html');

    if (!openMobileMenu && !closeMobileMenu) {
        return;
    }

    openMobileMenu.addEventListener('click', () => {
        menu.style.display = 'flex';
        html.style.overflow = 'hidden';
    });

    closeMobileMenu.addEventListener('click', () => {
        menu.style.display = 'none';
        html.style.overflow = 'auto';
    });
}

export default menu;
