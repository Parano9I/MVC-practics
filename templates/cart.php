<body>
    <section class="products">
        <div class="container">
            <h1 class="products__title">Cart</h1>
            <ul class="products__list">
                <?php if (!empty($cartItems)) : ?>
                <?php foreach ($cartItems as $cartItem) : ?>
                <li>
                    <form action="/cart/remove-product" method="POST" class="products__item product">
                        <img class="product__img" src="<?php echo $_ENV['IMAGE_URL'] . $cartItem->product->image ?>"
                            alt="">
                        <h3 class="product__title"><?php echo $cartItem->product->title ?></h3>
                        <p class="product__descr"><?php echo $cartItem->product->description ?></p>
                        <input type="hidden" name="productId" value="<?php echo $cartItem->product->id ?>" required />
                        <span class="product__price">Total price: <?php echo $cartItem->totalPrice ?>$</span>
                        <span class="product__price">Amount: <?php echo $cartItem->amount ?></span>
                        <div class="product__bottom-wrapper">
                            <span class="product__price"><?php echo $cartItem->product->price ?>$</span>
                            <input type="submit" class="product__btn" value="Remove" />
                        </div>
                    </form>
                </li>
                <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
    </section>
</body>

</html>