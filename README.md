Yii2 Language Picker
====================
Yii2 Language Picker Widget

Introduction
------------

The widget provides an easy to use language selector which makes it possible to change the language of our website easily. 
The language change can take place synchronously or asynchronously (through Ajax). The default method is asynchronous (through an Ajax call), however when this method fails for any reason (e.g. JavaScript is blocked on the client side) the new language will actualise synchronously through an automatic page reload.

The language switcher is fully customisable. However, the pre-defined options provide a dropdown list (DropDownList), and a link-based list (ButtonList). Both versions can display the name of the chosen language and the corresponding flag (icon).

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```json
php composer.phar require --prefer-dist lajax/yii2-language-picker "1.*"
```

or add

```json
"lajax/yii2-language-picker": "1.*"
```

to the require section of your `composer.json` file.

##Config:

Identifier of the language element. e.g.: en, en-US


####Minimal configuration (icons only)

```php
'language' => 'en',
'bootstrap' => ['languagepicker'],
'components' => [
    'languagepicker' => [
        'class' => 'lajax\languagepicker\Component',
        'languages' => ['en', 'de', 'fr']                   // List of available languages (icons only)
    ]
],
```

####Minimal configuration (icons and text)

```php
'language' => 'en',
'bootstrap' => ['languagepicker'],
'components' => [
    'languagepicker' => [
        'class' => 'lajax\languagepicker\Component',        // List of available languages (icons and text)
        'languages' => ['en' => 'English', 'de' => 'Deutsch', 'fr' => 'Français']
    ]
],
```

####Full configuration (icons only)

```php
'language' => 'en-US',
'bootstrap' => ['languagepicker'],
'components' => [
    'languagepicker' => [
        'class' => 'lajax\languagepicker\Component',
        'languages' => ['en-US', 'de-DE', 'fr-FR'],         // List of available languages (icons only)
        'cookieName' => 'language',                         // Name of the cookie.
        'cookieDomain' => 'example.com',                    // Domain of the cookie.
        'expireDays' => 64,                                 // The expiration time of the cookie is 64 days.
        'callback' => function() {
            if (!\Yii::$app->user->isGuest) {
                $user = \Yii::$app->user->identity;
                $user->language = \Yii::$app->language;
                $user->save();
            }
        }
    ]
],
```

###Yii2-translate-manager integration

####Minimal configuration (icons only)

```php
'language' => 'en',
'bootstrap' => ['languagepicker'],
'components' => [
    'languagepicker' => [
        'class' => 'lajax\languagepicker\Component',
        'languages' => function () {                        // List of available languages (icons only)
            return array_keys(\lajax\translatemanager\models\Language::getLanguageNames(true));
        }
    ]
],
```

####Full configuration (icons and text)

```php
'language' => 'en-US',
'bootstrap' => ['languagepicker'],
'components' => [
    'languagepicker' => [
        'class' => 'lajax\languagepicker\Component',
        'languages' => function () {                        // List of available languages (icons and text)
            return \lajax\translatemanager\models\Language::getLanguageNames(true);
        },
        'cookieName' => 'language',                         // Name of the cookie.
        'cookieDomain' => 'example.com',                    // Domain of the cookie.
        'expireDays' => 64,                                 // The expiration time of the cookie is 64 days.
        'callback' => function() {
            if (!\Yii::$app->user->isGuest) {
                $user = \Yii::$app->user->identity;
                $user->language = \Yii::$app->language;
                $user->save();
            }
        }
    ]
],
```

####IMPORTANT

To use the widget, the value of the enablePrettyUrl property in the urlManager configuration must be true, and the value of showScriptName false.

example:

```php
'components' => [
    // ...
    'urlManager' => [
        'enablePrettyUrl' => true,
        'showScriptName' => false,
        'rules' => [
            // your rules go here
        ],
        // ...
    ],
    // ...
]
```

Using of [urlManager](http://www.yiiframework.com/doc-2.0/yii-web-urlmanager.html).

Usage
-----

##Displaying language selector

####Displaying pre-defined languate picker buttons (icons and text or icons only):

```php
<?= \lajax\languagepicker\widgets\LanguagePicker::widget([
    'skin' => \lajax\languagepicker\widgets\LanguagePicker::SKIN_BUTTON,
    'size' => \lajax\languagepicker\widgets\LanguagePicker::SIZE_SMALL
]); ?>
```

####Displaying pre-defined languate picker dropdown list (icons and text or icons only):

```php
<?= \lajax\languagepicker\widgets\LanguagePicker::widget([
    'skin' => \lajax\languagepicker\widgets\LanguagePicker::SKIN_DROPDOWN,
    'size' => \lajax\languagepicker\widgets\LanguagePicker::SIZE_LARGE
]); ?>
```


####Customising the language picker:

```php
<?= \lajax\languagepicker\widgets\LanguagePicker::widget([
    'itemTemplate' => '<li><a href="{link}" title="{language}"><i id="{language}"></i> {name}</a></li>',
    'activeItemTemplate' => '<a href="{link}" title="{language}"><i id="{language}"></i> {name}</a>',
    'parentTemplate' => '<div class="language-picker dropdown-list {size}"><div>{activeItem}<ul>{items}</ul></div></div>',
    'languageAsset' => 'lajax\languagepicker\bundles\LanguageLargeIconsAsset',      // StyleSheets
    'languagePluginAsset' => 'lajax\languagepicker\bundles\LanguagePluginAsset',    // JavaScripts
]); ?>
```


Screenshots
-----------

###Buttons icons and text
![language-picker-0 2-screen-1](https://res.cloudinary.com/lajax/image/upload/v1423590800/button-icons-and-text_aa8mbp.png)


###Buttons icons only
![language-picker-0 2-screen-2](http://res.cloudinary.com/lajax/image/upload/v1423590803/button-icons-only_lrlis1.png)


###Buttons text only
![language-picker-0 2-screen-3](https://res.cloudinary.com/lajax/image/upload/v1423998965/button-text-only_zadyvo.png)


###DropDown icons and text
![language-picker-0 2-screen-4](https://res.cloudinary.com/lajax/image/upload/v1423508826/dropdown-icons-and-text_lghe8v.png)


###DropDown icons only
![language-picker-0 2-screen-5](https://res.cloudinary.com/lajax/image/upload/v1423508826/dropdown-icons-only_vzqksl.png)


###DropDown text only
![language-picker-0 2-screen-5](https://res.cloudinary.com/lajax/image/upload/v1423999486/dropdown-text-only_kp0lyt.png)


Links
-----

- [GitHub](https://github.com/lajax/yii2-language-picker)
- [Packagist](https://packagist.org/packages/lajax/yii2-language-picker)
- [Yii Extensions](http://www.yiiframework.com/extension/yii2-language-picker)
- [Flag Sprites](http://www.flag-sprites.com)
