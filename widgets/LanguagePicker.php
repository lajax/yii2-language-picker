<?php

namespace lajax\languagepicker\widgets;

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;

/**
 * Language Picker widget.
 * 
 * Examples:
 * Pre-defined button list:
 * 
 * ~~~
 * \lajax\languagepicker\widgets\LanguagePicker::widget([
 *      'skin' => \lajax\languagepicker\widgets\LanguagePicker::SKIN_BUTTON,
 *      'size' => \lajax\languagepicker\widgets\LanguagePicker::SIZE_SMALL
 * ]);
 * ~~~
 * 
 * Pre-defined DropDown list:
 * 
 * ~~~
 *  \lajax\languagepicker\widgets\LanguagePicker::widget([
 *      'skin' => \lajax\languagepicker\widgets\LanguagePicker::SKIN_DROPDOWN,
 *      'size' => \lajax\languagepicker\widgets\LanguagePicker::SIZE_LARGE
 * ]);
 * ~~~
 * 
 * Defining your own template:
 * 
 * ~~~
 *  \lajax\languagepicker\widgets\LanguagePicker::widget([
 *      'itemTemplate' => '<li><a href="{link}"><i class="{language}" title="{language}"></i> {name}</a></li>',
 *      'activeItemTemplate' => '<a href="{link}" title="{language}"><i class="{language}"></i> {name}</a>',
 *      'parentTemplate' => '<div class="language-picker dropdown-list {size}"><div>{activeItem}<ul>{items}</ul></div></div>',
 *       
 *      'languageAsset' => 'lajax\languagepicker\bundles\LanguageLargeIconsAsset',      // StyleSheets
 *      'languagePluginAsset' => 'lajax\languagepicker\bundles\LanguagePluginAsset',    // JavasSripts
 * ]);
 * ~~~
 * 
 * 
 * @author Lajos Molnar <lajax.m@gmail.com>
 * @since 1.0
 */
class LanguagePicker extends \yii\base\Widget
{

    /**
     * Type of pre-defined skins (drop down list).
     */
    const SKIN_DROPDOWN = 'dropdown';

    /**
     * Type of pre-defined skins (button list).
     */
    const SKIN_BUTTON = 'button';

    /**
     * Size of pre-defined skins (small).
     */
    const SIZE_SMALL = 'small';

    /**
     * Size of pre-defined skins (large).
     */
    const SIZE_LARGE = 'large';

    /**
     * @var array List of pre-defined skins.
     */
    private $_SKINS = [
        self::SKIN_DROPDOWN => [
            'itemTemplate' => '<li><a href="{link}" title="{language}"><i class="{language}"></i> {name}</a></li>',
            'activeItemTemplate' => '<a href="" title="{language}"><i class="{language}"></i> {name}</a>',
            'parentTemplate' => '<div class="language-picker dropdown-list {size}"><div>{activeItem}<ul>{items}</ul></div></div>',
        ],
        self::SKIN_BUTTON => [
            'itemTemplate' => '<a href="{link}" title="{language}"><i class="{language}"></i> {name}</a>',
            'activeItemTemplate' => '<a href="{link}" title="{language}" class="active"><i class="{language}"></i> {name}</a>',
            'parentTemplate' => '<div class="language-picker button-list {size}"><div>{items}</div></div>',
        ],
    ];

    /**
     * @var array List of pre-defined skins.
     */
    private $_SIZES = [
        self::SIZE_SMALL => 'lajax\languagepicker\bundles\LanguageSmallIconsAsset',
        self::SIZE_LARGE => 'lajax\languagepicker\bundles\LanguageLargeIconsAsset',
    ];

    /**
     * @var string ID of pre-defined skin (optional).
     */
    public $skin;

    /**
     *
     * @var string size of the icons.
     */
    public $size;

    /**
     * @var string The structure of the parent template.
     */
    public $parentTemplate;

    /**
     * @var string The structure of one entry in the list of language elements.
     */
    public $itemTemplate;

    /**
     * @var string The structure of the active language element.
     */
    public $activeItemTemplate;

    /**
     * example: http://www.yiiframework.com/doc-2.0/guide-structure-assets.html
     * @var string Adding StyleSheet and its dependencies.
     */
    public $languageAsset;

    /**
     * example: http://www.yiiframework.com/doc-2.0/guide-structure-assets.html
     * @var string Adding JavaScript and its dependencies.
     * Changing languages is done through Ajax by default. If you do not wish to use Ajax, set value to null.
     */
    public $languagePluginAsset = 'lajax\languagepicker\bundles\LanguagePluginAsset';

