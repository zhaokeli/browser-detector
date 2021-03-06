<?php

namespace ank\BrowserDetector;

use Jaybizzle\CrawlerDetect\CrawlerDetect;

class BrowserDetector implements DetectorInterface
{
    const FUNC_PREFIX = 'checkBrowser';

    /**
     * @var Browser
     */
    protected static $browser;

    protected static $browsersList
        = [
            // well-known, well-used
            // Special Notes:
            // (1) Opera must be checked before FireFox due to the odd
            //     user agents used in some older versions of Opera
            // (2) WebTV is strapped onto Internet Explorer so we must
            //     check for WebTV before IE
            // (3) Because of Internet Explorer 11 using
            //     "Mozilla/5.0 ([...] Trident/7.0; rv:11.0) like Gecko"
            //     as user agent, tests for IE must be run before any
            //     tests checking for "Mozilla"
            // (4) (deprecated) Galeon is based on Firefox and needs to be
            //     tested before Firefox is tested
            // (5) OmniWeb is based on Safari so OmniWeb check must occur
            //     before Safari
            // (6) Netscape 9+ is based on Firefox so Netscape checks
            //     before FireFox are necessary
            // (7) Microsoft Edge must be checked before Chrome and Safari
            // (7) Vivaldi must be checked before Chrome
            'RobotIP' => '百度蜘蛛',
            // common bots
            'Robot'   => '蜘蛛',

            'WebTv'                  => 'WebTv',
            'InternetExplorer'       => 'IE',
            'Edge'                   => 'Edge',
            'Opera'                  => 'Opera',
            'Vivaldi'                => 'Vivaldi',
            'Dragon'                 => 'Dragon',
            'Galeon'                 => 'Galeon',
            'NetscapeNavigator9Plus' => '网景',
            'SeaMonkey'              => 'SeaMonkey',
            'Firefox'                => '火狐',
            'Yandex'                 => 'Yandex',
            'BAIDU'                  => '百度',
            'UC'                     => 'UC',
            'QQ'                     => 'QQ',
            'LIEBAO'                 => '猎豹',
            //遨游
            'Maxthon'                => '遨游',
            'SouGou'                 => '搜狗',
            '2345Explorer'           => '2345',
            'MiuiBrowser'            => '小米',
            'baiduboxapp'            => '百度APP',
            'HuaWei'                 => '华为',
            'Samsung'                => '三星',
            'Oppo'                   => 'Oppo',
            //360安全
            '360SE'                  => '360安全',
            //360急速
            '360EE'                  => '360急速',
            'Vivo'                   => 'Vivo',
            //chrome内核的国内浏览器要放在它之前,只要里面带有chrome都要放它前面
            'Chrome'                 => '谷歌',
            'OmniWeb'                => 'OmniWeb',
            // common mobile
            'Android'                => '安卓',
            'BlackBerry'             => '黑莓',
            'Nokia'                  => '诺基亚',
            'Gsa'                    => 'Gsa',
            // WebKit base check (post mobile and others)
            'Safari'                 => 'Safari',
            // everyone else
            'NetPositive'            => 'NetPositive',
            'Firebird'               => '火鸟',
            'Konqueror'              => 'Konqueror',
            'Icab'                   => 'Icab',
            'Phoenix'                => 'Phoenix',
            'Amaya'                  => 'Amaya',
            'Lynx'                   => 'Lynx',
            'Shiretoko'              => 'Shiretoko',
            'IceCat'                 => 'IceCat',
            'Iceweasel'              => 'Iceweasel',
            'Mozilla'                => 'Mozilla',
            /* Mozilla is such an open standard that you must check it last */
        ];

