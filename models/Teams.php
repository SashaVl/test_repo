<?php
namespace app\models;

use yii\db\ActiveRecord;
use app\models\Players;

class Teams extends ActiveRecord
{

    public static function tableName()
    {
        return 'teams';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 150],
            [['year_create'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Назва команди',
            'year_create' => 'Рік заснування',
        ];
    }
    public function countOfPlayers($id)
    {
        return Players::find()->where(['team_id' => $id])->count('*');
    }

}