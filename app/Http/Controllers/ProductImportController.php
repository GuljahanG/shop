<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
use Illuminate\Http\Request;
use \App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;
use \App\Models\Product;
use \App\Models\Attribute;

class ProductImportController extends Controller
{

    public function import(Request $request){

        $rows = Excel::toArray(new ProductsImport(), $request->file);

        foreach ($rows[0] as $key => $data) {
            if($key == 0){
                $productKeys = $this->getProductKeys($data);
                $attributeKeys = $this->getAttributeKeys($data);
                $imagesKeys = $this->getImagesKeys($data);
            }else{
                //check if product exist
                if($productKeys['externalCodeKey'] && $productKeys['sellerKey']){
                    $existProduct = $this->checkForExistProduct($data[$productKeys['externalCodeKey']], $data[$productKeys['sellerKey']]);
                    if(!$existProduct){
                        //create product
                        $product = $this->createProduct($data, $productKeys);
                        //create attributes
                        $this->createAttribute($product->id, 'Размер', $attributeKeys['sizeKey'] ? $data[$attributeKeys['sizeKey']] : null);
                        $this->createAttribute($product->id, 'Цвет', $attributeKeys['colorKey'] ? $data[$attributeKeys['colorKey']] : null);
                        $this->createAttribute($product->id, 'Бренд', $attributeKeys['brandKey'] ? $data[$attributeKeys['brandKey']] : null);
                        $this->createAttribute($product->id, 'Состав', $attributeKeys['compoundKey'] ? $data[$attributeKeys['compoundKey']] : null);
                        //create images
                        $this->createProductImage($product->id, $imagesKeys['imageKey'] ? $data[$imagesKeys['imageKey']] :null);

                    }
                }
            }
        }
        return redirect()->route('home');
    }
    //getColumnsKey
    public function getProductKeys($data){

        $productKeys['nameKey'] = $this->findColumn("Наименование", $data);
        $productKeys['priceKey'] = $this->findColumn("Цена: Цена продажи", $data);
        $productKeys['discountKey'] = $this->findColumn("Минимальная цена", $data);
        $productKeys['descriptionKey'] = $this->findColumn("Описание", $data);
        $productKeys['typeKey'] = $this->findColumn("Тип", $data);
        $productKeys['externalCodeKey'] = $this->findColumn("Внешний код", $data);
        $productKeys['barcodeKey'] = $this->findColumn("Штрихкод EAN13", $data);
        $productKeys['sellerKey'] = $this->findColumn("Поставщик", $data);
        return $productKeys;

    }

    public function getAttributeKeys($data){
        $attributeKeys['sizeKey'] = $this->findColumn("Доп. поле: Размер", $data);
        $attributeKeys['colorKey'] = $this->findColumn("Доп. поле: Цвет", $data);
        $attributeKeys['brandKey'] =  $this->findColumn("Доп. поле: Бренд", $data);
        $attributeKeys['compoundKey'] = $this->findColumn("Доп. поле: Состав", $data);

        return $attributeKeys;
    }

    public function getImagesKeys($data){
        $imagesKeys['imageKey'] = $this->findColumn("Доп. поле: Ссылки на фото", $data);
        return $imagesKeys;
    }

    public function findColumn($column, $data){

        $key = array_search($column, $data);
        if ($key !== false) {
            return $key;
        }
    }
    //check if product exist
    public function checkForExistProduct($external_code, $seller){
        $product = Product::where('external_code', $external_code)->where('seller', $seller)->first();
        if($product)
            return true;
        else return false;
    }

    //store
    public function createProduct($data, $productKeys){

        $product = Product::create([
            'name' => $productKeys['nameKey'] ? $data[$productKeys['nameKey']] : null,
            'price' => $productKeys['priceKey'] ? (double)$data[$productKeys['priceKey']] : null,
            'discount' => $productKeys['discountKey'] ? (double)$data[$productKeys['discountKey']] : null,
            'description' => $productKeys['descriptionKey'] ? $data[$productKeys['descriptionKey']] : null,
            'type' => $productKeys['typeKey'] ? $data[$productKeys['typeKey']] : null,
            'external_code' => $productKeys['externalCodeKey'] ? $data[$productKeys['externalCodeKey']] : null,
            'barcode' => $productKeys['barcodeKey'] ? $data[$productKeys['barcodeKey']] : null,
            'seller' => $productKeys['sellerKey'] ? $data[$productKeys['sellerKey']] : null
        ]);
        return $product;
    }

    public function createAttribute($product_id, $key, $value){

        Attribute::create([
            'product_id' => $product_id,
            'key' => $key,
            'value' => $value
        ]);
    }

    public function createProductImage($product_id, $images){
        $imagesData = explode(',', $images);
        if(count($imagesData)>0){
            foreach($imagesData as $image)
            ProductImage::create([
                'product_id'=> $product_id,
                'path' => $image
            ]);
        }
    }
}
