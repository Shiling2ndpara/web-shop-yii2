<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;

$this->params['breadcrumbs'][] = ['label' => 'Каталог товаров', 'url' => ['/catalog']];
foreach ($fullPath as $path) {
    $this->params['breadcrumbs'][] = ['label' => $path->name, 'url' => ["/catalog/category/$path->category_id"]];
}

$this->registerJs("
    function addproduct(productid) {
        $.ajax({
            type: 'POST',
            url: '/products/addproduct/',
            data: {id: productid},
             success: function(data) {
                if (JSON.parse(data) !== 'nok') {
                    $('#cartcounter').text('Корзина ('+JSON.parse(data)+')');
                }
            }
        });
    }", \yii\web\View::POS_END);
?>
Фильтр товаров по брендам:<br>
<div class="filter">
    <div>
        <?php
        $form = ActiveForm::begin([
                    'id' => 'active-form',
                    'options' => [
                        'class' => 'form-horizontal',
                        'enctype' => 'multipart/form-data',
                        'name' => 'brandsfilter',
                    ],
                    'fieldConfig' => [
                        'template' => "{input}\n{label}\n{hint}\n{error}",
                    ]
        ]);
        ?>

        <?php foreach ($brands as $attr => $item): ?>

            <?= $form->field($filtermodel, $attr)->checkbox(['label' => $item, 'name' => $attr]) ?>

        <?php endforeach; ?>

        <div class="form-group">
            <?php // Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'name' => 'filter_submit']) ?>
            <?= Html::submitInput('Фильтровать', ['class' => 'btn btn-primary', 'name' => 'filter_submit']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

<div class="content">
    <div class="categories" style="overflow: hidden">
        <div>подкатегории категории "<?= $path->name ?>": </div>
        <?php foreach ($subcategories as $category): ?>
            <div class="category">
                <div align="center">
                    <img src="http://dummyimage.com/70x70/fafafa/3ea1ec" alt="..." class="img-thumbnail">
                </div>
                подкатегория <?= $category['category_id'] ?> - <?= Html::a($category['name'], ['/catalog/category/', 'id' => $category['category_id']]) ?>
                <br> количество товаров ( <?= $category['quantity_visible'] ?> ) ( <?= $category['quantity_invisible'] ?> )
            </div>
        <?php endforeach; ?>
    </div>
    <div class="products">
        <div>товары категории "<?= $path->name ?>":</div>

        <?php foreach ($products as $product): ?>
            <div class="product">
                <img src="http://dummyimage.com/150x100/fafafa/3ea1ec" alt="..." class="img-thumbnail" style="float: left">
                <div>Название товара:
                    <b> <?= Html::a($product['title'], ['/products/', 'id' => $product['product_id']], ['target' => '_blank', ]) ?> </b>
                </div>
                <div>Бренд:
                    <?= Html::encode($product['brand_name']) ?>
                </div>
                <div>Описание:
                    <?= Html::encode($product['description']) ?>
                </div>
                <div>
                    цена: <?= Html::encode($product['price']) ?> (специальная цена: <?= Html::encode($product['special_price']) ?>)
                    <input type="button" value="Купить" id="addproduct" onclick="addproduct(<?= $product['product_id'] ?>)">
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="clear"></div>

    <?= LinkPager::widget(['pagination' => $pagination]) ?>
</div>