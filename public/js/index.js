const searchWrapper = document.querySelector(".search");
searchBtn = searchWrapper.querySelector(".search__btn");
searchValue = searchWrapper.querySelector(".search__input");
productsContainer = document.querySelector(".products__list");

searchBtn.addEventListener("click", function () {
  fetch("/products/search", {
    method: "POST",
    headers: {
      "Content-Type": "application/json;charset=utf-8",
    },
    body: JSON.stringify({ searchStr: searchValue.value }),
  })
    .then((res) => res.json())
    .then((data) => {
      renderProducts(data);
    });
});

function renderProducts(products) {
  productsContainer.innerHTML = "";
  products.forEach((product) => {
    productsContainer.innerHTML += `<li class="products__item product">
      <img class="product__img" src="https://dummyjson.com/image/i/products/${product.image}" alt="">
      <h3 class="product__title">${product.title}</h3>
      <p class="product__descr">${product.description}</p>
      <input type="hidden" name="productId" value="${product.productId}" required />
      <h3 class="product__title">${product.category.name}</h3>
      <div class="product__bottom-wrapper">
        <span class="product__price">${product.price}$</span>
        <input type="number" class="product__amount" name="amount" value="1" required />
        <input type="submit" class="product__btn button" value="Add to cart"
        ${product.isAddedToCart}/>
      </div>
    </li>`;
  });
}
