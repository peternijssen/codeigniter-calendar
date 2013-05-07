# CodeIgniter Calendar

CodeIgniter calendar is an improved calendar class. The current class lacks multiple events on the same day and has a poor template.

Currently improved:
- Better templating
- Handling multiple events
- Output per month

Upcoming:
- Output per week
- Output per year

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

Use within your view
```php
echo $this->ptcalendar->generate($year, $month, $events);
```

The events array should look like this. (22 and 6 are the day numbers)
```php
array
  22 => 
    array
      0 => 
        array
          'name' => string 'name'
          'link' => string 'link'
      1 => 
        array
          'name' => string 'name'
          'link' => string 'link'
  6 => 
    array
      0 => 
        array
          'name' => string 'name'
          'link' => string 'link'
```