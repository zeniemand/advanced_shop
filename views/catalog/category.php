<?php include ROOT . '/views/layouts/header.php'; ?>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div class="left-sidebar">
                        <h2>Каталог</h2>
                        <div class="panel-group category-products">

                            <?php foreach ($categories as $category): ?>

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a href="/category/<?= $category['id']; ?>" class="<?= ($categoryId == $category['id']) ? 'active' : '' ?>" >
                                                <?= $category['name']; ?>
                                            </a>
                                        </h4>
                                    </div>
                                </div>

                            <?php endforeach; ?>

                        </div>

                    </div>
                </div>

                <div class="col-sm-9 padding-right">
                    <div class="features_items"><!--features_items-->
                        <h2 class="title text-center">Последние товары</h2>
                        <?php foreach ($categoryProducts as $categoryProduct): ?>

                            <div class="col-sm-4">
                                <div class="product-image-wrapper">
                                    <div class="single-products">
                                        <div class="productinfo text-center">

                                            <?php if(file_exists( ROOT . '/template/images/home/product'. $categoryProduct['image_id'] .'.jpg')): ?>

                                                <img src="/template/images/home/product<?= $categoryProduct['image_id'] ?>.jpg" alt="" />

                                            <?php else: ?>

                                                <!--<img src="/template/images/home/product_default.jpg" alt="" />-->

                                                <img src="<?= Product::getImage($categoryProduct['id']); ?>" alt="" />

                                            <?php endif; ?>
                                            <h2><?= $categoryProduct['price']; ?> $</h2>
                                            <p>
                                                <a href="/product/<?= $categoryProduct['id']; ?>">
                                                    ID: <?= $categoryProduct['id'] ?> <?= $categoryProduct['name']; ?>
                                                </a>
                                            </p>
                                            <a href="/cart/add/<?= $categoryProduct['id']; ?>" data-id="<?=$categoryProduct['id']; ?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>В корзину</a>
                                        </div>
                                        <?php if($categoryProduct['is_new']): ?>
                                            <img src="/template/images/home/new.png" class="new" alt="new">
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                        <?php endforeach; ?>

                        <!-- Постраничная навигация -->
                        <?= $pagination->get(); ?>

                    </div><!--features_items-->



                </div>
            </div>
        </div>
    </section>

<?php include ROOT . '/views/layouts/footer.php'; ?>