<?php
/**
 * project.php
 *
 * Информация о проекте
 *
 * Created by PhpStorm.
 * @date 10.10.18
 * @time 17:04
 * @since 1.1.0
 *
 * @var \yii\web\View $this
 */

use \yii\helpers\Html;

$this->title = 'О проекте';
$this->params['breadcrumbs'][] = $this->title;

echo Html::tag('h2', $this->title);

?>

<p>Дорогие друзья, мы рады приветствовать Вас на сайте &laquo;Центр развития рынка Святого Имени&raquo;,
    посвященному развитию программы Бхакти-врикша. С помощью этого сайта Вы
    сможете наблюдать за развитием групп духовного общения, как в своем городе, так и в других
    городов России.</p>

<p>Мы хотим сделать сайт полезным и удобным, поэтому будем очень рады Вашим замечаниям и
    предложениям. Также, если Вы хотите присоединиться к нашей команде для выполнения очень
    важного служения, <?= Html::a('напишите нам', ['/contact/']) ?></p>

