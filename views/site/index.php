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
                                    <a href="/category/<?= $category['id']; ?>">
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
                    <?php foreach ($latestProducts as $latestProduct): ?>

                    <div class="col-sm-4">
                        <div class="product-image-wrapper">
                            <div class="single-products">
                                <div class="productinfo text-center">

                                   <!-- <?php /*if(file_exists( ROOT . '/template/images/home/product'. $latestProduct['image_id'] .'.jpg')): */?>

                                        <img src="/template/images/home/product<?/*= $latestProduct['image_id'] */?>.jpg" alt="" />

                                    --><?php /*else: */?>

                                        <!--<img src="/template/images/home/product_default.jpg" alt="" />-->

                                    <img src="<?= Product::getImage($latestProduct['id']); ?>" alt="" />

                                    <?php /*endif; */?>
                                    <h2><?= $latestProduct['price']; ?> $</h2>
                                    <p>
                                        <a href="/product/<?= $latestProduct['id']; ?>">
                                            <?= $latestProduct['name']; ?>
                                        </a>
                                    </p>
                                    <a href="/cart/add/<?= $latestProduct['id']; ?>" data-id="<?=$latestProduct['id']; ?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>В корзину</a>
                                </div>
                                <?php if($latestProduct['is_new']): ?>
                                <img src="/template/images/home/new.png" class="new" alt="new">
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <?php endforeach; ?>


                </div><!--features_items-->

                <div class="recommended_items"><!--recommended_items-->

                    <h2 class="title text-center">Рекомендуемые товары</h2>
<?php //dd($sliderProducts);?>
                    <div class="cycle-slideshow"
                         data-cycle-fx=carousel
                         data-cycle-timeout=5000
                         data-cycle-carousel-visible=3
                         data-cycle-carousel-fluid=true
                         data-cycle-slides="div.item"
                         data-cycle-prev="#prev"
                         data-cycle-next="#next"
                    >
                        <?php foreach ($sliderProducts as $sliderItem): ?>
                            <div class="item">
                                <div class="product-image-wrapper">
                                    <div class="single-products">
                                        <div class="productinfo text-center">
                                            <?php if(file_exists( ROOT . '/template/images/home/product'. $latestProduct['image_id'] .'.jpg')): ?>

                                                <img src="/template/images/home/product<?= $latestProduct['image_id'] ?>.jpg" alt="" />

                                            <?php else: ?>

                                               <!-- <img src="/template/images/home/product_default.jpg" alt="" />-->
                                                <img src="<?= Product::getImage($latestProduct['id']); ?>" alt="" />
                                            <?php endif; ?>
                                            <h2>$<?= $sliderItem['price']; ?></h2>
                                            <?php //dd($sliderItem);?>
                                            <a href="/product/<?= $sliderItem['id']; ?>">
                                                <?= $sliderItem['name']; ?>
                                            </a>
                                            <br/><br/>
                                            <a href="/cart/add/<?= $sliderItem['id']; ?>" class="btn btn-default add-to-cart" data-id="<?= $sliderItem['id']; ?>"><i class="fa fa-shopping-cart"></i>В корзину</a>
                                        </div>
                                        <?php if ($sliderItem['is_new']): ?>
                                            <img src="/template/images/home/new.png" class="new" alt="" />
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <a class="left recommended-item-control" id="prev" href="#recommended-item-carousel" data-slide="prev">
                        <i class="fa fa-angle-left"></i>
                    </a>
                    <a class="right recommended-item-control" id="next"  href="#recommended-item-carousel" data-slide="next">
                        <i class="fa fa-angle-right"></i>
                    </a>
                </div><!--/recommended_items-->

            </div>
        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer.php'; ?>