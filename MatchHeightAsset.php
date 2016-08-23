<?php
/**
 * @copyright Copyright (c); nerburish, 2016
 * @package yii2-match-height
 */

namespace nerburish\matchheight;

use yii\web\AssetBundle;

/**
 * Asset bundle for matchHeight.js (http://brm.io/jquery-match-height-demo/)
 *
 * @package nerburish\match-height-view
 */
class MatchHeightAsset extends AssetBundle
{
    public $sourcePath = '@bower/matchHeight';
    
    public $js = [
        'jquery.matchHeight-min.js',
    ];
	
    public $depends = [
        'yii\web\JqueryAsset'
    ];	
}