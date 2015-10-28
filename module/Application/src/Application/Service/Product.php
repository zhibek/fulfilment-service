<?php

namespace Application\Service;

class Product
{

    private $categories = [
        'Men>Sport',
        'Men>Music',
        'Men>Art',
        'Women>Sport',
        'Women>Music',
        'Women>Art',
        'Children>Sport',
        'Children>Music',
        'Children>Art',
    ];

    private $products = [
        "Real Madrid Men's Casual" => [ 0 ],
        "Real Madrid Men's Tennis" => [ 0 ],
        "Barcelona Men's Casual" => [ 0 ],
        "Barcelona Men's Tennis" => [ 0 ],
        "Ajax Men's Casual" => [ 0 ],
        "Ajax Men's Tennis" => [ 0 ],
        "Ajax Men's Baggy" => [ 0 ],
        "Arsenal Men's Casual" => [ 0 ],
        "Arsenal Men's Tennis" => [ 0 ],
        "Chelsea Men's Casual" => [ 0 ],
        "Chelsea Men's Tennis" => [ 0 ],
        "Liverpool Men's Casual" => [ 0 ],
        "Liverpool Men's Tennis" => [ 0 ],
        "Liverpool Men's Baggy" => [ 0 ],

        "Real Madrid Women's Casual" => [ 3 ],
        "Barcelona Women's Casual" => [ 3 ],
        "Ajax Women's Casual" => [ 3 ],
        "Ajax Women's Baggy" => [ 3 ],
        "Arsenal Women's Casual" => [ 3 ],
        "Chelsea Women's Casual" => [ 3 ],
        "Liverpool Women's Casual" => [ 3 ],
        "Liverpool Women's Baggy" => [ 3 ],

        "Real Madrid Children's Casual" => [ 6 ],
        "Real Madrid Children's Official" => [ 6 ],
        "Barcelona Children's Casual" => [ 6 ],
        "Barcelona Children's Official" => [ 6 ],
        "Ajax Children's Casual" => [ 6 ],
        "Ajax Children's Official" => [ 6 ],
        "Ajax Children's Pyjama" => [ 6 ],
        "Arsenal Children's Casual" => [ 6 ],
        "Arsenal Children's Official" => [ 6 ],
        "Chelsea Children's Casual" => [ 6 ],
        "Chelsea Children's Official" => [ 6 ],
        "Liverpool Children's Casual" => [ 6 ],
        "Liverpool Children's Official" => [ 6 ],
        "Liverpool Children's Pyjama" => [ 6 ],
    ];

    private $productBrands = [
        'Nike',
        'Adidas',
        'Gap',
        'Uniqlo',
        'Independent',
    ];

    private $productPrices = [
        4.99,
        9.99,
        14.99,
        19.99,
    ];

    private $variantColours = [
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
    ];

    private $variantSizes = [
        'XS',
        'S',
        'M',
        'L',
        'XL',
    ];

    public function getData()
    {
        $products = [];

        $productCounter = 0;

        foreach ($this->products as $title => $categories) {

            $code = 10000 + $productCounter + 1;
            $description = sprintf('Full description for "%s" coming soon...', $title);
            $brand = $this->productBrands[($productCounter % count($this->productBrands))];
            $price = $this->productPrices[($productCounter % count($this->productPrices))];
            foreach ($categories as &$category) {
                $category = $this->categories[$category];
            }

            $product = [
                'code' => $code,
                'title' => $title,
                'description' => $description,
                'brand' => $brand,
                'fabric_care' => null,
                'price' => $price,
                'categories' => $categories,
            ];

            $colourMode = $productCounter % 5;
            $colourValues = [];
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
                    $sizeValues = [ &$this->variantSizes[2] ];
                break;

                case 1:
                    $sizeValues = [ &$this->variantSizes[1], &$this->variantSizes[2], &$this->variantSizes[3] ];
                break;

                case 2:
                    $sizeValues = $this->variantSizes;
                break;

            }

            $variants = [];

            foreach ($colourValues as $colour => $primaryColour) {

                foreach ($sizeValues as $size) {

                    $colourCode = preg_replace('/[^a-z,0-9]*/', '', strtolower($colour));
                    $sizeCode = strtolower($size);

                    $sku = implode('-', [
                        $code,
                        $colourCode,
                        $sizeCode,
                    ]);

                    $variants[] = [
                        'sku' => $sku,
                        'colour' => $colour,
                        'primary_colour' => $primaryColour,
                        'size' => $size,
                        'image' => null,
                    ];

                }

            }

            $product['variants'] = $variants;

            $products[] = $product;

            $productCounter++;

        }

        return ['products' => $products];
    }

}
