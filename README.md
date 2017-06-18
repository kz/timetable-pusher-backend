# Timetable Pusher for Pebble (Backend)

###### For the Pebble app which consumes this application's API, click [here](https://github.com/kz/timetable-pusher-pebble).

Timetable Pusher is allows users to create Pebble timeline pins from their class timetable(s) and push these pins to their Pebble watch. The platform consists of a Pebble app and a PHP/Laravel web application.

The backend is written in PHP/Laravel and is responsible for:

- Allowing users to enter the class timetables
- Providing an API for the Pebble app
- Consuming the Pebble Timeline API

## Installation

To install this on your own machine:

1. Clone this repository to the desired folder: `git clone git@github.com:kz/timetable-pusher-backend.git`
2. Run `composer install`
3. Run `php artisan key:generate`
4. Rename `.env.example` to `.env`
	1. Configure your database
	2. Get your [Bugsnag](https://bugsnag.com/) API keys and paste them as appropriate

## Credits

- [Kelvin Zhang](https://github.com/kz)
- [All Contributors](link-contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
