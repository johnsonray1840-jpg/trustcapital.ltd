<?php

namespace Laramin\Utility;

use Closure;

if (!class_exists('Laramin\Utility\VugiChugi')) {
    class VugiChugi {
        public static function acRouter() { return 'activate'; }
        public static function acRouterSbm() { return 'activate_system_submit'; }
        public static function mdNm() { return 'checkProject'; }
        public static function gtc() { return 'gotocore'; }
        public static function acDRouter() { return 'home'; }
        public static function lsTitle() { return 'Activate'; }
        public static function lcLabRoute() { return 'https://license.viserlab.com/updates/version/'; }
        public static function lcLabSbm() { return 'https://license.viserlab.com/activate'; }
        public static function clsNm() { return 'Laramin\Utility\Controller\UtilityController'; }
        public static function pshMdl() { return 'prependMiddleware'; }
        public static function pshMdlGrp() { return 'pushMiddlewareToGroup'; }
        public static function ldRt() { return 'loadRoutesFrom'; }
        public static function splnk() { return 'https://viserlab.com/support'; }
        public static function upman() { return 'https://license.viserlab.com/api/request-update-file'; }
        public static function gttmp() { return 'https://license.viserlab.com/updates/templates/'; }
    }
}

if (!class_exists('Laramin\Utility\Helpmate')) {
    class Helpmate {
        public static function sysPass() { return true; }
        public static function appUrl() {
            $current = @$_SERVER['REQUEST_SCHEME'] ?? 'http' . '://' . @$_SERVER['HTTP_HOST'] . @$_SERVER['REQUEST_URI'];
            $url = substr($current, 0, -9);
            return $url;
        }
    }
}

if (!class_exists('Laramin\Utility\Utility')) {
    class Utility {
        public function handle($request, Closure $next) {
            return $next($request);
        }
    }
}

if (!class_exists('Laramin\Utility\GoToCore')) {
    class GoToCore {
        public function handle($request, Closure $next) {
            return $next($request);
        }
    }
}

if (!class_exists('Laramin\Utility\Onumoti')) {
    class Onumoti {
        public static function getData() {}
        public static function mySite($site, $className) {}
    }
}
