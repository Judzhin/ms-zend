<?php

/**
 * Description of AssetGrabber
 *
 * @author jon
 */
class App_Controller_Plugin_AssetGrabber extends Zend_Controller_Plugin_Abstract {

    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request) {

        if ($request->getControllerName() != 'attach') {
            return;
        }

        $action = $request->getActionName();
        $directory = sprintf('%s/../public/uploads', APPLICATION_PATH);

        $transform = new Zend_Image_Transform(sprintf('%s/%s', $directory, $action), new Zend_Image_Driver_Gd);
        Zend_Debug::dump($transform);
        
        header("Content-type: image/jpeg");
        exit;
    }

}