const addToCart = () => {
    const changeCountBtns = document.querySelectorAll('.changeCountBtn');
    // const form = document.querySelector('.dateCheck');
    // const popupAttentionBtn = document.querySelector('.popupAttentionBtn');
    // const createOrder = document.querySelector('.createOrder');

    const removeFromCartItems = document.querySelectorAll('.removeFromCart');

    removeFromCartItems && removeFromCartItems.forEach(removeFromCart => {
        removeFromCart.addEventListener('click', async function (e) {
            e.preventDefault();
            const {url, body} = this.dataset;

            const res = await fetch(url, {
                method: 'post',
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded; charset=utf-8",
                },
                body,
                credentials: "same-origin",
            });

            // const resJson = await res.json();

            location.reload();
        });
    });

    // change order count items
    changeCountBtns && changeCountBtns.forEach(changeCountBtn => {
        changeCountBtn.addEventListener('click', function (e) {
            const productItem = this.closest('.productItem');
            if (productItem) {
                const countInput = productItem.querySelector('.productCount');
                const count = productItem.querySelector('.itemsCount');
                const currentPrice = productItem.querySelector('.currentPrice');
                const countPrice = productItem.querySelector('.countPrice');

                const totalPrice = document.querySelector('.totalPrice');

                countPrice.innerText = +currentPrice.innerText * +count.value;

                if (count && countInput) {
                    countInput.value = count.value;
                }

                if (totalPrice) {
                    let total = 0;
                    const prices = document.querySelectorAll('.countPrice');

                    prices && prices.forEach(price => {
                        total += +price.textContent;
                    });

                    total && (totalPrice.textContent = total.toString());
                }

            }
        });
    });
};

export default addToCart;