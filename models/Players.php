<?php
namespace app\models;

use yii\db\ActiveRecord;

class Players extends ActiveRecord
{

    public static function tableName()
    {
        return 'players';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 150],
            [['sname'], 'string', 'max' => 150],
            [['birthday'], 'string','max' => 50],
            [['position'], 'integer'],
            [['team_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Ім`я',
            'sname' => 'Прізвище',
            'birthday' => 'Дата народження',
            'position' => 'Позиція на полі',
            'team_id' => 'Team_Id',
        ];
    }

}