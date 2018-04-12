<?php
    
    /* @var $this yii\web\View */
    
    use aki\vue\Vue;
    
    use antkaz\vue\VueAsset;
    
    VueAsset::register($this);
?>
<style type="text/css">
  td {
    width: 125px;
  }

  .vm {
    width: 500px;
    float: left;
  }

  .user {
    width: 500px;
    float: left;
  }

  button {
    padding: 0.1em 0.5em;
    margin: 0.1em;
  }
</style>
<div id="app" class="vue">

  <div class="message">
    <h2 class="error-summary">
      <b v-html="message"></b>
    </h2>
  </div>

  <div class="vm">
    <div class="products">
      <h2>Продукты в VM</h2>
      <table>
        <tr>
          <td>Продукт</td>
          <td>Доступно</td>
          <td>Стоимость</td>
          <td>Действие</td>
        </tr>
        <tr>
          <td>Чай</td>
          <td>{{ data['vm']['products']['tea']['count'] }}шт.</td>
          <td>{{ data['vm']['products']['tea']['price'] }}р.</td>
          <td>
            <button v-on:click="order" data-type="tea">Купить</button>
          </td>
        </tr>
        <tr>
          <td>Кофе</td>
          <td>{{ data['vm']['products']['coffee']['count'] }}шт.</td>
          <td>{{ data['vm']['products']['coffee']['price'] }}р.</td>
          <td>
            <button v-on:click="order" data-type="coffee">Купить</button>
          </td>
        </tr>
        <tr>
          <td> Кофе с молоком</td>
          <td>{{ data['vm']['products']['white_coffee']['count'] }}шт.</td>
          <td>{{ data['vm']['products']['white_coffee']['price'] }}р.</td>
          <td>
            <button v-on:click="order" data-type="white_coffee">Купить</button>
          </td>
        </tr>
        <tr>
          <td>Сок</td>
          <td>{{ data['vm']['products']['juice']['count'] }}шт.</td>
          <td>{{ data['vm']['products']['juice']['price'] }}р.</td>
          <td>
            <button v-on:click="order" data-type="juice">Купить</button>
          </td>
        </tr>
      </table>
    </div>
    <div class="wallet">
      <h2>"Кошелёк" VM</h2>
      <table>
        <tr>
          <td>Номинал</td>
          <td>Колличество</td>
        </tr>
        <tr>
          <td>1р:</td>
          <td>{{ data['vm']['wallet'][1] }}</td>
        </tr>
        <tr>
          <td>2р:</td>
          <td>{{ data['vm']['wallet'][2] }}</td>
        </tr>
        <tr>
          <td>5р:</td>
          <td>{{ data['vm']['wallet'][5] }}</td>
        </tr>
        <tr>
          <td>10р:</td>
          <td>{{ data['vm']['wallet'][10] }}</td>
        </tr>
      </table>
      <h3>
        Остаток в VM: {{ data['vm']['wallet']['sum'] }}р
      </h3>
    </div>
    <div class="op_wallet">
      <h2>Операционный кошелёк</h2>
      <table>
        <tr>
          <td>Номинал</td>
          <td>Колличество</td>
        </tr>
        <tr>
          <td>1р:</td>
          <td>{{ data['vm']['op_wallet'][1] }}</td>
        </tr>
        <tr>
          <td>2р:</td>
          <td>{{ data['vm']['op_wallet'][2] }}</td>
        </tr>
        <tr>
          <td>5р:</td>
          <td>{{ data['vm']['op_wallet'][5] }}</td>
        </tr>
        <tr>
          <td>10р:</td>
          <td>{{ data['vm']['op_wallet'][10] }}</td>
        </tr>
      </table>
      <h3>
        <table>
          <tr>
            <td>Внесенная сумма: {{ data['vm']['op_wallet']['sum'] }}р</td>
            <td>
              <button v-on:click="toreturn">Возврат</button>
            </td>
          </tr>
        </table>
      </h3>
    </div>
  </div>
  <div class="user">
    <div class="wallet">
      <h2>Кошелёк пользователя</h2>
      <table>
        <tr>
          <td>Номинал</td>
          <td>Колличество</td>
          <td>Действие</td>
        </tr>
        <tr>
          <td>1р:</td>
          <td>{{ data['user'][1] }}шт.</td>
          <td>
            <button v-on:click="put" data-denomination="1">Внести</button>
          </td>
        </tr>
        <tr>
          <td>2р:</td>
          <td>{{ data['user'][2] }}шт.</td>
          <td>
            <button v-on:click="put" data-denomination="2">Внести</button>
          </td>
        </tr>
        <tr>
          <td>5р:</td>
          <td>{{ data['user'][5] }}шт.</td>
          <td>
            <button v-on:click="put" data-denomination="5">Внести</button>
          </td>
        </tr>
        <tr>
          <td>10р:</td>
          <td>{{ data['user'][10] }}шт.</td>
          <td>
            <button v-on:click="put" data-denomination="10">Внести</button>
          </td>
        </tr>
      </table>
      <h3>
        В кошельке: {{ data['user']['sum'] }}р
      </h3>
      <div v-show="data['user']['sum']==0">
        <button v-on:click="vmreset">Сброс ВМ</button>
      </div>
    </div>
  </div>

