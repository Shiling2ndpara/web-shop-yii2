<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use app\models\Products;
use app\models\Categories;
use yii\helpers\ArrayHelper;

class ProductsController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionAdd()
    {
        $products = (new Products)->loadDefaultValues();

        if ($products->load(Yii::$app->request->post()) && $products->validate()) {
            $res = $products->save();
            $productParams = ArrayHelper::toArray($products);
            Categories::setCategoriesCounters($productParams['category_id'], $productParams['status'], (1 - $productParams['status']));
            return $this->redirect('/admin/products/edit/' . $products->product_id);
        } else {
            return $this->render('add', ['model' => $products, 'type' => 'add']);
        }
    }

    public function actionEdit($id)
    {
        $products = Products::find()
                ->where(['product_id' => $id])
                ->one();

        if ($products->load(Yii::$app->request->post()) && $products->validate()) {
            $results = $products->save();
            return $this->render('edit', ['model' => $products, 'type' => 'create', 'result' => $results]);
        } else {
            return $this->render('edit', ['model' => $products, 'type' => 'edit',]);
        }
    }

    public function actionDelete($id)
    {
        if (Products::deleteAll(['product_id' => $id])) {
            return $this->redirect('/admin/products');
        }
    }

}