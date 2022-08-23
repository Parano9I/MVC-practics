<body>
    <section class="products">
        <div class="container">
            <h1 class="products__title">Products</h1>
            <div class="search">
                <input type="text" name="searchStr" class="search__input"
                    value="<?php echo empty($searchStr) ? '' : $searchStr ?>" />
                <input type="submit" class="search__btn button" value="Search" />
            </div>
            <ul class="products__list">
                <?php if (!empty($products)) : ?>
                <?php foreach ($products as $product) : ?>
                <li>
                    <form action=" /cart/add-product" method="post" class="products__item product">
                        <img class="product__img" src="<?php echo $_ENV['IMAGE_URL'] . $product->image ?>" alt="">
                        <h3 class="product__title"><?php echo $product->title ?></h3>
                        <p class="product__descr"><?php echo $product->description ?></p>
                        <input type="hidden" name="productId" value="<?php echo $product->id ?>" required />
                        <h3 class="product__title"><?php echo ucfirst($product->category->name) ?></h3>
                        <div class="product__bottom-wrapper">
                            <span class="product__price"><?php echo $product->price ?>$</span>
                            <input type="number" class="product__amount" name="amount" value="1" required />
                            <input type="submit" class="product__btn button" value="Add to cart"
                                <?php echo $product->isAddedToCart ? 'disabled' : '' ?> />
                        </div>
                    </form>
                </li>
                <?php endforeach; ?>
                <?php endif; ?>
            </ul>
            </form>
        </div>
    </section>
</body>
<script src="/js/index.js"></script>

</html>