</div>


<script>
  app = new Vue({
    debug: true,
    el: '#app',
    data() {
      return {
        message: "&nbsp",
        data: {
          user: { "1": 0, "2": 0, "5": 0, "10": 0 },
          vm: {
            wallet: { "1": 0, "2": 0, "5": 0, "10": 0 },
            op_wallet: { "1": 0, "2": 0, "5": 0, "10": 0 },
            products: [
              { tea: { price: 0, count: 0 } },
              { coffee: { price: 0, count: 0 } },
              { white_coffee: { price: 0, count: 0 } },
              { juice: { price: 0, count: 0 } },
            ],
          },
        },
      }
    },
    created() {
      this.load();
    },
    methods: {
      vmreset: function () {
        const self = this;
        axios.get('/site/reset', {})
          .then(function (response) {
            if (response.data.status === 200) {
              self.data = response.data;
              self.message = "&nbsp;";
            } else {
              self.message = response.data.message;
            }
            console.log(response.data);
          })
          .catch(function (error) {
            self.message = "Ошибка выполнения запроса";
            console.log(error);
          });
      },
      toreturn: function (event) {
        const self = this;
        self.message = "&nbsp";
        axios.get('/site/return')
          .then(function (response) {
            self.data = response.data;
            console.log(response.data);
          })
          .catch(function (error) {
            console.log(error);
          });
      },
      order: function (event) {
        let product = event.target.dataset.type;
        const self = this;
        self.message = "&nbsp";
        axios.get('/site/order', {
          params: {
            type: product,
          },
        })
          .then(function (response) {
            if (response.data.status === 200) {
              self.data = response.data;
            } else {
              self.message = response.data.message;
            }
            console.log(response.data);
          })
          .catch(function (error) {
            self.message = "Ошибка выполнения запроса";
            console.log(error);
          });
      },
      put: function (event) {
        let denomination = event.target.dataset.denomination;
        const self = this;
        self.message = "&nbsp";
        axios.get('/site/put', {
          params: {
            denomination: denomination,
          },
        })
          .then(function (response) {
            if (response.data.status === 200) {
              self.data = response.data;
            } else {
              self.message = response.data.message;
            }
            console.log(response.data);
          })
          .catch(function (error) {
            self.message = "Ошибка выполнения запроса";
            console.log(error);
          });
      },
      load: function () {
        const self = this;
        axios.get('/site/state', {})
          .then(function (response) {
            if (response.data.status === 200) {
              self.data = response.data;
            } else {
              self.message = response.data.message;
            }
            console.log(response.data);
          })
          .catch(function (error) {
            self.message = "Ошибка выполнения запроса";
            console.log(error);
          });
      },
    },
  })
</script>