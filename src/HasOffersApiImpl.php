<?php
    require_once('HasOffersApi.php');

    abstract class HasOffersApiImpl implements HasOffersApi {
        private $NET_ID = '<YOUR NETWORK ID HERE>';
        private $API_KEY = '<YOUR API KEY HERE>';
        private $API_DOMAIN = '<YOUR API DOMAIN HERE>';
        private $BASE_URL = 'https://api.hasoffers.com/Api?';
        private $WHITE_IPS = array();

        public function getNetworkId() {
            return $this->NET_ID;
        }

        public function getApiKey() {
            return $this->API_KEY;
        }

        public function getApiDomain() {
            return $this->API_DOMAIN;
        }

        public function getKnownWhitelistedIps() {
            return $this->WHITE_IPS;
        }

        public function getBaseUrl() {
            return $this->BASE_URL;
        }

        public function generateRequestHeader($target, $method, $format = 'json', $version = 2) {
            return array(
                'Format' => $format,
                'Target' => $target,
                'Method' => $method,
                'Service' => 'HasOffers',
                'Version' => $version,
                'NetworkId' => $this->NET_ID,
                'NetworkToken' => $this->API_KEY,
                'api_key' => $this->API_KEY
            );
        }
    }
?>