Yii2 MatchHeight ListView Widget
======================
http://nerburish.com/yii2-matchheight-listview-widget/ en 🇪🇸

ListView widget improved to use Jquery MatchHeight.js (http://brm.io/jquery-match-height/)

Demo Screenshot:
![macth-height-view-demo](https://cloud.githubusercontent.com/assets/5610788/17892390/54c73df0-6941-11e6-8f2b-e2345b3b60de.png)

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist nerburish/yii2-match-height-view "dev-master"
```

or add

```
"nerburish/yii2-match-height-view": "dev-master"
```

to the require section of your `composer.json` file.


Usage
-----

The usage is similar to default ListView Widget (http://www.yiiframework.com/doc-2.0/yii-widgets-listview.html)

You just need a dataProvider and prepare the item template for your model.

In clientOptions you can pass the MatchHeight.js options to modify the plugin behavior (see https://github.com/liabru/jquery-match-height#options)

You can also attach a cssFile for styling the grid.

Exemple:

We have this model:
```
class MyModel extends \yii\base\Theme
{
	public $id;
	
	public $title;
	
	public $description;
}
```
And this item template named _item.php:
```
<h3><?= $model->title ?></h3>
<p><?= $model->description ?></p>
```
Then in our view, we run the widget:
```
<?php echo \nerburish\matchheight\MatchHeightView::widget([
	'dataProvider' => $dataProvider,
	'itemView' => '_item',
	'cssFile' => [
		"@web/css/grid-demo.css"		
	]
]) ?>
```
The css used for the demo:
```
/* ---- grid ---- */
.grid {
  box-sizing: border-box;
}

/* clearfix */
.grid:after {
  content: '';
  display: block;
  clear: both;
}

/* ---- grid-item ---- */
.grid-item {
  width: 24%;
  padding: 10px;
  margin: 0.5%;
  float: left;
  background: #e4e4e4;
  border-radius: 5px;
}
```
You may also be interested in Masonry.js ListView widget: https://github.com/nerburish/yii2-masonry-view



 
