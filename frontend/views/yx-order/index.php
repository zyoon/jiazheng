<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\YxOrder;
/* @var $this yii\web\View */
/* @var $searchModel common\models\YxOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Yx Orders');
$this->params['breadcrumbs'][] = $this->title;
?>
<?= Html::cssFile('/static/css/order.css') ?>
<style>
  .grid-view .filters{
    display: none;
  }
</style>
<br></br>
<?php //YxOrder::testSql(38,31); ?>

<div class="yx-order-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
     <div class="yuanxiangwu-order">
       <?= GridView::widget([
          'dataProvider' => $dataProvider,
          'showHeader' => false,
          'columns' => [
              [
                  'attribute'=>'created_at',
                  'format' => 'html',
                  'value'=>function($order){
                      return
                        '<div class="order-top-header">'.
                            '<div class="created_at">'.date("Y-m-d H:i",$order->created_at).'</div>'.
                            '<div class="order_no">订单号: '.$order->order_no.'</div>'.
                            '<div class="order_name">'.$order->order_name.'</div>'.
                        '</div>';
                  }
              ],
              [
                  'attribute'=>'order_money',
                  'format' => 'html',
                  'value'=>function($order){
                      $html = '<div class="order-top-body">';
                      foreach ($order->yx_order_server as $value) {
                         if($value->is_main == 1){
                            $html = $html.
                                    '<div class="mian_server_box child">'.
                                        '<div class="item_title">服务</div>'.
                                        '<div class="server_name">服务: '.
                                                $value["server_name"].
                                        '</div>'.
                                        '<div class="server_price">价格: '.
                                                number_format($value["server_price"]/100,2).'/'.$value["server_unit"].
                                        '</div>'.
                                        '<div class="server_amount">数量: '.
                                                $value["server_amount"].
                                        '</div>'.
                                    '</div>';
                         }
                      }
                      $html = $html.'<div class="extra_server_box child">';
                      $html = $html.'<div class="item_title">附加服务</div>';
                      foreach ($order->yx_order_server as $value2) {
                         if($value2->is_main == 0){
                            $html = $html.
                                    '<div class="extra_serve_item">'.
                                        '<div class="server_name">'.
                                                $value2["server_name"].
                                        '</div>'.
                                        '<div class="server_price">'.
                                                number_format($value2["server_price"]/100,2).'/'.$value["server_unit"].
                                        '</div>'.
                                        '<div class="server_amount">* '.
                                                $value2["server_amount"].
                                        '</div>'.
                                    '</div>';

                         }
                      }
                      $html = $html.'</div>';
                      $html = $html.
                              '<div class="order_money child">'.
                                '<div class="item_title">总计</div>'.
                                '<div class="price">'.number_format($order->order_money/100,2).'元</div>'.
                              '</div>';
                      $html = $html.
                              '<div class="user_name child">'.
                                '<div class="item_title">上门时间</div>'.
                                '<div class="name">联系人: '.$order->user_name.'</div>'.
                                '<div class="phone">联系电话: '.substr($order->phone,0,3)."****".substr($order->phone,-4).'</div>'.
                                '<div class="address">地址: '.$order->address.'</div>'.
                                '<div class="start_time">上门时间: '.date("Y-m-d H:i",$order->time_start).'</div>'.
                              '</div>';
                      $html = $html.
                              '<div class="order_state child">'.
                                '<div class="item_title">订单状态</div>'.
                                '<div class="state">'.YxOrder::getStateName($order->order_state).'</div>'.
                              '</div>';
                      $html = $html.
                              '<div class="order_action child">'.
                                '<div class="item_title">操作</div>';
                                switch ($order->order_state) {
                                  case 1: //待支付
                                      $html = $html.Html::a('支付', ['payment?id='.$order->id], ['class' => 'btn btn-pay']);
                                      $html = $html.Html::a('取消订单', ['payment?id='.$order->id], ['class' => 'btn btn-cancel']);
                                      break;
                                  case 2: //待接单
                                      $html = $html.Html::a('取消订单', ['payment?id='.$order->id], ['class' => 'btn btn-cancel']);
                                      break;
                                  case 3: //申请退款

                                      break;
                                  case 4: //执行中
                                      $html = $html.Html::a('取消订单', ['payment?id='.$order->id], ['class' => 'btn btn-cancel']);
                                      break;
                                  case 5: //废单

                                      break;
                                  case 6: //未接单

                                      break;
                                  case 7: //已退款

                                      break;
                                  case 8: //已完成
                                      $html = $html.Html::a('评论', ['/yx-comment/create?order_id='.$order->id], ['class' => 'btn btn-comment']);
                                      break;
                                  case 9: //拒绝退款
                                      $html = $html.Html::a('重新退款', ['payment?id='.$order->id], ['class' => 'btn btn-cancel']);
                                      break;
                                  case 10: //已完成
                                      break;
                                  default:
                                    # code...
                                    break;
                                }
                      $html = $html.'</div>';
                      $html = $html.'</div>';
                      return $html;
                  }
              ],
          ],
          'layout'=>'{items}<div class="text-right tooltip-demo">{pager}</div>',
          'pager'=>[
              //'options'=>['class'=>'hidden']//关闭分页
              'firstPageLabel'=>"首页",
              'prevPageLabel'=>'上一页',
              'nextPageLabel'=>'下一页',
              'lastPageLabel'=>'最后一页',
          ],
      ]); ?>
     </div>

</div>


<script>
  window.onload = function(){
  }

</script>
