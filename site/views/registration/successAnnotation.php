<?php
/**
 * successAnnotation.php
 *
 * Финальная страница регистрации
 *
 * Created by PhpStorm.
 * @date 15.08.18
 * @time 15:58
 */

$this->title = 'Регистрация. Завершение';
$this->params['breadcrumbs'][] = $this->title;
$eml = Yii::$app->params['adminEmail'];

?>
<h2>Поздравляем, Вы успешно прошли регистрацию!</h2>
<br>
<p>Чтобы пользоваться сайтом, Вам необходимо активировать свою учетную запись</p>
<p>Для этого проверьте свою почту и перейдите по ссылке, указанной в письме.</p>
<p>Если письма нет, проверьте папку со Спамом. Если в спаме нет,
    <a href="mailto:<?= $eml ?>">обратитесь в техподдержку</a>.</p>
<br>
<p>Благодарим Вас за терпение и настойчивость!</p>
