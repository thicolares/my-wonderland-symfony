# My Wonderland
[![Build Status](https://travis-ci.org/colares/my-wonderland.svg?branch=master)](https://travis-ci.org/colares/my-wonderland) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/colares/my-wonderland/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/colares/my-wonderland/?branch=master)

A simple tool that helps you to find the place where there're more concerts performed by the artists you love.

It matches your Spotify profile with Songkick calendar and venues in the near future.

## Requirements
### Docker

[Install Docker](https://docs.docker.com/install/)

You can run the project using PHP> = 7.1, nginx or Apache, and composer. All you have to do is run <code> composer install </code> and set <code>/src</code> as the public folder for nginx or Apache.

### Spotify API Key
**I'm using the new Beta API (as on Apr 7th 2018).** Apply for Spotify API key. The request is processed immediately: https://beta.developer.spotify.com/. From May 7th 2018 and on: https://developer.spotify.com/

### Songkick API Key
Apply for Songkick API key. The request is analyzed by a human being and can take more than one day :\ https://www.songkick.com/api_key_requests/new

# Installation

Clone the project (or download it):



    $ git clone https://github.com/colares/my-wonderland.git
    $ cd my-wonderland
    
Copy and setup your <code>.env</code> vars. **Recommended:** Leave <code>BASE_URI</code> with the default value:
 
    $ cp .env.example .env
    
Create a record in your <code>hosts</code> file to point <code>my-wonderland.localhost</code> to your Docker environment:

    $ sudo vim /etc/hosts
    
Add the record:

    127.0.1.1       my-wonderland.localhost

Run:

    $ docker-compose run composer install
    $ docker-compose up web php
    
Visit http://my-wonderland.localhost:8080/.

# Screenshots

## Welcome
![Welcome](docs/my-wonderland01.png "Welcome")

## Connect My Wonderland to your Spotify account
![Connect My Wonderland to your Spotify account.](docs/my-wonderland02.png "Connect My Wonderland to your Spotify account.")

## Find your wonderland
New York? Sweet!

![Find your wonderland](docs/my-wonderland03.png "Find your wonderland")
