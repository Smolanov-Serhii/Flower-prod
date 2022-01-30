const addRemoveCount = () => {
    const addRemoveItems = document.querySelectorAll('.addRemoveItems');
    const repeatOrderItems = document.querySelectorAll('.repeatOrder');

    repeatOrderItems && repeatOrderItems.forEach(repeatOrder => {
        repeatOrder.addEventListener('click', async function (e) {
            e.preventDefault();

            const {id, url} = this.dataset;

            const res = await fetch(url, {
                method: 'post',
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded; charset=utf-8",
                },
                body: `action=repeat_order&p=${id}`,
                credentials: "same-origin",
            });

            const resJson = await res.json();

            if (resJson) {
                if (resJson.success)
                    location.href = '/basket';
                else
                    alert('error');
            }
        });
    });


    addRemoveItems && addRemoveItems.forEach(addRemoveItem => {
        addRemoveItem.addEventListener('click', delay(async function (e) {
            e.preventDefault();

            const {id, url} = this.parentElement.dataset;

            const count = this.parentElement.querySelector('.itemsCount').value;

            await fetch(url, {
                method: 'post',
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded; charset=utf-8",
                },
                body: `action=change_items_count&p=${id}&c=${count}`,
                credentials: "same-origin",
            });

            // const resJson = await res.json();

        }, 500));
    });
};

function delay(callback, ms) {
    let timer = 0;
    return function () {
        let context = this, args = arguments;
        clearTimeout(timer);
        timer = setTimeout(function () {
            callback.apply(context, args);
        }, ms || 0);
    };
}


export default addRemoveCount;