    protected static $spiderIps
        = [
            [
                'title' => '360蜘蛛',
                'ips'   => [
                    '180.153.232.',
                    '180.153.234.',
                    '180.153.236.',
                    '180.163.220.',
                    '42.236.101.',
                    '42.236.102.',
                    '42.236.103.',
                    '42.236.10.',
                    '42.236.12.',
                    '42.236.13.',
                    '42.236.14.',
                    '42.236.15.',
                    '42.236.16.',
                    '42.236.17.',
                    '42.236.46.',
                    '42.236.48.',
                    '42.236.49.',
                    '42.236.50.',
                    '42.236.51.',
                    '42.236.52.',
                    '42.236.53.',
                    '42.236.54.',
                    '42.236.55.',
                    '42.236.99.',
                    '@^42\.224\.0\.[0-12]$@',
                    '@^180\.163\.128\.[0-17]$@',
                ],
            ],
            [
                'title' => '百度蜘蛛',
                'ips'   => [
                    '111.206.198.',
                    '111.206.221.',
                    '220.181.108.',
                    '123.125.71.',
                    '@^61\.135\.0\.[0-16]$@',
                    '@^123\.125\.0\.[0-16]$@',
                    '@^111\.206\.0\.[0-16]$@',
                    '@^180\.76\.0\.[0-20]$@',
                    '@^180\.149\.128\.[0-19]$@',
                    '@^220\.181\.0\.[0-16]$@',
                    '@^36\.110\.128\.[0-17]$@',
                    '@^124\.164\.0\.[0-14]$@',
                    '@^116\.179\.0\.[0-16]$@',
                    '@^180\.97\.0\.[0-18]$@',
                    '61.135.186.13',
                    '123.125.71.138',
                    '111.206.221.38',
                    '180.76.15.138',
                    '180.149.133.38',
                    '220.181.32.38',
                    '36.110.199.138',
                    '124.166.232.138',
                    '116.179.32.138',
                    '180.97.35.138',
                ],
            ],
            [
                'title' => '微软蜘蛛',
                'ips'   => [
                    //伊利诺伊芝加哥
                    '23.100.232.233',
                    '103.25.156.138',
                    '111.221.28.138',
                    '157.56.0.138',
                    '199.30.20.138',
                    '65.55.210.138',
                    '13.66.139.138',
                    '157.55.39.138',
                    '207.46.13.138',
                    '40.77.167.138',
                    '52.247.2.138',
                    '40.77.168.138',
                    '40.90.159.138',

                    '@^103\.25\.156\.[0-24]$@',
                    '@^111\.221\.16\.[0-20]$@',
                    '@^157\.56\.0\.[0-16]$@',
                    '@^199\.30\.16\.[0-20]$@',
                    '@^65\.52\.0\.[0-14]$@',
                    '@^13\.64\.0\.[0-11]$@',
                    '@^157\.55\.0\.[0-16]$@',
                    '@^207\.46\.0\.[0-16]$@',
                    '@^40\.64\.0\.[0-10]$@',
                    '@^52\.224\.0\.[0-11]$@',
                    '@^40\.76\.0\.[0-14]$@',
                    '@^40\.80\.0\.[0-12]$@',
                    '@^52\.160\.0\.[0-11]$@',
                ],
            ],
            [
                'title' => '神马蜘蛛',
                'ips'   => [
                    '@^42\.156\.128\.[0-17]$@',
                    '@^42\.120\.128\.[0-17]$@',
                    '@^106\.11\.144\.[0-20]$@',
                    '42.156.138.138',
                    '42.120.236.138',
                    '106.11.159.138',
                ],
            ],
            [
                'title' => '字节蜘蛛',
                'ips'   => [
                    '111.225.149.138',
                    '220.243.135.138',
                    '110.249.201.138',
                    '60.8.151.138',
                    '@^111\.224\.0\.[0-14]$@',
                    '@^220\.243\.128\.[0-18]$@',
                    '@^110\.240\.0\.[0-12]$@',
                    '@^60\.8\.0\.[0-15]$@',
                ],
            ],
            [
                'title' => '搜狗蜘蛛',
                'ips'   => [
                    '123.126.113.',
                    '123.126.68.127',
                    '106.38.241.102',
                    '106.120.188.157',
                    '106.120.188.141',
                    '@^123\.180\.0\.[0-14]$@',
                    '@^123\.125\.0\.[0-16]$@',
                    '@^61\.135\.0\.[0-16]$@',
                    '@^123\.126\.64\.[0-18]@$',
                    '@^111\.202\.0\.[0-16]$@',
                    '@^36\.110\.128\.[0-19]@$',
                    '@^220\.181\.0\.[0-16]$@',
                    '@^106\.120\.128\.[0-17]$@',
                    '@^49\.7\.0\.[0-18]$@',
                    '@^218\.30\.96\.[0-19]$@',
                    '@^106\.38\.0\.[0-16]$@',
                    '@^111\.13\.0\.[0-16]$@',
                    '@^58\.250\.0\.[0-16]$@',
                    '@^183\.36\.96\.[0-19]$@',
                    '@^49\.7\.64\.[0-18]$@',

                    '123.183.224.138',
                    '123.125.125.181',
                    '61.135.189.138',
                    '123.126.113.138',
                    '111.202.100.138',
                    '36.110.147.70',
                    '220.181.125.138',
                    '106.120.173.138',
                    '49.7.20.138',
                    '218.30.103.50',
                    '106.38.241.188',
                    '111.13.94.45',
                    '58.250.125.37',
                    '183.36.114.102',
                    '49.7.116.138',
                ],
            ],
        ];

    // protected static $baidu_ips = [];
    //正则里必须有两个分组,如果第二个值有值的话会被设置成蜘蛛名字
    protected static $spider_pattern
        = [
            ['/(BingPreview)\/([\.\d]+)/i', '必应蜘蛛'],
            ['/(Baiduspider\-render)\/([\.\d]+)/i', '百度蜘蛛'],
            ['/(Bytespider)/i', '字节蜘蛛'],
            ['/(spider)/i', '未知蜘蛛'],
        ];

    protected static $userAgentString;

    public static function checkBrowser2345Explorer($name, $title)
    {
        if (preg_match('/(Mb)?2345Explorer\/([\.\d]+)/i', self::$userAgentString, $mat)) {
            self::$browser->setName($title);
            self::$browser->setVersion($mat[2]);

            return true;
        }

        return false;
    }

    public static function checkBrowser360EE($name, $title)
    {
        if (stripos(self::$userAgentString, '360EE') !== false) {
            self::$browser->setName($title);
            if (preg_match('/Chrome\/([\.\d]+)/i', self::$userAgentString, $mat)) {
                self::$browser->setVersion($mat[1]);
            }
            else {
                self::$browser->setVersion('0');
            }

            return true;
        }

        return false;
    }

