<?php

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

define('DROPPED_ITEMS_NOTICER_HEADER', TEMPLATE_REALDIR . 'dropped_item_noticer/mail/header.tpl');
define('DROPPED_ITEMS_NOTICER_CONTENTS', TEMPLATE_REALDIR . 'dropped_item_noticer/mail/contents.tpl');
define('DROPPED_ITEMS_NOTICER_FOOTER', TEMPLATE_REALDIR . 'dropped_item_noticer/mail/footer.tpl');

/**
 * プラグインのメインクラス
 */
class FixMdlPaypalExpress extends SC_Plugin_Base
{
    public function install($arrPlugin, SC_Plugin_Installer $objPluginInstaller = null)
    {
    }

    public function uninstall($arrPlugin, SC_Plugin_Installer $objPluginInstaller = null)
    {
    }

    public function enable($arrPlugin, SC_Plugin_Installer $objPluginInstaller = null)
    {
    }

    public function disable($arrPlugin, SC_Plugin_Installer $objPluginInstaller = null)
    {
    }

    /**
     * 処理の介入箇所とコールバック関数を設定
     * registerはプラグインインスタンス生成時に実行されます
     *
     * @param SC_Helper_Plugin $objHelperPlugin
     * @param int $priority
     */
    public function register(SC_Helper_Plugin $objHelperPlugin, $priority)
    {
        parent::register($objHelperPlugin, $priority);

        $objHelperPlugin->addAction('LC_Page_process', array($this, 'LC_Page_process'), $priority);
    }

    public function LC_Page_process(LC_Page $objPage)
    {
        if (strpos($objPage->tpl_mainpage, MODULE_REALDIR . MDL_PAYPAL_EXPRESS_CODE) === 0) {
            switch(SC_Display_Ex::detectDevice()) {
                case DEVICE_TYPE_MOBILE :
                    break;
                case DEVICE_TYPE_SMARTPHONE :
                    $file = str_replace(
                        MODULE_REALDIR . MDL_PAYPAL_EXPRESS_CODE . '/',
                        'mdl_paypal_express/',
                        $objPage->tpl_mainpage
                    );
                    if (file_exists(SMARTPHONE_TEMPLATE_REALDIR . '/' . $file)) {
                        $objPage->tpl_mainpage = $file;
                    }
                    break;
                case DEVICE_TYPE_PC :
                default:
                    $file = str_replace(
                        MODULE_REALDIR . MDL_PAYPAL_EXPRESS_CODE . '/',
                        'mdl_paypal_express/',
                        $objPage->tpl_mainpage
                    );
                    if (file_exists(TEMPLATE_REALDIR . '/' . $file)) {
                        $objPage->tpl_mainpage = $file;
                    }
                    break;
            }
        }
    }
}
