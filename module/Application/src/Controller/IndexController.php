<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Services\Db;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $image = $this->getRequest()->getFiles()->get('image');
        $name = $this->getRequest()->getPost('name');
        $delete = $this->getRequest()->getQuery('delete');

        if ($image['tmp_name'] != null) {

            Db::inst()->getAdapter()->query('INSERT INTO image (name, data, type) VALUES (:name, :data, :type)', [
                'name' => $name,
                'data' => base64_encode(file_get_contents($image['tmp_name'])),
                'type' => $image['type']
            ]);
            return $this->redirect()->toRoute('home');
        }

        if ($delete !== null) {
            Db::inst()->getAdapter()->query('DELETE FROM image WHERE id = :id;', [
                'id' => $delete,
            ]);
            return $this->redirect()->toRoute('home');
        }

        $images = Db::inst()->getAdapter()->query('SELECT * FROM image')->execute();
        return new ViewModel([
            'images' => $images,
            'name' => $name,
        ]);
    }
}
