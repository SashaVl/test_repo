<?php
namespace app\models;

use yii\db\ActiveRecord;

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
    public function delFromTeam($id)
    {
        $players = Players::find()->where(['team_id' => $id])->all();
        foreach($players as $key => $val)
        {
            $val->delete();
        }
    }
}