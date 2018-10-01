<?php
/**
 * step2.php
 *
 * Шаг 2 при регистрации пользователя: чтение информации о проекте
 *
 * Created by PhpStorm.
 * @date 15.08.18
 * @time 12:42
 */

use \yii\bootstrap\Html;

$this->title = 'Регистрация. Шаг 2 из 6';
$this->params['breadcrumbs'][] = $this->title;

?>
    <h2>Центр развития рынка Святого Имени. ИСККОН (Россия)</h2>
    <br>
    <p>Вы зашли на сайт &laquo;Центра развития рынка Святого Имени. ИСККОН (Россия)&raquo;.</p>
    <p>Спасибо, что согласились принять участие в этом проекте!</p>
    <p>Чтобы начать пользоваться сайтом, Вам необходимо пройти регистрацию, которая
        состоит из 6 шагов.</p>
    <br>

<?= Html::a('Отмена',
    ['/'],
    ['class' => 'btn btn-default', 'style' => 'margin-right:5px;']
); ?>
<?= Html::a('Далее', ['registration/step3'], ['class' => 'btn btn-success']); ?>