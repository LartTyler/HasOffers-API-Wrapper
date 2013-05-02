<?php
    require_once('HasOffersApiImpl.php');

    class SimpleHasOffersApi extends HasOffersApiImpl {
        private $cache = array();
        private $query = array();
        private $method = '';
        private $target = '';

        /**
         *	Sets the target resource for the query. This should be an API object, such as Affiliate, AffiliateUser, etc.
         *
         *	@param $target		The target API object
         *	@return		A reference to this object, for chaining calls
         */
        public function setTarget($target) {
            $this->target = $target;

            return $this;
        }

        /**
         *	Sets  the method to call on the query's target. This should be a valid method of the API object selected by setTarget
         *
         *	@param $method		The target method of the selected API object
         *	@return		A reference to this object, for chaining calls
         */
        public function setMethod($method) {
            $this->method = $method;

            return $this;
        }

        /**
         *	Prepares this API instance for a query by flushing the stored query and building a new header set. This is the preferred method of preparing
         *	to execute a query, and should be the first call before addParameter.
         *
         *	@param $target		The target API object
         *	@param $method		The method to call on the target API object
         *	@param	$flushCache		Sets whether or not the flush the cache of previous queries (default: false)
         *	@return		A reference to this object, for chaining calls
         */
        public function prepare($target, $method, $flushCache = false) {
            $this->method = $method;
            $this->target = $target;
            $this->query = array();

            if ($flushCache)
                $this->flushCache();

            $this->buildHeader();

            return $this;
        }

        /**
         *	Executes the stored query
         *
         *	@param $asObject		Sets whether or not to return the result as an object (default) or an associative array
         *	@param $cacheResult		Sets whether or not to store the result in the cache (default: true)
         *	@return		An object or associative array (depending on $asObject) containing the API call response
         */
        public function execute($asObject = true, $cacheResult = true) {
            if (!empty($this->cache[md5(print_r($this->query, true))]))
                $result = $this->cache[md5(print_r($this->query, true))];
            else
                $result = @file_get_contents(parent::getBaseUrl() . http_build_query($this->query));

            if ($result !== false && !is_object($result)) {
                $result = json_decode($result, !$asObject);

                if ($cacheResult)
                    $this->cache[md5(print_r($this->query, true))] = $result;
            }

            return $result;
        }

        /**
         *	Flushes the query cache.
         *
         *	@return		A reference to this object, for chaining calls
         */
        public function flushCache() {
            $cache = array();

            return $this;
        }

        /**
         *	Adds a new argument to the query.
         *
         *	This function can accept two types of parameters, a key and a value, or a key and a numerical array of items that should be below that key.
         *
         *	@param	Varargs		A variable set of arguments that can be adapted to different argument sets
         *	@return		A reference to this object, for chaining calls
         */
        public function addParameter(/* Varargs */) {
            $args = func_get_args();

            switch (sizeof($args)) {
                case 0:
                case 1:
                    throw new Exception('Invalid argument count');

                    break;
                case 2:
                    if (is_string($args[0]))
                        $this->query[$args[0]] = $args[1];
                    else
                        throw new Exception('Keys can only be strings.');

                    break;
                default:
                    if (is_string($args[0])) {
                        $this->query[$args[0]] = array();

                        for ($i = 1; $i < sizeof($args); $i++)
                            $this->query[$args[0]][] = $args[$i];
                    }
            }

            return $this;
        }

        /**
         *	Internal use only.
         */
        public function buildHeader() {
            if (empty($this->query))
                $this->query = parent::generateRequestHeader($this->target, $this->method);
        }
    }
?>