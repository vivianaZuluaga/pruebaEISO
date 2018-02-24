<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\VentasUsuarios;
use app\models\User;


/**
 * VentasUsuariosSearch represents the model behind the search form about `app\models\VentasUsuarios`.
 */
class VentasUsuariosSearch extends VentasUsuarios
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'cantidad'], 'integer'],
            [['usuario_id', 'producto_id', 'ciudad', 'fecha_venta'], 'safe'],
            [['valor'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = VentasUsuarios::find();
        $user_id = Yii::$app->user->identity->cedula;

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        //El administrador podra ver las ventas realizadas por todos los usuarios
        if(User::isUserAdmin(Yii::$app->user->identity->cedula))
          {
            $query->andFilterWhere(['like', 'usuarios.nombre', $this->usuario_id]);
          }else{
            $query->andFilterWhere(['=', 'ventas_usuarios.usuario_id', $user_id]);
          }

        $query->joinWith('ciudad0');
        $query->joinWith('producto');

        // grid filtering conditions
        $query->andFilterWhere([
            'ventas_usuarios.id' => $this->id,
            'ventas_usuarios.cantidad' => $this->cantidad,
            'ventas_usuarios.fecha_venta' => $this->fecha_venta,
            'ventas_usuarios.valor' => $this->valor,
        ]);

        $query->andFilterWhere(['like', 'ciudades.nombre_municipio', $this->ciudad])
              ->andFilterWhere(['like', 'productos.nombre', $this->producto_id]);

        return $dataProvider;
    }
}
