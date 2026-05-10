<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int $user_id
 * @property int $amount
 * @property int $pay_type_id
 * @property string $address
 * @property int $status_id
 * @property string $date_time
 * @property string $created_at
 * @property int $pay_receipt
 * @property float $total
 *
 * @property OrderItem[] $orderItems
 * @property PayType $payType
 * @property Status $status
 * @property User $user
 */
class Order extends ActiveRecord
{
    // Виртуальные поля для формы
    public $date;
    public $time;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['total'], 'default', 'value' => 0.00],
            // date и time теперь required как строки
            [['user_id', 'amount', 'pay_type_id', 'address', 'status_id', 'date', 'time'], 'required'],
            
            [['user_id', 'amount', 'pay_type_id', 'status_id', 'pay_receipt'], 'integer'],
            [['date_time', 'created_at'], 'safe'],
            [['total'], 'number'],
            [['address'], 'string', 'max' => 255],
            
            // date и time проверяем просто как строки, форматирование делаем в beforeSave
            [['date', 'time'], 'string'], 

            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::class, 'targetAttribute' => ['status_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['pay_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => PayType::class, 'targetAttribute' => ['pay_type_id' => 'id']],
            
            [
                'address',
                'match',
                'pattern' => '/^[а-яёА-ЯЁa-zA-Z\s]+,\s*\d+[а-яёА-ЯЁa-zA-Z]?(?:,\s*\d+)?$/u',
                'message' => 'Адрес должен быть в формате: "Улица, дом (номер), квартира"'
            ],
            
            // Проверка времени
            ['time', 'match', 'pattern' => '/^([01]\d|2[0-3]):[0-5]\d$/', 'message' => 'Некорректное время'],
            
            // Кастомная валидация даты (проверка диапазона)
            ['date', 'validateDateRange'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Заказ №',
            'user_id' => 'Клиент',
            'amount' => 'Количество товаров в заказе',
            'pay_type_id' => 'Способ оплаты',
            'address' => 'Адрес доставки заказа',
            'status_id' => 'Статус заказа',
            'date_time' => 'Дата и время получения заказа',
            'created_at' => 'Дата и время создания заказа',
            'pay_receipt' => 'Чек об оплате',
            'total' => 'Полная цена заказа',
            'date' => 'Дата получения заказа',
            'time' => 'Время получения заказа',
        ];
    }

    /**
     * Gets query for [[OrderItems]].
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::class, ['order_id' => 'id']);
    }

    /**
     * Gets query for [[PayType]].
     */
    public function getPayType()
    {
        return $this->hasOne(PayType::class, ['id' => 'pay_type_id']);
    }

    /**
     * Gets query for [[Status]].
     */
    public function getStatus()
    {
        return $this->hasOne(Status::class, ['id' => 'status_id']);
    }

    /**
     * Gets query for [[User]].
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Конвертация даты из БД (Y-m-d) в формат для пользователя (d.m.Y)
     */
    public function afterFind()
    {
        parent::afterFind();
        
        // Если есть сохраненная дата в date_time, разбиваем её на date и time для формы
        if ($this->date_time) {
            $dt = new \DateTime($this->date_time);
            $this->date = $dt->format('d.m.Y');
            $this->time = $dt->format('H:i');
        }
    }

    /**
     * Конвертация даты от пользователя (d.m.Y) в формат для БД (Y-m-d H:i:s)
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // Собираем date_time из виртуальных полей date и time
            if ($this->date && $this->time) {
                // Преобразуем d.m.Y в объект DateTime
                $dt = \DateTime::createFromFormat('d.m.Y H:i', $this->date . ' ' . $this->time);
                if ($dt) {
                    $this->date_time = $dt->format('Y-m-d H:i:s');
                }
            }
            return true;
        }
        return false;
    }

    /**
     * Проверка диапазона дат
     */
    public function validateDateRange($attribute)
    {
        if (!$this->$attribute) {
            return;
        }

        // Пробуем распарсить дату в формате d.m.Y
        $dt = \DateTime::createFromFormat('d.m.Y', $this->$attribute);
        
        if (!$dt || $dt->format('d.m.Y') !== $this->$attribute) {
            $this->addError($attribute, 'Некорректный формат даты. Используйте ДД.ММ.ГГГГ');
            return;
        }

        $timestamp = $dt->getTimestamp();
        $today = strtotime('today');
        $maxDate = strtotime('+3 months');

        if ($timestamp < $today) {
            $this->addError($attribute, 'Дата не может быть раньше сегодняшнего дня');
        } elseif ($timestamp > $maxDate) {
            $this->addError($attribute, 'Дата не может быть позже чем через 3 месяца');
        }
    }
}