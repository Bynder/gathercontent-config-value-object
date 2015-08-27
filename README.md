# Config Value Object

Ensure the config adheres to [the rules](#the-rules).

## Requirements

- PHP 5.3.0 or later

## Installation

Run the following command inside your repository:

```bash
$ composer require gathercontent/config-value-object:0.1.*
```
## Usage

```php
$json = 'your config in JSON format goes here!';

$configObject = Config::fromJson($json);
```

The code above will throw `ConfigValueException` if the config does not adhere to [the rules](#the-rules).

## The rules

The config is an array of tabs. It must have at least one tab.

An example of valid config:

```json
[
  {
    "label": "Content",
    "name": "tab1",
    "hidden": false,
    "elements": [
      {
        "type": "text",
        "name": "el1",
        "required": false,
        "label": "Blog post",
        "value": "<p>Hello world</p>",
        "microcopy": "",
        "limit_type": "words",
        "limit": "1000",
        "plain_text": false
      }
    ]
  }
]
```

#### Tab structure:

Must be an object. All attributes are required. No additional attributes are allowed.

```javascript
{
  "label": "Content",                // string, not empty
  "name": "tab1",                    // string, not empty, unique
  "hidden": false,                   // boolean
  "elements": [ /* tab elements */ ] // array
}
```
#### Element structure

Allowed element types:

  - `text`
  - `files`
  - `section`
  - `choice_radio`
  - `choice_checkbox`

All elements must be objects. All attributes are required. No additional attributes are allowed.

##### Type `text`:

```javascript
{
  "type": "text",                // string, must be "text"
  "name": "el1",                 // string, not empty, unique
  "required": false,             // boolean
  "label": "Blog post",          // string, not empty
  "value": "<p>Hello world</p>", // string
  "microcopy": "",               // string
  "limit_type": "words",         // string, either "words" or "chars"
  "limit": 1000,                 // integer, non-negative
  "plain_text": false            // boolean
}
```

##### Type `files`:

```javascript
{
  "type": "files",   // string, must be "files"
  "name": "el2",     // string, not empty, unique
  "required": false, // boolean
  "label": "Photos", // string, not empty
  "microcopy": ""    // string
}
```

##### Type `section`:

```javascript
{
  "type": "section",                 // string, must be "section"
  "name": "el3",                     // string, not empty, unique
  "title": "Title",                  // string, not empty
  "subtitle": "<p>How goes it?</p>"  // string
}
```

##### Type `choice_radio`:

```javascript
{
  "type": "choice_radio",              // string, must be "choice_radio"
  "name": "el4",                       // string, not empty, unique
  "required": false,                   // boolean
  "label": "Label",                    // string, not empty
  "microcopy": "",                     // string
  "other_option": false,               // boolean
  "options": [ /* element options */ ] // array, must have at least one option
}
```

At least two options required if `other_option` is `true`.

##### Type `choice_checkbox`:

```javascript
{
  "type": "choice_checkbox",           // string, must be "choice_checkbox"
  "name": "el4",                       // string, not empty, unique
  "required": false,                   // boolean
  "label": "Label",                    // string, not empty
  "microcopy": "",                     // string
  "options": [ /* element options */ ] // array, must have at least one option
}
```

#### Option structure

All options must be objects. All attributes are required. No additional attributes are allowed.

Most options will look like this:

```javascript
{
  "name": "op1",       // string, not empty, unique
  "label": "Option 1", // string, not empty
  "selected": false    // boolean
}
```

The only exception is the last option for `choice_radio` element if the `other_option` attribute is `true`:

```javascript
{
  "name": "op1",       // string, not empty, unique
  "label": "Other",    // string, not empty
  "selected": true,    // boolean
  "value": "Something" // string
}
```

The `value` attribute for "other" option must be empty if the option is not selected.

`choice_radio` must not have more than one option selected.


## Testing

Run unit tests:

``` bash
$ ./vendor/bin/phpunit
```

Test compliance with [PSR2 coding style guide](http://www.php-fig.org/psr/psr-2/):

``` bash
$ ./vendor/bin/phpcs --standard=PSR2 ./src
```
