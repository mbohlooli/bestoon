<?php

  function get_title(){
    return 'نمودار';
  }
    function get_content(){

      $row = order_incomes_by_category();

?>
    <div id="chartContainer"></div>
    <?php
      $dataPoints = array();
      while($res = $row->fetch_assoc()){
          $array_object = order_incomes($res['name']);
          if($array_object){
              array_push($dataPoints, array("y" => $array_object, "label" => $res['name']));
          }
      }
    ?>
    <script type="text/javascript">

        $(function () {
            var chart = new CanvasJS.Chart("chartContainer", {
                theme: "theme2",
                animationEnabled: true,
                title: {
                    text: "دسته بندی دخل ها"
                },
                data: [
                {
                    type: "pie",
                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                }
                ]
            });
            chart.render();
        });
    </script>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <a href="http://localhost/bestoon/chart6" class="btn btn-default" style="float: right !important;"><span class=" glyphicon glyphicon-arrow-right"></span> مشاهده نمودار بعدی</a>
    <a href="http://localhost/bestoon/chart4" class="btn btn-default" style="float: left !important;">مشاهده نمودار قبلی <span class=" glyphicon glyphicon-arrow-left"></span></a>

<?php
    }