    /**
     * @var array List of available languages.
     *  Formats supported in the pre-defined skins:
     * 
     * ~~~
     *  ['en', 'de', 'es']
     *  ['en' => 'English', 'de' => 'Deutsch', 'fr' => 'Français']
     *  ['en-US', 'de-DE', 'fr-FR']
     *  ['en-US' => 'English', 'de-DE' => 'Deutsch', 'fr-FR' => 'Français']
     * ~~~
     */
    public $languages;

    /**
     * @var boolean whether to HTML-encode the link labels.
     */
    public $encodeLabels = true;

    /**
     * @inheritdoc
     */
    public static function widget($config = array())
    {
        if (empty($config['languages']) || !is_array($config['languages'])) {
            $config['languages'] = Yii::$app->languagepicker->languages;
        }

        return parent::widget($config);
    }

    /**
     * @inheritdoc
     */
    public function init()
    {

        $this->_initSkin();

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $isInteger = is_integer(key($this->languages));
        if ($isInteger) {
            $this->languages = array_flip($this->languages);
        }

        if ($this->skin == self::SKIN_BUTTON) {
            $languagePicker = $this->_renderButton($isInteger);
        } else {
            $languagePicker = $this->_renderDropdown($isInteger);
        }

        echo $languagePicker;
    }

    /**
     * Rendering button list.
     * @param boolean $isInteger
     * @return string
     */
    private function _renderButton($isInteger)
    {
        $items = '';
        foreach ($this->languages as $language => $name) {
            $name = $isInteger ? '' : $name;
            $template = Yii::$app->language == $language ? $this->activeItemTemplate : $this->itemTemplate;
            $items .= $this->renderItem($language, $name, $template);
        }

        return strtr($this->parentTemplate, ['{items}' => $items, '{size}' => $this->size]);
    }

    /**
     * Rendering dropdown list.
     * @param boolean $isInteger
     * @return string
     */
    private function _renderDropdown($isInteger)
    {
        $items = $activeItem = '';
        foreach ($this->languages as $language => $name) {
            $name = $isInteger ? '' : $name;
            if (Yii::$app->language == $language) {
                $activeItem = $this->renderItem($language, $name, $this->activeItemTemplate);
            } else {
                $items .= $this->renderItem($language, $name, $this->itemTemplate);
            }
        }

        return strtr($this->parentTemplate, ['{activeItem}' => $activeItem, '{items}' => $items, '{size}' => $this->size]);
    }

    /**
     * Initialising skin.
     */
    private function _initSkin()
    {

        if ($this->skin && empty($this->_SKINS[$this->skin])) {
            throw new \yii\base\InvalidConfigException('The skin does not exist: ' . $this->skin);
        }

        if ($this->size && empty($this->_SIZES[$this->size])) {
            throw new \yii\base\InvalidConfigException('The size does not exist: ' . $this->size);
        }

        if ($this->skin) {
            foreach ($this->_SKINS[$this->skin] as $property => $value) {
                if (!$this->$property) {
                    $this->$property = $value;
                }
            }
        }

        if ($this->size) {
            $this->languageAsset = $this->_SIZES[$this->size];
        }

        $this->_registerAssets();
    }

    /**
     * Adding Assets files to view.
     */
    private function _registerAssets()
    {

        if ($this->languageAsset) {
            $this->view->registerAssetBundle($this->languageAsset);
        }

        if ($this->languagePluginAsset) {
            $this->view->registerAssetBundle($this->languagePluginAsset);
        }
    }

    /**
     * Rendering languege element.
     * @param string $language The property of a given language.
     * @param string $name The property of a language name.
     * @param string $template The basic structure of a language element of the displayed language picker
     * Elements to replace: "{link}" URL to call when changing language.
     *  "{name}" name corresponding to a language element, e.g.: English
     *  "{language}" unique identifier of the language element. e.g.: en, en-US
     * @return string the rendered result
     */
    protected function renderItem($language, $name, $template)
    {

        if ($this->encodeLabels) {
            $language = Html::encode($language);
            $name = Html::encode($name);
        }

        $params = array_merge([''], Yii::$app->request->queryParams, ['language-picker-language' => $language]);
        return strtr($template, [
            '{link}' => Url::to($params),
            '{name}' => $name,
            '{language}' => $language,
        ]);
    }

}
