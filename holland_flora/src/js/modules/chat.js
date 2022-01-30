const chat = () => {
    if (!document.querySelector('.chat')) return;

    const chatOpen = document.querySelector('.chat__btn');
    const chatClose = document.querySelector('.chat__close');
    const chat = document.querySelector('.chat');

    chatOpen.addEventListener('click', () => {
        chat.classList.add('act');
    });

    chatClose.addEventListener('click', () => {
        chat.classList.remove('act');
    });

    document.addEventListener('click', (e) => {
        if (!e.target.closest('.chat.act') && !e.target.closest('.chat__btn')) {
            chat.classList.remove('act');
        }
    });
};

export default chat;