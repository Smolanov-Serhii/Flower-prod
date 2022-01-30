/*

triggerSelector - кнопка по клику которой открывается аккордион
bodySelector - тело аккордиона, которое спрятанно

!! если у кнопки присутствует [data-accordion] - будет работать "эффект аккокрдиона" !!

*/


const accordion = (triggerSelector, bodySelector) => {
  const btns = document.querySelectorAll(triggerSelector);

  btns.forEach(btn => {
    btn.addEventListener('click', function () {
      let parent;
      if (btn.classList.contains('products-aside-accord__btn')) {
        parent = this.parentNode.parentNode;
      } else {
        parent = this.parentNode;
      }
      parent.classList.toggle('act');

      if (parent.classList.contains('act')) {
        if (this.hasAttribute('data-accordion')) {
          btns.forEach(btn => {
            btn.parentNode.classList.remove('act');
            btn.parentNode.querySelector(bodySelector).style.height = '';
          });
          parent.classList.toggle('act');
        }

        parent.querySelector(bodySelector).style.height = parent.querySelector(bodySelector).scrollHeight + 'px';
      } else {
        parent.querySelector(bodySelector).style.height = '';
      }
    });
  });
};

export default accordion;
