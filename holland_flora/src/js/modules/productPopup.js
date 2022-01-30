//TEMP!!!!!!!!!!!!!!
function productPopup() {
  const productCarts = document.querySelectorAll(".productCart");
  const popupProduct = document.querySelector(".popupProduct");

  productCarts &&
    productCarts.forEach((productCart) => {
      productCart.addEventListener("click", function (e) {
        if (popupProduct) {
          const {
            id,
            name,
            img,
            color,
            min,
            height,
            price,
            code,
          } = this.dataset;

          const imgItem = popupProduct.querySelector(".popupProductImg");
          const nameItem = popupProduct.querySelector(".popupProductName");
          const minItem = popupProduct.querySelector(".popupProductMin");
          const colorItem = popupProduct.querySelector(".popupProductColor");
          const heightItem = popupProduct.querySelector(".popupProductHeight");
          const priceItem = popupProduct.querySelector(".currentPrice");
          const countPriceItem = popupProduct.querySelector(".countPrice");
          const itemsCount = popupProduct.querySelector(".itemsCount");
          const counterMinValItem = popupProduct.querySelector(
            ".counterMinVal"
          );
          const productIdItem = popupProduct.querySelector(".productId");
          const productCountItems = document.querySelectorAll(".productCount");

          const productCode = document.querySelector(".productCode");

          if (imgItem) {
            imgItem.src = img;
          }
          if (nameItem) {
            nameItem.textContent = name;
          }
          if (minItem) {
            minItem.textContent = min;
          }
          if (colorItem) {
            colorItem.textContent = color;
          }
          if (heightItem) {
            heightItem.textContent = height;
          }
          if (priceItem) {
            priceItem.textContent = price;
          }
          if (countPriceItem) {
            countPriceItem.textContent = this.parentElement.querySelector(
              ".countPrice"
            ).textContent;
          }
          if (itemsCount) {
            itemsCount.value = this.parentElement.querySelector(
              ".itemsCount"
            ).value;
          }
          if (counterMinValItem) {
            counterMinValItem.dataset.minValue = min;
          }
          if (productIdItem) {
            productIdItem.value = id;
          }

          if (productCountItems) {
            productCountItems.forEach((pItem) => {
              pItem.value = this.parentElement.querySelector(
                ".itemsCount"
              ).value;
            });
          }

          if (productCode) {
            productCode.textContent = code;
          }

          //   popupProduct.querySelector(".popupProductImg").src = img;
          //   popupProduct.querySelector(".popupProductName").textContent = name;
          //   popupProduct.querySelector(".popupProductMin").textContent = min;
          //   popupProduct.querySelector(".popupProductColor").textContent = color;
          //   popupProduct.querySelector(
          //     ".popupProductHeight"
          //   ).textContent = `${height}`;
          //   popupProduct.querySelector(".currentPrice").textContent = `${price}`;
          //   popupProduct.querySelector(
          //     ".countPrice"
          //   ).textContent = this.parentElement.querySelector(
          //     ".countPrice"
          //   ).textContent;
          //   popupProduct.querySelector(
          //     ".itemsCount"
          //   ).value = this.parentElement.querySelector(".itemsCount").value;
          //   popupProduct.querySelector(".counterMinVal").dataset.minValue = min;

          //   popupProduct.querySelector(".productId").value = id;
        }
      });
    });
}

export default productPopup;
