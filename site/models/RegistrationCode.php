<?php
/**
 * RegistrationCode.php
 *
 * Created by PhpStorm.
 * @date 08.08.18
 * @time 16:20
 */

namespace app\models;

use app\components\GetConfigParamTrait;
use yii\db\ActiveRecord;
use Yii;
use yii\db\Expression;

/**
 * Class RegistrationCode
 *
 * Единовременные коды регистрации для пользователей
 *
 * @package app\models
 * @since 1.0.0
 *
 * @property int $userId Идентификатор лидера группы
 * @property int $code Код регистрации
 * @property string $expiredAt Время действия кода
 *
 * @property-read bool $isValid Проверяет действительность кода регистрации
 */
class RegistrationCode extends ActiveRecord
{
    use GetConfigParamTrait;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userId', 'code', 'expiredAt'], 'required'],
            [
                'userId',
                'exist',
                'targetAttribute' => 'id',
                'targetClass' => User::class,
                'message' => Yii::t('app', 'User should be created or active'),
                'filter' => ['<>', 'status', User::STATUS_BLOCKED],
            ],
            [
                'code',
                'unique',
                'when' => function () {
                    return $this->getIsNewRecord();
                }
            ],
            [
                'expiredAt',
                'integer',
                'min' => time() + 1,
                'when' => function () {
                    return $this->getIsNewRecord();
                }
            ],
        ];
    }

    /**
     * Проверяет действительность кода регистрации
     * @return bool
     */
    public function getIsValid()
    {
        if ($this->getIsNewRecord()) {
            return false;
        }
        return strtotime($this->expiredAt) > time();
    }

    /**
     * Фабричный метод. Создает код регистрации пользователя
     *
     * @param int $userId Идентификатор пользователя-лидера
     * @param int $length Длина кода регистрации. По-умолчанию 4
     * @return static
     */
    public static function create($userId, $length = 4)
    {
        return new static([
            'userId' => $userId,
            'expiredAt' => time() + static::getConfigParam('regCodeLifeTime', 1),
            'code' => static::generateCode($length),
        ]);
    }

    /**
     * Очищает таблицу от просроченных кодов регистрации
     * @return int
     * @throws \yii\db\Exception
     */
    public static function clearExpired()
    {
        return Yii::$app->db->createCommand()
            ->delete(static::tableName(), ['<', 'expiredAt', new Expression('NOW()')])
            ->execute();
    }

    /**
     * Создает код регистрации
     *
     * @param int $length Длина кода регистрации
     * @return string
     */
    protected static function generateCode($length)
    {
        $code = '';
        while (--$length >= 0) {
            $code .= (string)rand(0, 9);
        }
        return $code;
    }
}