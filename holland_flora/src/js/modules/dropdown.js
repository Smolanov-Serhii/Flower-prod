const dropdown = (dropdownSelect, dropdownTriggerSelect, dropdownItemSelect) => {
  if (document.querySelector(dropdownSelect)) {
    const dropdown = document.querySelectorAll(dropdownSelect);
    const dropdownTrigger = document.querySelectorAll(dropdownTriggerSelect);
    const dropdownItem = document.querySelectorAll(dropdownItemSelect);

    dropdownTrigger.forEach(item => {
      item.addEventListener('click', function () {
        if (this.closest(dropdownSelect).classList.contains('act')) {
          this.closest(dropdownSelect).classList.toggle('act');
        } else {
          dropdown.forEach(item => {
            item.classList.remove('act');
          });
          this.closest(dropdownSelect).classList.add('act');
        }
      });
    });
    dropdownItem.forEach(item => {
      item.addEventListener('click', (e) => {
        const currentItem = e.target.innerHTML;
        e.target.closest(dropdownSelect).querySelector('input').value = currentItem;
        e.target.closest(dropdownSelect).classList.remove('act');
        if (e.target.closest('.lang__item')) {
          document.querySelectorAll('.lang__item').forEach(item => {
            item.style.display = '';
          });
          e.target.style.display = 'none';
        }
      });
    });
    document.addEventListener('click', (e) => {

      if (!e.target.closest(dropdownSelect) && !e.target.closest('act')) {
        dropdown.forEach(item => {
          item.classList.remove('act');
        });
      }
    });
  }
};

export default dropdown;
