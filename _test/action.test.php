<?php
/*
 * Copyright (c) 2016 Mark C. Prins <mprins@users.sf.net>
 *
 * Permission to use, copy, modify, and distribute this software for any
 * purpose with or without fee is hereby granted, provided that the above
 * copyright notice and this permission notice appear in all copies.
 *
 * THE SOFTWARE IS PROVIDED "AS IS" AND THE AUTHOR DISCLAIMS ALL WARRANTIES
 * WITH REGARD TO THIS SOFTWARE INCLUDING ALL IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR
 * ANY SPECIAL, DIRECT, INDIRECT, OR CONSEQUENTIAL DAMAGES OR ANY DAMAGES
 * WHATSOEVER RESULTING FROM LOSS OF USE, DATA OR PROFITS, WHETHER IN AN
 * ACTION OF CONTRACT, NEGLIGENCE OR OTHER TORTIOUS ACTION, ARISING OUT OF
 * OR IN CONNECTION WITH THE USE OR PERFORMANCE OF THIS SOFTWARE.
 */

/**
 * Action tests for the webmaster plugin.
 *
 * @group plugin_webmaster
 * @group plugins
 */
class action_plugin_webmaster_test extends DokuWikiTest {

    protected $pluginsEnabled = array('webmaster');

    public function setUp(): void {
        global $conf;

        parent::setUp();

        $conf ['plugin']['webmaster']['webmaster_google']       = 'webmaster_google';
        $conf ['plugin']['webmaster']['webmaster_bing']         = 'webmaster_bing';
        $conf ['plugin']['webmaster']['webmaster_yandexkey']    = 'webmaster_yandexkey';
        $conf ['plugin']['webmaster']['webmaster_pinterestkey'] = 'webmaster_pinterestkey';
    }

    public function testHeaders(): void {
        $request  = new TestRequest();
        $response = $request->get(array('id' => 'wiki:dokuwiki'), '/doku.php');

        $this->assertNotFalse(
            strpos($response->getContent(), 'DokuWiki'), 'DokuWiki was not a word in the output'
        );

        // check webmaster meta headers
        $this->assertEquals(
            'webmaster_google',
            $response->queryHTML('meta[name="google-site-verification"]')->attr('content')
        );
        $this->assertEquals(
            'webmaster_bing',
            $response->queryHTML('meta[name="msvalidate.01"]')->attr('content')
        );
        $this->assertEquals(
            'webmaster_yandexkey',
            $response->queryHTML('meta[name="yandex-verification"]')->attr('content')
        );
        $this->assertEquals(
            'webmaster_pinterestkey',
            $response->queryHTML('meta[name="p:domain_verify"]')->attr('content')
        );
    }
}
