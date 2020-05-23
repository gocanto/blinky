# Blinky

Blinky is a driver based email verifier that helps you validate your emails inputs against different emails providers.

## Installation

This library uses [Composer](https://getcomposer.org) to manage its dependencies. So, before using it, make sure you 
have it installed in your machine. Once you have done this, you will be able to pull this library in by typing the 
following command in your terminal.

```bash
composer require gocanto/blinky
```

## The reason behind

Sometimes you will need the ability to validate a given `email address` beyond static validations since you might need
to use them to notify your users within your app. For this reason, we need an email provider services that can actually
validate these emails for us. So, we can be sure about our production data that works as expected.

## How does it work?

As it has been mentioned before, this library is driven by different emails providers. Therefore, everything is hidden
behind the [Verifier](https://github.com/gocanto/blinky/blob/master/src/Verifier.php) interface. This abstraction
allows us to swap the `provider` implementation by telling our app what `client` we want to use in runtime.

This means, you will have to bind the provider of your choice with the `Verifier` interface in you Ioc (Service Container). 
By doing so, your application will know what implementation to use at any given time.

## Available Clients Providers

- [x] Mailgun
- [ ] Others in the future :)

## Binding the verifier interface

Binding this interface will depend on what kind of application your are working on. All you need to make sure is, you 
need to bind this interface as early as possible in order for your requests to resolve the proper underline provider.

Imagine your Ioc container offers a `bind` method, then the only thing you need to do is bind the interface to the desire
implementation within a service provider. like so: 

```php
use Blinky\Verifier;
use Blinky\Mailgun\Client;
use Gocanto\HttpClient\HttpClient;
use Blinky\Mailgun\Credentials;

$container->bind(Verifier::class, static function () {
    return new Client(Credentials::live(), new HttpClient());
});
```
 
## Using the Mailgun provider

- First of all, you will have to create its `credentilas` object which are the ones to be used when querying for emails
validation. Like so: 

```php
use Blinky\Mailgun\Credentials;

$credentials = Credentials::live();
$credentials->setUsername('api-username');
$credentials->setApiKey('api-production-key');
```

- Once you have this object created, you will be able to create your `Mailgun` client by passing the given credentials
and the `Http` transport. Like so: 

```php
use Blinky\Mailgun\Client;
use Gocanto\HttpClient\HttpClient;

// we are assuming we have the credentials object here. See the above example for more info.
$client = new Client($credentials, new HttpClient());
```

- After you have your client instance, you can start validating your emails to keep consistency in your application.
like so: 

```php
$response = $client->verify('youremail@domain.com');
```

The response object will contain whether the given email is valid along with the returned payload from the request made.
You will be able to see more about its nature [here](https://github.com/gocanto/blinky/blob/master/tests/Unit/Mailgun/ClientTest.php#L50).

## Development Help

Sometimes you need to test some part of your code that make use of this implementation, then you will have to be making
Http requests every time you refresh your web page. For this, we also ship a Null client that aims to assist on this
duty without changing any code you have. The only thing you need to do is bind the [Null](https://github.com/gocanto/blinky/blob/master/src/Null/Client.php) client to your application
when you are on a different environment from production.

## Contributing

Please feel free to fork this package and contribute by submitting a pull request to enhance its functionality.

## License

The MIT License (MIT). Please see [License File](https://github.com/gocanto/blinky/blob/master/LICENSE.md) for 
more information.

## How can I thank you?
Why not star the github repo and share the link for this repository on Twitter?

Don't forget to [follow me on twitter](https://twitter.com/gocanto)!

Thanks!

Gustavo Ocanto.
