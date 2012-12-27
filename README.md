# CodeIgniter Calendar

CodeIgniter calendar is an improved calendar class. The current class lacks multiple events on the same day and has a poor template.

Currently improved:
- Better templating
- Handling multiple events

Upcoming:
- Outputting month / week / year formats

## NOTE: This class is still in development and subjected to change a lot. Installing through sparks is not yet available. Also, do not use this class yet till the first version is released.

## Requirements
1. CodeIgniter 2.0.0+

## Installing

Available via CodeIgniter Sparks. For info about how to install sparks, go here: http://getsparks.org/install

You can then load the spark with this:

```php
$this->load->spark('ptcalendar/1.0.0/');
```

or by autoloading:

```php
$autoload['sparks'] = array('ptcalendar/1.0.0');
```

Also, copy the files in the views folder to your own views folder

## Usage

After loading, you have this object available:

```php
$this->ptcalendar;
```