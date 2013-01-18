<?php

class ConfigController extends LSYii_Controller {

    public function __construct($id, $module = null)
    {
        parent::__construct($id, $module);
    }

    public function init()
    {
        parent::init();
        $this->_sessioncontrol();
        Yii::app()->setConfig('adminimageurl', Yii::app()->getConfig('styleurl') . Yii::app()->getConfig('admintheme') . '/images/');
        Yii::app()->setConfig('adminstyleurl', Yii::app()->getConfig('styleurl') . Yii::app()->getConfig('admintheme') . '/');
    }

    /**
     * Load and set session vars
     * (copied from admincontroller)
     *
     * @access protected
     * @return void
     */
    protected function _sessioncontrol()
    {
        Yii::import('application.libraries.Limesurvey_lang');
        // From personal settings
        if (Yii::app()->request->getPost('action') == 'savepersonalsettings')
        {
            if (Yii::app()->request->getPost('lang') == 'auto')
            {
                $sLanguage = getBrowserLanguage();
            } else
            {
                $sLanguage                       = Yii::app()->request->getPost('lang');
            }
            Yii::app()->session['adminlang'] = $sLanguage;
        }

        if (empty(Yii::app()->session['adminlang']))
            Yii::app()->session["adminlang"] = Yii::app()->getConfig("defaultlang");

        Yii::app()->setLang(new Limesurvey_lang(Yii::app()->session['adminlang']));

        if (!empty($this->user_id))
            $this->_GetSessionUserRights($this->user_id);
    }

    public function actionScript()
    {
        // Retrieve config options that should be available in JS.
        $configOptions = array(
            //    'DBVersion'
            'adminimageurl'
        );
        $data = array();

        foreach ($configOptions as $option) {
            $data[$option]         = Yii::app()->getConfig($option);
        }
        $data['baseUrl']       = Yii::app()->getBaseUrl(true);
        $data['layoutPath']    = Yii::app()->getLayoutPath();
        $data['adminImageUrl'] = Yii::app()->getConfig('adminimageurl');

        $this->layout = false;
        $this->render('/js', compact('data'));
    }

    public function beforeRender($view)
    {
        return parent::beforeRender($view);
    }

    

   
}