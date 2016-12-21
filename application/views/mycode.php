<div class="content-wrapper">
       <section class="content-header">
    <h1>
            <?php echo $chapter_name?>的全部试卷
            <small>答题详情</small>
            </h1>
</section>

<section class="content">
<div class="row">
   <?php foreach ($res as $num=>$item):?>
    <div class="col-xs-6">
              <div class="box box-success box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php echo $num+1?>. 提取码<?php echo $item['accesscode']?></h3>
                  <div class="pull-right" style="padding-right: 35px;">
                        <div class="btn-group">
                         <button type="button" class="btn btn-default" attr="<?php echo $item['accesscode']?>" id="delete"><i class="fa fa-trash"></i></button>
                        </div>
                      </div>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-footer no-padding">
                  <ul class="nav nav-stacked">
                    <li><a>创建时间 <span class="label pull-right bg-aqua"><?php echo $item['create_time']?></span></a></li>
                      <li><a>截止时间 <span class="label pull-right bg-red"><?php echo $item['end_time']?></span></a></li>
                  </ul>
                  
                </div>
                <div class="box-body">
<table class="table">
                    <tbody><tr>
                      <th style="width: 10px">#</th>
                      <th>学号</th>
                      <th>姓名</th>
                      <th>答题时间</th>
                      <th>正确率</th>
                    </tr>
                    <?php foreach ($item['students'] as $index=>$student):?>
                    <tr>
                      <td><?php echo $index+1?></td>
                      <td><?php echo $student['student_id']?></td>
                      <td><?php echo $student['name']?></td>
                      <td><?php echo $student['time']?></td>
                      <td><strong><?php echo $student['right']?></strong>/<?php echo $student['all']?></td>
                    </tr>
                  <?php endforeach; ?>
                         
                  </tbody></table>
                </div><!-- /.box-body -->
                
              </div><!-- /.box -->
    </div>
  <?php endforeach; ?>
 </div>
</section>
      </div>
            <script>
      $(document).ready(function(){

    	  $("button#delete").on("click",function(event){
    		  var id = $(event.currentTarget).attr("attr");
    		  if(confirm("您确定删除该试卷记录吗？删除后对应学生情况和题目正确率会一并清除！")){
    		  $.ajax({
                  type: 'POST',
                  url: "<?php echo site_url('Testpaper/delete_accesscode')?>",
                  data:{
                      accesscode:id,
                      },
                      success: function (data) {
                      if (data.errno!==0) {
                          alert(data.error);
                          return false;
                      }
                      $(event.currentTarget).parent().parent().parent().parent().parent().fadeOut();
                  },
                  dataType: 'json'
              });
    		  }     
    	});
      });
      
      </script>