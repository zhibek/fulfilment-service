<?php

namespace Application\Service;

class Product
{

    private $categories = array(
        'Men>Sport',
        'Men>Music',
        'Men>Art',
        'Women>Sport',
        'Women>Music',
        'Women>Art',
        'Children>Sport',
        'Children>Music',
        'Children>Art',
    );

    private $products = array(
        "Real Madrid Men's Casual" => array( 0 ),
        "Real Madrid Men's Tennis" => array( 0 ),
        "Barcelona Men's Casual" => array( 0 ),
        "Barcelona Men's Tennis" => array( 0 ),
        "Ajax Men's Casual" => array( 0 ),
        "Ajax Men's Tennis" => array( 0 ),
        "Ajax Men's Baggy" => array( 0 ),
        "Arsenal Men's Casual" => array( 0 ),
        "Arsenal Men's Tennis" => array( 0 ),
        "Chelsea Men's Casual" => array( 0 ),
        "Chelsea Men's Tennis" => array( 0 ),
        "Liverpool Men's Casual" => array( 0 ),
        "Liverpool Men's Tennis" => array( 0 ),
        "Liverpool Men's Baggy" => array( 0 ),

        "Real Madrid Women's Casual" => array( 3 ),
        "Barcelona Women's Casual" => array( 3 ),
        "Ajax Women's Casual" => array( 3 ),
        "Ajax Women's Baggy" => array( 3 ),
        "Arsenal Women's Casual" => array( 3 ),
        "Chelsea Women's Casual" => array( 3 ),
        "Liverpool Women's Casual" => array( 3 ),
        "Liverpool Women's Baggy" => array( 3 ),

        "Real Madrid Children's Casual" => array( 6 ),
        "Real Madrid Children's Official" => array( 6 ),
        "Barcelona Children's Casual" => array( 6 ),
        "Barcelona Children's Official" => array( 6 ),
        "Ajax Children's Casual" => array( 6 ),
        "Ajax Children's Official" => array( 6 ),
        "Ajax Children's Pyjama" => array( 6 ),
        "Arsenal Children's Casual" => array( 6 ),
        "Arsenal Children's Official" => array( 6 ),
        "Chelsea Children's Casual" => array( 6 ),
        "Chelsea Children's Official" => array( 6 ),
        "Liverpool Children's Casual" => array( 6 ),
        "Liverpool Children's Official" => array( 6 ),
        "Liverpool Children's Pyjama" => array( 6 ),
    );

    private $productBrands = array(
        'Nike',
        'Adidas',
        'Gap',
        'Uniqlo',
        'Independent',
    );

    private $productPrices = array(
        4.99,
        9.99,
        14.99,
        19.99,
    );

    private $variantColours = array(
        'Bright White' => 'white',
        'Off White' => 'white',
        'Pure Black' => 'black',
        'Dark Charcoal' => 'black',
        'Light Grey' => 'grey',
        'Dark Grey' => 'grey',
        'Bright Red' => 'red',
        'Maroon' => 'red',
        'Lime Green' => 'green',
        'Turquoise' => 'green',
        'Royal Blue' => 'blue',
        'Sky Blue' => 'blue',
    );

    private $variantSizes = array(
        'XS',
        'S',
        'M',
        'L',
        'XL',
    );

    public function getData()
    {
        $products = array();

        $productCounter = 0;

        foreach ($this->products as $title => $categories) {

            $code = 10000 + $productCounter + 1;
            $description = sprintf('Full description for "%s" coming soon...', $title);
            $brand = $this->productBrands[($productCounter % count($this->productBrands))];
            $price = $this->productPrices[($productCounter % count($this->productPrices))];
            foreach ($categories as &$category) {
                $category = $this->categories[$category];
            }

            $product = array(
                'code' => $code,
                'title' => $title,
                'description' => $description,
                'brand' => $brand,
                'fabric_care' => null,
                'price' => $price,
                'categories' => $categories,
            );

            $colourMode = $productCounter % 5;
            $colourValues = array();
            $variantColourKeys = array_keys($this->variantColours);
            $colourCounter = 0;
            for ($colourSetup=0; $colourSetup <= $colourMode; $colourSetup++) {
                $colourPick = $variantColourKeys[((($productCounter)+$colourCounter*2) % count($variantColourKeys))];
                $colourValues[$colourPick] = $this->variantColours[$colourPick];
                $colourCounter++;
            }

            $sizeMode = $productCounter % 3;
            switch ($sizeMode) {

                case 0:
                    $sizeValues = array( &$this->variantSizes[2] );
                break;

                case 1:
                    $sizeValues = array( &$this->variantSizes[1], &$this->variantSizes[2], &$this->variantSizes[3] );
                break;

                case 2:
                    $sizeValues = $this->variantSizes;
                break;

            }

            $variants = array();

            foreach ($colourValues as $colour => $primaryColour) {

                foreach ($sizeValues as $size) {

                    $colourCode = preg_replace('/[^a-z,0-9]*/', '', strtolower($colour));
                    $sizeCode = strtolower($size);

                    $sku = implode('-', array(
                        $code,
                        $colourCode,
                        $sizeCode,
                    ));

                    $variants[] = array(
                        'sku' => $sku,
                        'colour' => $colour,
                        'primary_colour' => $primaryColour,
                        'size' => $size,
                        'image' => null,
                    );

                }

            }

            $product['variants'] = $variants;

            $products[] = $product;

            $productCounter++;

        }

        return array('products' => $products);
    }

}
