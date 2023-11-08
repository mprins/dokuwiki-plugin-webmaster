<?php

use dokuwiki\Extension\ActionPlugin;
use dokuwiki\Extension\EventHandler;
use dokuwiki\Extension\Event;

/**
 * Webmaster Tools plugin.
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Mark C. Prins <mprins@users.sf.net>
 * @author     Marius Rieder <marius.rieder@durchmesser.ch>
 */
class action_plugin_webmaster extends ActionPlugin
{
    public function register(EventHandler $controller)
    {
        $controller->register_hook('TPL_METAHEADER_OUTPUT', 'BEFORE', $this, 'addVerifyHeaders', []);
    }

    public function addVerifyHeaders(Event $event, $param)
    {
        if (empty($event->data) || empty($event->data['meta'])) {
            return;
        }

        /* Google */
        $g = $this->getConf('webmaster_google');
        if (!empty($g)) {
            $g                     = ['name' => 'google-site-verification', 'content' => $g];
            $event->data['meta'][] = $g;
        }

        /* bing */
        $b = $this->getConf('webmaster_bing');
        if (!empty($b)) {
            $b                     = ['name' => 'msvalidate.01', 'content' => $b];
            $event->data['meta'][] = $b;
        }

        /* Yandex */
        $y = $this->getConf('webmaster_yandexkey');
        if (!empty($y)) {
            $y                     = ['name' => 'yandex-verification', 'content' => $y];
            $event->data['meta'][] = $y;
        }

        /* Pinterest */
        $y = $this->getConf('webmaster_pinterestkey');
        if (!empty($y)) {
            $y                     = ['name' => 'p:domain_verify', 'content' => $y];
            $event->data['meta'][] = $y;
        }
    }
}
