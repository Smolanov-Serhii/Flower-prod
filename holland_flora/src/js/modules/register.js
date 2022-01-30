const registerPolicy = () => {
    if (!document.querySelector('.auth-checkbox__input--policy')) return;

    const policyInput = document.querySelector('.auth-checkbox__input--policy');
    const btnSubmit = document.querySelector('.auth__submit');

    const checkInit = () => {
        if (policyInput.checked) {
            btnSubmit.removeAttribute('disabled');
        } else {
            btnSubmit.setAttribute('disabled', 'true');
        }
    };

    checkInit();
    policyInput.addEventListener('change', checkInit);
};

export default registerPolicy;