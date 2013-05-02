<?php
    interface HasOffersApi {
        public function getNetworkId();
        public function getApiKey();
        public function getApiDomain();
        public function getKnownWhitelistedIps();
        public function generateRequestHeader($target, $method, $version = 2);
    }
?>