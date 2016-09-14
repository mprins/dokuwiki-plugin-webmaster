<?php
/**
 * Webmaster Tools plugin.
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Mark C. Prins <mprins@users.sf.net>
 * @author     Marius Rieder <marius.rieder@durchmesser.ch>
 */
if (!defined('DOKU_INC')) {
    die();
}
if (!defined('DOKU_PLUGIN')) {
    define('DOKU_PLUGIN', DOKU_INC.'lib/plugins/');
}
require_once(DOKU_PLUGIN.'action.php');

class action_plugin_webmaster extends DokuWiki_Action_Plugin {

    public function register(Doku_Event_Handler $controller) {
        $controller->register_hook('TPL_METAHEADER_OUTPUT', 'BEFORE', $this, 'addVerifyHeaders', array());
    }

    public function addVerifyHeaders(Doku_Event $event, $param) {
        if (empty($event->data)||empty($event->data['meta'])) {
            return;
        }

        /* Google */
        $g = $this->getConf('webmaster_google');
        if (!empty($g)) {
            $g = array('name' => 'google-site-verification', 'content' => $g);
            $event->data['meta'][] = $g;
        }

        /* bing */
        $b = $this->getConf('webmaster_bing');
        if (!empty($b)) {
            $b = array('name' => 'msvalidate.01', 'content' => $b);
            $event->data['meta'][] = $b;
        }

        /* Yandex */
        $y = $this->getConf('webmaster_yandexkey');
        if (!empty($y)) {
            $y = array('name' => 'yandex-verification', 'content' => $y);
            $event->data['meta'][] = $y;
        }
    }
}
