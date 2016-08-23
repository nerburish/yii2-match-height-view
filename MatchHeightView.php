<?php
/**
 * @copyright Copyright (c); nerburish, 2016
 * @package yii2-masonry-view
 */

namespace nerburish\matchheight;

use yii\widgets\ListView;
use nerburish\matchheight\MatchHeightAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * ListView widget improved to use Jquery MatchHeight.js (http://brm.io/jquery-match-height/)
 *
 * @package nerburish\match-height-view
 */
class MatchHeightView extends ListView
{
    const DEFAULT_GRID_CLASS = 'grid';
	
	const DEFAULT_ITEM_CLASS = 'grid-item';
	
	/**
    * @var string the jquery selector where will be initialized matchHeightPlugin plugin
    */
    public $itemSelector;	
	
	/**
    * @var array the HTML attributes (name-value pairs) for the field container tag.
    * The values will be HTML-encoded using [[Html::encode()]].
    * If a value is null, the corresponding attribute will not be rendered.
    */
    public $options = [];
	
	/**
    * @var array the HTML attributes (name-value pairs) for the grid container tag.
    * The values will be HTML-encoded using [[Html::encode()]].
    */
    public $gridOptions = [];	

    /**
    * @var array parameters accepted by MatchHeight.js plugin
	* @see see https://github.com/liabru/jquery-match-height#options
    */
    public $clientOptions = [];

    /**
    * @var array use it for inject a custom css style. Array accepts the same parameters as \yii\base\View::registerCssFile()
	* @see http://www.yiiframework.com/doc-2.0/yii-web-view.html#registerCssFile()-detail
    */	
	public $cssFile = [];

    /**
     * @var string the layout that determines how different sections of the list view should be organized.
     * The following tokens will be replaced with the corresponding section contents:
     *
     * - `{summary}`: the summary section. See [[renderSummary()]].
     * - `{items}`: the list items. See [[renderItems()]].
     * - `{sorter}`: the sorter. See [[renderSorter()]].
     * - `{pager}`: the pager. See [[renderPager()]].
     */	
	public $layout;    
	
	/**
     * Initializes the widget.
     * If you override this method, make sure you call the parent implementation first.
     */
    public function init()
    {
		if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        } 
		
		if (!isset($this->gridOptions['class'])) {
			$this->gridOptions['class'] = self::DEFAULT_GRID_CLASS;		
		}

		if (!isset($this->itemOptions['class'])) {
			$this->itemOptions['class'] = self::DEFAULT_ITEM_CLASS;		
		}		
		
		if (empty($this->layout)) {					
			$tag = ArrayHelper::remove($this->gridOptions, 'tag', 'div');
			
			$gridContainer = Html::tag($tag, '{items}', $this->gridOptions);
			
			$this->layout = "{summary}$gridContainer\n{pager}";
		}
			
		if (empty($this->itemSelector)) {
			$this->itemSelector = '#'. $this->id . ' .'. $this->gridOptions['class'] .' .'. $this->itemOptions['class'];
		}

        parent::init();
    }
	
    /**
     * Runs the widget.
     */
    public function run()
    {
        if ($this->showOnEmpty || $this->dataProvider->getCount() > 0) {
            $content = preg_replace_callback("/{\\w+}/", function ($matches) {
                $content = $this->renderSection($matches[0]);
                return $content === false ? $matches[0] : $content;
            }, $this->layout);
        } else {
            $content = $this->renderEmpty();
        }
        $options = $this->options;
        $tag = ArrayHelper::remove($options, 'tag', 'div');
        echo Html::tag($tag, $content, $options);
		$this->registerWidget();
    }	
	
	/**
    * Register assets and initialize the widget
    */
    protected function registerWidget()
    {
		$id = $this->options['id'];
		$itemSelector = $this->itemSelector;
		
		$view = $this->getView();
		
        MatchHeightAsset::register($view);
        $js = [];
        
        $options = Json::encode($this->clientOptions);
		
		$js[] = "$('$itemSelector').matchHeight($options)";

        $view->registerJs(implode("\n", $js),$view::POS_READY);
		
		if (!empty($this->cssFile)) {
			call_user_func_array([$view, "registerCssFile"], $this->cssFile);
		} 		
    }	
}