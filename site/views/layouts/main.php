<?php
/**
 * main.php
 *
 * Основное расположение сайта
 *
 * @date 24.08.2018
 * @time 11:24
 * @since 1.0.0
 *
 * @var $this \yii\web\View
 * @var $content string
 */

use app\widgets\Alert;
use yii\bootstrap\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\rbac\Permissions;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::t('app', 'BV'),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    $items = [];
    if (Yii::$app->user->isGuest) {
        $items[] = ['label' => Yii::t('app', 'Login'), 'url' => ['/site/login']];
    } else {
        $user = Yii::$app->user;
        if ($user->can(Permissions::PERMISSION_CITY_LIST)) {
            $items[] = ['label' => 'Города', 'url' => ['/city/']];
        }
        if ($user->can(Permissions::PERMISSION_USERS_LIST)) {
            $items[] = ['label' => 'Пользователи', 'url' => ['/user/']];
        }
        if ($user->can(Permissions::PERMISSION_GROUP_LIST)) {
            $items[] = ['label' => 'Группа', 'url' => ['/group/']];
        }
        if ($user->can(Permissions::PERMISSION_REGCODE_LIST)) {
            $items[] = ['label' => 'Коды', 'url' => ['/regcode/']];
        }
        if ($user->can(Permissions::PERMISSION_JAPA_LIST)) {
            $items[] = ['label' => 'Круги', 'url' => ['/japa/']];
        }
        $items[] = ['label' => 'Связь', 'url' => ['/contact/']];
        $items[] = ['label' => 'Статистика', 'url' => ['/market/demo']];
        if ($user->can(Permissions::PERMISSION_STATISTICS_AGG)) {
            $items[] = ['label' => 'Аналитика', 'url' => ['/statistics']];
        }

        $items2 = [];
        $logout = (
            Html::beginTag('li') .
            Html::beginForm(['/site/logout'], 'post') .
            Html::submitButton(
                Yii::t('app', 'Logout ({name})',
                    ['name' => $user->getIdentity(false)->username]),
                ['class' => 'btn logout']
            ) .
            Html::endForm() .
            Html::endTag('li')
        );
        $items2[] = $logout;
        if ($user->can(Permissions::PERMISSION_PROFILE_UPDATE, ['userId' => $user->id])) {
            $items2[] = ['label' => 'Профиль', 'url' => ['/profile/view', 'id' => $user->id]];
        }
        if ($user->can(Permissions::PERMISSION_ACTIVITY_VIEW)) {
            $items2[] = ['label' => 'Активность', 'url' => ['/activity/']];
        }
        $items2[] = ['label' => 'О проекте', 'url' => ['/about/project']];
        if ($user->can(Permissions::PERMISSION_SYSTEM_ABOUT)) {
            $items2[] = ['label' => 'О системе', 'url' => ['/about/']];
        }
        $items2[] = [
            'label' => 'Заблокировать',
            'url' => ['/user/block'],
            'options' => ['class' => 'block-link']
        ];

        $items[] = [
            'label' => Html::icon('user'),
            'encode' => false,
            'items' => $items2,
        ];
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $items,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Бхакти-врикша <?= date('Y') ?></p>
        <p class="pull-right">
            <?php echo $this->render('/counters/liveinternet'); ?>
        </p>
    </div>
</footer>

<?php $this->endBody() ?>

<?php
echo $this->render('/counters/google-analytics');
?>

</body>
</html>
<?php $this->endPage() ?>
