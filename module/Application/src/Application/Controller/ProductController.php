<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Application\Service\Product;

class ProductController extends AbstractActionController
{

    public function indexAction()
    {
        $productService = $this->getServiceLocator()->get('Application\Service\Product');

        $data = $productService->getData();

        return new JsonModel($data);
    }

}