    public static function checkBrowser360SE($name, $title)
    {
        if (stripos(self::$userAgentString, '360SE') !== false) {
            self::$browser->setName($title);
            if (preg_match('/Chrome\/([\.\d]+)/i', self::$userAgentString, $mat)) {
                self::$browser->setVersion($mat[1]);
            }
            else {
                self::$browser->setVersion('0');
            }

            return true;
        }

        return false;
    }

    /**
     * Determine if the browser is Amaya.
     * @return bool
     */
    public static function checkBrowserAmaya($name, $title)
    {
        if (stripos(self::$userAgentString, 'amaya') !== false) {
            $aresult = explode('/', stristr(self::$userAgentString, 'Amaya'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                self::$browser->setVersion($aversion[0]);
            }
            self::$browser->setName($title);

            return true;
        }

        return false;
    }

    /**
     * Determine if the browser is Android.
     * @return bool
     */
    public static function checkBrowserAndroid($name, $title)
    {
        // Navigator
        if (stripos(self::$userAgentString, 'Android') !== false) {
            if (preg_match('/Version\/([\d\.]*)/i', self::$userAgentString, $matches)) {
                if (isset($matches[1])) {
                    self::$browser->setVersion($matches[1]);
                }
            }
            else {
                self::$browser->setVersion(Browser::VERSION_UNKNOWN);
            }
            self::$browser->setName($title);

            return true;
        }

        return false;
    }

    /* check baidu browser*/
    public static function checkBrowserBAIDU($name, $title)
    {
        if (stripos(self::$userAgentString, 'BIDUBrowser') !== false) {
            $aresult = explode('/', stristr(self::$userAgentString, 'BIDUBrowser'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                self::$browser->setVersion($aversion[0]);
            }
            self::$browser->setName($title);

            return true;
        }

        return false;
    }

    public static function checkBrowserBaiduBoxApp($name, $title)
    {
        if (preg_match('/baiduboxapp\/([\.\d]+)/i', self::$userAgentString, $mat)) {
            self::$browser->setName($title);
            self::$browser->setVersion($mat[1]);

            return true;
        }

        return false;
    }

    /**
     * Determine if the user is using a BlackBerry.
     * @return bool
     */
    public static function checkBrowserBlackBerry($name, $title)
    {
        if (stripos(self::$userAgentString, 'blackberry') !== false) {
            $aresult = explode('/', stristr(self::$userAgentString, 'BlackBerry'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                self::$browser->setVersion($aversion[0]);
            }
            self::$browser->setName($title);

            return true;
        }
        elseif (stripos(self::$userAgentString, 'BB10') !== false) {
            $aresult = explode('Version/10.', self::$userAgentString);
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                self::$browser->setVersion('10.' . $aversion[0]);
            }
            self::$browser->setName($title);

            return true;
        }

        return false;
    }

    /**
     * Determine if the browser is Chrome.
     * @return bool
     */
    public static function checkBrowserChrome($name, $title)
    {
        if (stripos(self::$userAgentString, 'Chrome') !== false) {
            $aresult = explode('/', stristr(self::$userAgentString, 'Chrome'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                self::$browser->setVersion($aversion[0]);
            }
            self::$browser->setName($title);

            return true;
        }
        elseif (stripos(self::$userAgentString, 'CriOS') !== false) {
            $aresult = explode('/', stristr(self::$userAgentString, 'CriOS'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                self::$browser->setVersion($aversion[0]);
            }
            self::$browser->setName($title);

            return true;
        }

        return false;
    }

    /**
     * Determine if the browser is Comodo Dragon / Ice Dragon / Chromodo.
     * @return bool
     */
    public static function checkBrowserDragon($name, $title)
    {
        if (stripos(self::$userAgentString, 'Dragon') !== false) {
            $aresult = explode('/', stristr(self::$userAgentString, 'Dragon'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                self::$browser->setVersion($aversion[0]);
            }
            self::$browser->setName($title);

            return true;
        }

        return false;
    }

    /**
     * Determine if the browser is Microsoft Edge.
     * @return bool
     */
    public static function checkBrowserEdge($name, $title)
    {
        if (stripos(self::$userAgentString, 'Edge') !== false) {
            $version = explode('Edge/', self::$userAgentString);
            if (isset($version[1])) {
                self::$browser->setVersion((float)$version[1]);
            }
            self::$browser->setName($title);

            return true;
        }
        if (stripos(self::$userAgentString, 'Edg/') !== false) {
            $version = explode('Edg/', self::$userAgentString);
            if (isset($version[1])) {
                self::$browser->setVersion((float)$version[1]);
            }
            self::$browser->setName($title);

            return true;
        }
        return false;
    }

    /**
     * Determine if the browser is Firebird.
     * @return bool
     */
    public static function checkBrowserFirebird($name, $title)
    {
        if (stripos(self::$userAgentString, 'Firebird') !== false) {
            $aversion = explode('/', stristr(self::$userAgentString, 'Firebird'));
            if (isset($aversion[1])) {
                self::$browser->setVersion($aversion[1]);
            }
            self::$browser->setName($title);

            return true;
        }

        return false;
    }

    /**
     * Determine if the browser is Firefox.
     * @return bool
     */
    public static function checkBrowserFirefox($name, $title)
    {
        if (stripos(self::$userAgentString, 'safari') === false) {
            if (preg_match("/Firefox[\/ \(]([^ ;\)]+)/i", self::$userAgentString, $matches)) {
                if (isset($matches[1])) {
                    self::$browser->setVersion($matches[1]);
                }
                self::$browser->setName($title);

                return true;
            }
            elseif (preg_match('/Firefox$/i', self::$userAgentString, $matches)) {
                self::$browser->setVersion('');
                self::$browser->setName($title);

                return true;
            }
        }

        return false;
    }

    /**
     * Determine if the browser is Galeon.
     * @return bool
     */
    public static function checkBrowserGaleon($name, $title)
    {
        if (stripos(self::$userAgentString, 'galeon') !== false) {
            $aresult  = explode(' ', stristr(self::$userAgentString, 'galeon'));
            $aversion = explode('/', $aresult[0]);
            if (isset($aversion[1])) {
                self::$browser->setVersion($aversion[1]);
            }
            self::$browser->setName($title);

            return true;
        }

        return false;
    }

    /**
     * Determine if the browser is Google Search Appliance.
     * @return bool
     */
    public static function checkBrowserGsa($name, $title)
    {
        if (stripos(self::$userAgentString, 'GSA') !== false) {
            $aresult = explode('/', stristr(self::$userAgentString, 'GSA'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                self::$browser->setVersion($aversion[0]);
            }
            self::$browser->setName($title);

            return true;
        }

        return false;
    }

    public static function checkBrowserHuaWei($name, $title)
    {
        // Mozilla/5.0 (Linux; Android 5.1; zh-cn; HUAWEI CUN-AL00 Build/CUN-AL00) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Mobile Safari/537.36
        //Mozilla/5.0 (Linux; Android 9; COR-AL00 Build/HUAWEICOR-AL00) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Mobile Safari/537.36
        //Mozilla/5.0 (Linux; Android 7.0; BLN-AL40 Build/HONORBLN-AL40) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.0.0 Mobile Safari/537.36
        if (preg_match('/HuaweiBrowser\/([\.\d]+)/i', self::$userAgentString, $mat)) {
            self::$browser->setName($title);
            self::$browser->setVersion($mat[1]);

            return true;
        }

        if (stripos(self::$userAgentString, ' HUAWEI ') !== false
            || stripos(self::$userAgentString, 'Build/HUAWEI') !== false
            || stripos(self::$userAgentString, 'Build/HONOR') !== false
        ) {
            self::$browser->setName($title);
            self::$browser->setVersion('0');

            return true;
        }

        return false;
    }

    /**
     * Determine if the browser is iCab.
     * @return bool
     */
    public static function checkBrowserIcab($name, $title)
    {
        if (stripos(self::$userAgentString, 'icab') !== false) {
            $aversion = explode(' ', stristr(str_replace('/', ' ', self::$userAgentString), 'icab'));
            if (isset($aversion[1])) {
                self::$browser->setVersion($aversion[1]);
            }
            self::$browser->setName($title);

            return true;
        }

        return false;
    }

    /**
     * Determine if the browser is Ice Cat.
     * @return bool
     */
    public static function checkBrowserIceCat($name, $title)
    {
        if (stripos(self::$userAgentString, 'Mozilla') !== false &&
            preg_match('/IceCat\/([^ ]*)/i', self::$userAgentString, $matches)
        ) {
            if (isset($matches[1])) {
                self::$browser->setVersion($matches[1]);
            }
            self::$browser->setName($title);

            return true;
        }

        return false;
    }

    /**
     * Determine if the browser is Iceweasel.
     * @return bool
     */
    public static function checkBrowserIceweasel($name, $title)
    {
        if (stripos(self::$userAgentString, 'Iceweasel') !== false) {
            $aresult = explode('/', stristr(self::$userAgentString, 'Iceweasel'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                self::$browser->setVersion($aversion[0]);
            }
            self::$browser->setName($title);

            return true;
        }

        return false;
    }

    /**
     * Determine if the browser is Internet Explorer.
     * @return bool
     */
    public static function checkBrowserInternetExplorer($name, $title)
    {
        // Test for v1 - v1.5 IE
        if (stripos(self::$userAgentString, 'microsoft internet explorer') !== false) {
            self::$browser->setName($title);
            self::$browser->setVersion('1.0');
            $aresult = stristr(self::$userAgentString, '/');
            if (preg_match('/308|425|426|474|0b1/i', $aresult)) {
                self::$browser->setVersion('1.5');
            }

            return true;
        } // Test for versions > 1.5 and < 11 and some cases of 11
        else {
            if (stripos(self::$userAgentString, 'msie') !== false && stripos(self::$userAgentString, 'opera') === false
            ) {
                // See if the browser is the odd MSN Explorer
                if (stripos(self::$userAgentString, 'msnb') !== false) {
                    $aresult = explode(' ', stristr(str_replace(';', '; ', self::$userAgentString), 'MSN'));
                    self::$browser->setName($title);
                    if (isset($aresult[1])) {
                        self::$browser->setVersion(str_replace(['(', ')', ';'], '', $aresult[1]));
                    }

                    return true;
                }
                $aresult = explode(' ', stristr(str_replace(';', '; ', self::$userAgentString), 'msie'));
                self::$browser->setName($title);
                if (isset($aresult[1])) {
                    self::$browser->setVersion(str_replace(['(', ')', ';'], '', $aresult[1]));
                }
                // See https://msdn.microsoft.com/en-us/library/ie/hh869301%28v=vs.85%29.aspx
                // Might be 11, anyway !
                if (stripos(self::$userAgentString, 'trident') !== false) {
                    preg_match('/rv:(\d+\.\d+)/', self::$userAgentString, $matches);
                    if (isset($matches[1])) {
                        self::$browser->setVersion($matches[1]);
                    }

                    // At this poing in the method, we know the MSIE and Trident
                    // strings are present in the $userAgentString. If we're in
                    // compatibility mode, we need to determine the true version.
                    // If the MSIE version is 7.0, we can look at the Trident
                    // version to *approximate* the true IE version. If we don't
                    // find a matching pair, ( e.g. MSIE 7.0 && Trident/7.0 )
                    // we're *not* in compatibility mode and the browser really
                    // is version 7.0.
                    if (stripos(self::$userAgentString, 'MSIE 7.0;')) {
                        if (stripos(self::$userAgentString, 'Trident/7.0;')) {
                            // IE11 in compatibility mode
                            self::$browser->setVersion('11.0');
                            self::$browser->setIsCompatibilityMode(true);
                        }
                        elseif (stripos(self::$userAgentString, 'Trident/6.0;')) {
                            // IE10 in compatibility mode
                            self::$browser->setVersion('10.0');
                            self::$browser->setIsCompatibilityMode(true);
                        }
                        elseif (stripos(self::$userAgentString, 'Trident/5.0;')) {
                            // IE9 in compatibility mode
                            self::$browser->setVersion('9.0');
                            self::$browser->setIsCompatibilityMode(true);
                        }
                        elseif (stripos(self::$userAgentString, 'Trident/4.0;')) {
                            // IE8 in compatibility mode
                            self::$browser->setVersion('8.0');
                            self::$browser->setIsCompatibilityMode(true);
                        }
                    }
                }

                return true;
            } // Test for versions >= 11
            else {
                if (stripos(self::$userAgentString, 'trident') !== false) {
                    self::$browser->setName($title);

                    preg_match('/rv:(\d+\.\d+)/', self::$userAgentString, $matches);
                    if (isset($matches[1])) {
                        self::$browser->setVersion($matches[1]);

                        return true;
                    }
                    else {
                        return false;
                    }
                } // Test for Pocket IE
                else {
                    if (stripos(self::$userAgentString, 'mspie') !== false ||
                        stripos(
                            self::$userAgentString,
                            'pocket'
                        ) !== false
                    ) {
                        $aresult = explode(' ', stristr(self::$userAgentString, 'mspie'));
                        self::$browser->setName($title);

                        if (stripos(self::$userAgentString, 'mspie') !== false) {
                            if (isset($aresult[1])) {
                                self::$browser->setVersion($aresult[1]);
                            }
                        }
                        else {
                            $aversion = explode('/', self::$userAgentString);
                            if (isset($aversion[1])) {
                                self::$browser->setVersion($aversion[1]);
                            }
                        }

                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * Determine if the browser is Konqueror.
     * @return bool
     */
    public static function checkBrowserKonqueror($name, $title)
    {
        if (stripos(self::$userAgentString, 'Konqueror') !== false) {
            $aresult  = explode(' ', stristr(self::$userAgentString, 'Konqueror'));
            $aversion = explode('/', $aresult[0]);
            if (isset($aversion[1])) {
                self::$browser->setVersion($aversion[1]);
            }
            self::$browser->setName($title);

            return true;
        }

        return false;
    }

    /* check 猎豹 browser*/
    public static function checkBrowserLIEBAO($name, $title)
    {
        if (stripos(self::$userAgentString, 'LBBROWSER') !== false) {
            self::$browser->setName($title);

            return true;
        }

        return false;
    }

    /**
     * Determine if the browser is Lynx.
     * @return bool
     */
    public static function checkBrowserLynx($name, $title)
    {
        if (stripos(self::$userAgentString, 'lynx') !== false) {
            $aresult  = explode('/', stristr(self::$userAgentString, 'Lynx'));
            $aversion = explode(' ', (isset($aresult[1]) ? $aresult[1] : ''));
            self::$browser->setVersion($aversion[0]);
            self::$browser->setName($title);

            return true;
        }

        return false;
    }

    public static function checkBrowserMaxthon($name, $title)
    {
        if (preg_match('/Maxthon\/(.+)/i', self::$userAgentString, $mat)) {
            self::$browser->setName($title);
            self::$browser->setVersion($mat[1]);

            return true;
        }

        return false;
    }

    public static function checkBrowserMiuiBrowser($name, $title)
    {
        if (preg_match('/MiuiBrowser\/([\.\d]+)/i', self::$userAgentString, $mat)) {
            self::$browser->setName($title);
            self::$browser->setVersion($mat[1]);

            return true;
        }

        return false;
    }

    /**
     * Determine if the browser is Mozilla.
     * @return bool
     */
    public static function checkBrowserMozilla($name, $title)
    {
        if (stripos(self::$userAgentString, 'mozilla') !== false &&
            preg_match('/rv:[0-9].[0-9][a-b]?/i', self::$userAgentString) &&
            stripos(self::$userAgentString, 'netscape') === false
        ) {
            $aversion = explode(' ', stristr(self::$userAgentString, 'rv:'));
            preg_match('/rv:[0-9].[0-9][a-b]?/i', self::$userAgentString, $aversion);
            self::$browser->setVersion(str_replace('rv:', '', $aversion[0]));
            self::$browser->setName($title);

            return true;
        }
        elseif (stripos(self::$userAgentString, 'mozilla') !== false &&
            preg_match('/rv:[0-9]\.[0-9]/i', self::$userAgentString) &&
            stripos(self::$userAgentString, 'netscape') === false
        ) {
            $aversion = explode('', stristr(self::$userAgentString, 'rv:'));
            self::$browser->setVersion(str_replace('rv:', '', $aversion[0]));
            self::$browser->setName($title);

            return true;
        }
        elseif (stripos(self::$userAgentString, 'mozilla') !== false &&
            preg_match('/mozilla\/([^ ]*)/i', self::$userAgentString, $matches) &&
            stripos(self::$userAgentString, 'netscape') === false
        ) {
            if (isset($matches[1])) {
                self::$browser->setVersion($matches[1]);
            }
            self::$browser->setName($title);

            return true;
        }

        return false;
    }

    /**
     * Determine if the browser is NetPositive.
     * @return bool
     */
    public static function checkBrowserNetPositive($name, $title)
    {
        if (stripos(self::$userAgentString, 'NetPositive') !== false) {
            $aresult = explode('/', stristr(self::$userAgentString, 'NetPositive'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                self::$browser->setVersion(str_replace(['(', ')', ';'], '', $aversion[0]));
            }
            self::$browser->setName($title);

            return true;
        }

        return false;
    }

    /**
     * Determine if the browser is Netscape Navigator 9+.
     * @return bool
     */
    public static function checkBrowserNetscapeNavigator9Plus($name, $title)
    {
        if (stripos(self::$userAgentString, 'Firefox') !== false &&
            preg_match('/Navigator\/([^ ]*)/i', self::$userAgentString, $matches)
        ) {
            if (isset($matches[1])) {
                self::$browser->setVersion($matches[1]);
            }
            self::$browser->setName($title);

            return true;
        }
        elseif (stripos(self::$userAgentString, 'Firefox') === false &&
            preg_match('/Netscape6?\/([^ ]*)/i', self::$userAgentString, $matches)
        ) {
            if (isset($matches[1])) {
                self::$browser->setVersion($matches[1]);
            }
            self::$browser->setName($title);

            return true;
        }

        return false;
    }

    /**
     * Determine if the browser is Nokia.
     * @return bool
     */
    public static function checkBrowserNokia($name, $title)
    {
        if (preg_match("/Nokia([^\/]+)\/([^ SP]+)/i", self::$userAgentString, $matches)) {
            self::$browser->setVersion($matches[2]);
            if (stripos(self::$userAgentString, 'Series60') !== false ||
                strpos(self::$userAgentString, 'S60') !== false
            ) {
                self::$browser->setName($title);
            }
            else {
                self::$browser->setName($title);
            }

            return true;
        }

        return false;
    }

    /**
     * Determine if the browser is OmniWeb.
     * @return bool
     */
    public static function checkBrowserOmniWeb($name, $title)
    {
        if (stripos(self::$userAgentString, 'omniweb') !== false) {
            $aresult  = explode('/', stristr(self::$userAgentString, 'omniweb'));
            $aversion = explode(' ', isset($aresult[1]) ? $aresult[1] : '');
            self::$browser->setVersion($aversion[0]);
            self::$browser->setName($title);

            return true;
        }

        return false;
    }

    /**
     * Determine if the browser is Opera.
     * @return bool
     */
    public static function checkBrowserOpera($name, $title)
    {
        if (stripos(self::$userAgentString, 'opera mini') !== false) {
            $resultant = stristr(self::$userAgentString, 'opera mini');
            if (preg_match('/\//', $resultant)) {
                $aresult = explode('/', $resultant);
                if (isset($aresult[1])) {
                    $aversion = explode(' ', $aresult[1]);
                    self::$browser->setVersion($aversion[0]);
                }
            }
            else {
                $aversion = explode(' ', stristr($resultant, 'opera mini'));
                if (isset($aversion[1])) {
                    self::$browser->setVersion($aversion[1]);
                }
            }
            self::$browser->setName($title);

            return true;
        }
        elseif (stripos(self::$userAgentString, 'OPiOS') !== false) {
            $aresult = explode('/', stristr(self::$userAgentString, 'OPiOS'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                self::$browser->setVersion($aversion[0]);
            }
            self::$browser->setName($title);

            return true;
        }
        elseif (stripos(self::$userAgentString, 'opera') !== false) {
            $resultant = stristr(self::$userAgentString, 'opera');
            if (preg_match('/Version\/(1[0-2].*)$/', $resultant, $matches)) {
                if (isset($matches[1])) {
                    self::$browser->setVersion($matches[1]);
                }
            }
            elseif (preg_match('/\//', $resultant)) {
                $aresult = explode('/', str_replace('(', ' ', $resultant));
                if (isset($aresult[1])) {
                    $aversion = explode(' ', $aresult[1]);
                    self::$browser->setVersion($aversion[0]);
                }
            }
            else {
                $aversion = explode(' ', stristr($resultant, 'opera'));
                self::$browser->setVersion(isset($aversion[1]) ? $aversion[1] : '');
            }
            self::$browser->setName($title);

            return true;
        }
        elseif (stripos(self::$userAgentString, ' OPR/') !== false) {
            self::$browser->setName($title);
            if (preg_match('/OPR\/([\d\.]*)/', self::$userAgentString, $matches)) {
                if (isset($matches[1])) {
                    self::$browser->setVersion($matches[1]);
                }
            }

            return true;
        }

        return false;
    }

    public static function checkBrowserOppo($name, $title)
    {
        if (preg_match('/OppoBrowser\/([\.\d]+)/i', self::$userAgentString, $mat)) {
            self::$browser->setName($title);
            self::$browser->setVersion($mat[1]);

            return true;
        }

        return false;
    }

    /**
     * Determine if the browser is Phoenix.
     * @return bool
     */
    public static function checkBrowserPhoenix($name, $title)
    {
        if (stripos(self::$userAgentString, 'Phoenix') !== false) {
            $aversion = explode('/', stristr(self::$userAgentString, 'Phoenix'));
            if (isset($aversion[1])) {
                self::$browser->setVersion($aversion[1]);
            }
            self::$browser->setName($title);

            return true;
        }

        return false;
    }

    /* check qq browser*/
    public static function checkBrowserQQ($name, $title)
    {
        if (stripos(self::$userAgentString, 'QQBrowser') !== false) {
            $aresult = explode('/', stristr(self::$userAgentString, 'QQBrowser'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                self::$browser->setVersion($aversion[0]);
            }
            self::$browser->setName($title);

            return true;
        }

        return false;
    }

    /**
     * Determine if the browser is a robot.
     * @return bool
     */
    public static function checkBrowserRobot($name, $title)
    {
        // if (stripos(self::$userAgentString, 'bot') !== false ||
        //     stripos(self::$userAgentString, 'spider') !== false ||
        //     stripos(self::$userAgentString, 'crawler') !== false ||
        //     stripos(self::$userAgentString, 'spider') !== false
        // ) {
        //     self::$browser->setIsRobot(true);

        //     return true;
        // }

        // return false;
        // $userAgent = ' Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/534+ (KHTML, like Gecko) BingPreview/1.0b';

        foreach (self::$spider_pattern as $key => $value) {
            if (preg_match($value[0], self::$userAgentString, $mat)) {
                self::$browser->setIsRobot(true);
                self::$browser->setName($value[1] ?: $mat[1]);
                self::$browser->setVersion(isset($mat[2]) ? $mat[2] : '0.0');

                return true;
            }
        }

        $spider = new CrawlerDetect(null, self::$userAgentString);
        if ($spider->isCrawler()) {
            self::$browser->setIsRobot(true);
            self::$browser->setName($spider->getMatches());
            self::$browser->setVersion(0);

            return true;
        }

        return false;
    }

    public static function checkBrowserRobotIP($name, $title)
    {
        $ip = self::$browser->getIP();
        if (!$ip) {
            $ip = self::getClientIp();
        }
        //百度蜘蛛ip段
        foreach (self::$spiderIps as $key => $info) {
            $ips   = $info['ips'];
            $title = $info['title'];
            foreach ($ips as $ipOrReg) {

                if (!is_numeric(substr($ipOrReg, 0, 1))) {
                    //正则处理
                    try {
                        $ipOrReg = str_replace(['@^', '$@', '\.', '[', ']'], ['', '', '.', ''], $ipOrReg);
                        [$ip1, $ip2, $ip3, $ip4] = explode('.', $ipOrReg);
                        [$start, $end] = explode('-', $ip4);
                        while ($end > 0) {
                            $newIp = "$ip1.$ip2.$ip3." . $end;
                            if ($newIp === $ip) {
                                self::$browser->setIsRobot(true);
                                self::$browser->setName($title);
                                self::$browser->setVersion(0);
                                return true;
                            }
                            $end--;
                        }
                        // if (preg_match($ipOrReg, $ip)) {
                        //     return true;
                        // }
                    } catch (\Exception $e) {
                        continue;
                    }
                }
                elseif (strpos($ip, $ipOrReg) === 0) {
                    //关键词处理
                    self::$browser->setIsRobot(true);
                    self::$browser->setName($title);
                    self::$browser->setVersion(0);

                    return true;
                }
            }

        }

        return false;
    }

    /**
     * Determine if the browser is Safari.
     * @return bool
     */
    public static function checkBrowserSafari($name, $title)
    {
        if (stripos(self::$userAgentString, 'Safari') !== false) {
            $aresult = explode('/', stristr(self::$userAgentString, 'Version'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                self::$browser->setVersion($aversion[0]);
            }
            else {
                self::$browser->setVersion(Browser::VERSION_UNKNOWN);
            }
            self::$browser->setName($title);

            return true;
        }

        return false;
    }

    public static function checkBrowserSamsung($name, $title)
    {
        if (preg_match('/SamsungBrowser\/([\.\d]+)/i', self::$userAgentString, $mat)) {
            self::$browser->setName($title);
            self::$browser->setVersion($mat[1]);

            return true;
        }

        return false;
    }

    /**
     * Determine if the browser is SeaMonkey.
     * @return bool
     */
    public static function checkBrowserSeaMonkey($name, $title)
    {
        if (stripos(self::$userAgentString, 'safari') === false) {
            if (preg_match("/SeaMonkey[\/ \(]([^ ;\)]+)/i", self::$userAgentString, $matches)) {
                if (isset($matches[1])) {
                    self::$browser->setVersion($matches[1]);
                }
                self::$browser->setName($title);

                return true;
            }
            elseif (preg_match('/SeaMonkey$/i', self::$userAgentString, $matches)) {
                self::$browser->setVersion('');
                self::$browser->setName($title);

                return true;
            }
        }

        return false;
    }

    /**
     * Determine if the browser is Shiretoko.
     * @return bool
     */
    public static function checkBrowserShiretoko($name, $title)
    {
        if (stripos(self::$userAgentString, 'Mozilla') !== false &&
            preg_match('/Shiretoko\/([^ ]*)/i', self::$userAgentString, $matches)
        ) {
            if (isset($matches[1])) {
                self::$browser->setVersion($matches[1]);
            }
            self::$browser->setName($title);

            return true;
        }

        return false;
    }

    public static function checkBrowserSouGou($name, $title)
    {
        if (preg_match('/\sSE\s(.*?)\sMetaSr/i', self::$userAgentString, $mat)) {
            self::$browser->setName($title);
            self::$browser->setVersion($mat[1]);

            return true;
        }

        return false;
    }

    /* check uc browser*/
    public static function checkBrowserUC($name, $title)
    {
        if (stripos(self::$userAgentString, 'UBrowser') !== false) {
            $aresult = explode('/', stristr(self::$userAgentString, 'UBrowser'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                self::$browser->setVersion($aversion[0]);
            }
            self::$browser->setName($title);

            return true;
        }

        if (stripos(self::$userAgentString, 'UCBrowser') !== false) {
            $aresult = explode('/', stristr(self::$userAgentString, 'UCBrowser'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                self::$browser->setVersion($aversion[0]);
            }
            self::$browser->setName($title);

            return true;
        }

        return false;
    }

    /**
     * Determine if the browser is Vivaldi.
     * @return bool
     */
    public static function checkBrowserVivaldi($name, $title)
    {
        if (stripos(self::$userAgentString, 'Vivaldi') !== false) {
            $aresult = explode('/', stristr(self::$userAgentString, 'Vivaldi'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                self::$browser->setVersion($aversion[0]);
            }
            self::$browser->setName($title);

            return true;
        }

        return false;
    }

    public static function checkBrowserVivo($name, $title)
    {
        if (preg_match('/VivoBrowser\/([\.\d]+)/i', self::$userAgentString, $mat)) {
            self::$browser->setName($title);
            self::$browser->setVersion($mat[1]);

            return true;
        }

        return false;
    }

    /**
     * Determine if the browser is WebTv.
     * @return bool
     */
    public static function checkBrowserWebTv($name, $title)
    {
        if (stripos(self::$userAgentString, 'webtv') !== false) {
            $aresult = explode('/', stristr(self::$userAgentString, 'webtv'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                self::$browser->setVersion($aversion[0]);
            }
            self::$browser->setName($title);

            return true;
        }

        return false;
    }

    /**
     * Determine if the browser is Yandex.
     * @return bool
     */
    public static function checkBrowserYandex($name, $title)
    {
        if (stripos(self::$userAgentString, 'YaBrowser') !== false) {
            $aresult = explode('/', stristr(self::$userAgentString, 'YaBrowser'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                self::$browser->setVersion($aversion[0]);
            }
            self::$browser->setName($title);

            return true;
        }

        return false;
    }

    /**
     * Determine if the user is using Chrome Frame.
     * @return bool
     */
    public static function checkChromeFrame()
    {
        if (strpos(self::$userAgentString, 'chromeframe') !== false) {
            self::$browser->setIsChromeFrame(true);

            return true;
        }

        return false;
    }

    /**
     * Determine if the user is using Facebook.
     * @return bool
     */
    public static function checkFacebookWebView()
    {
        if (strpos(self::$userAgentString, 'FBAV') !== false) {
            self::$browser->setIsFacebookWebView(true);

            return true;
        }

        return false;
    }

    /**
     * Routine to determine the browser type.
     * @param Browser   $browser
     * @param UserAgent $userAgent
     * @return bool
     */
    public static function detect(Browser $browser, UserAgent $userAgent = null)
    {
        self::$browser = $browser;
        if (is_null($userAgent)) {
            $userAgent = self::$browser->getUserAgent();
        }
        self::$userAgentString = $userAgent->getUserAgentString();

        self::$browser->setName(Browser::UNKNOWN);
        self::$browser->setVersion(Browser::VERSION_UNKNOWN);

        self::checkChromeFrame();
        self::checkFacebookWebView();

        foreach (self::$browsersList as $browserName => $title) {
            $funcName = self::FUNC_PREFIX . $browserName;

            if (self::$funcName($browserName, $title)) {
                return true;
            }
        }

        return false;
    }

    public static function getClientIp($type = false, $adv = true)
    {
        $type = $type ? 1 : 0;
        $type = 0;
        static $ip = null;
        if ($ip !== null) {
            return $ip[$type];
        }

        if ($adv) {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                $pos = array_search('unknown', $arr);
                if (false !== $pos) {
                    unset($arr[$pos]);
                }

                $ip = trim($arr[0]);
            }
            elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            }
            elseif (isset($_SERVER['REMOTE_ADDR'])) {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
        }
        elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        // IP地址合法验证
        $long = sprintf('%u', ip2long($ip));
        $ip   = $long ? [$ip, $long] : ['0.0.0.0', 0];

        return $ip[$type];
    }
}
