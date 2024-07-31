# ExpoContactForm
This plugin is specific to a site in development and is not meant for public use.

To install clone the folder into your /plugins folder. (craft/plugins/)
Next open your craft installs composer.json and add these lines. 
{
  ...
  "require": {
    ...
    "brandgage/ecf": "dev-main",
    ...
  },
  ...
  "repositories": [
    {
      "type": "path",
      "url": "plugins/ecf"
    }
  ]
}

Next run in a terminal => composer update 
This will make craft see the plugin is available. 
Finally you should then see the plugin in your list of plugins on the craft admin dashboard. From here you may click the elipses (...) and select install. You may also look for the plugin via the terminal. 
php craft plugin/install
