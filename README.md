HasOffers API Wrapper
=====================

A simple PHP wrapper for the HasOffers API

### Setup ###
Setting up the wrapper is fairly straightforward. Simply open up HasOffersApiImpl.php and place your API key, Network ID, and API domain in the appropriate locations (denoted by placeholders) and you're good to go.

### Usage ###
To use the wrapper, you'll need to include the SimpleHasOffersApi.php file. Just instantiate a new instance:

	require_once('php/lib/HasOffers/SimpleHasOffersApi.php');

	$api = new SimpleHasOffersApi();


From there, you'll want to prepare your query by running:

	$api->prepare('Offer', 'findById');


The `prepare` function requires 2 parameters; the target (generally one of the API objects) and the method of that object to call (information for which can be found on the [HasOffers API Wiki](http://www.hasoffers.com/wiki/Category:API)).

After we prepare our query, we need to add some parameters (for most method calls, at least):

	$api->addParameter('id', 'YOUR OFFER ID');


The `addParameter` function accepts 2 different styles of arguments:

> 1. A key as parameter 1, and a value as parameter 2
> 2. A key as parameter 1, and a variable number of parameters that will become the array value of parameter 1. For example:

	$api->addParameter('id', 10, 11, 12, 13)

would be the same as running:

	$api->addParameter('id', array(10, 11, 12, 13))

After all of your paramters have been added, all that's left to do is execute the query:

	$result = $api->execute();


This will return the JSON-decoded value that HasOffers replies with. The format of this object will vary depending on what object you targeted and method you called (again, refer to the [HasOffers API documentation](http://www.hasoffers.com/wiki/Category:API) for more details).

API objects can also be recylced. If you need to make multiple calls during a single script instance, just follow all the above steps again. *Make sure* that the `prepare` function is ran first! Interally, this will clear out all stored parameters before setting the target and method.