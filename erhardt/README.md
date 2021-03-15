Drupal module for Unleashed Technologies Coder Challenge

Installation:
From your drupal project's root directory run:
```composer require cocur/slugify:3.2```
Later versions conflict with the version of twig that drupal requires.
To load the other project dependency go to this modules folder and run:

```composer install
drush -y en erhardt`
```

To get the vendor dependency to install, it must be copied from the module's composer.json to the require section of your root composer.json. Specifically the lines for slugify.

