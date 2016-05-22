<div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
<?php echo $chapter_name;?>        
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> 控制台</a></li>
            <li><a href="<?php echo site_url('Course/query_course')?>">章节：<?php echo $chapter_name;?></a></li>
            <li class="active">章节列表</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
        <div class="row">
          <a class="btn btn-app" id="newQuestion">
            <i class="fa  fa-plus-square-o"></i> 新增题目
          </a>
          <a class="btn btn-app" href="<?php echo site_url("Testpaper/mycode_result/$chapter_id")?>">
            <i class="fa fa-barcode"></i> 我的提取码
          </a>
          <a class="btn btn-app" href="">
            <i class="fa fa-share-alt"></i> 分享本章
          </a>
        </div>
          <div class="row">
              <?php foreach ($res as $num=>$item):?>
                <div class="col-md-6">
                  <!-- DIRECT CHAT -->
                  <div class="box box-default direct-chat direct-chat-warning">
                    <div class="box-header with-border">
                      <h3 class="box-title1">第<?php echo $num+1 ?>题</h3>
                      <div class="pull-right">
                        <div class="btn-group">
                         <button type="button" class="btn btn-default" attr="<?php echo $item['id']?>" id="edit"><i class="fa fa-edit"></i></button>
                         <button type="button" class="btn btn-default" attr="<?php echo $item['id']?>" id="delete"><i class="fa fa-trash"></i></button>
                        </div>
                      </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                  <ul class="nav nav-pills nav-stacked">
                    <li><a>题目类型 <span class="pull-right text-black"><strong><?php switch ($item['type']) {case 0:echo '选择';break;case 1:echo '判断';break;case 2:echo '填空';break;} ?></strong></span></a></li>
                    <li><a>题目详情 </a></li>
                  </ul>
                      <div class="direct-chat-messages">

                      <?php echo $item['content']?>

                      </div>
                      
                  <ul class="nav nav-pills nav-stacked">
                  <li></li>
                    <li><a>正确答案<span class="pull-right text-black"><strong><?php if($item['type']==1){if($item['answer']=='T') echo "正确"; else echo "错误";} else echo $item['answer'];?></strong></span></a></li>
      
                    <li><a><div class="progress-group">
                        <span class="progress-text">总情况</span>
                        <span class="progress-number"><b><?php echo $item['correct']?></b>/<?php echo $item['sum'];?></span>
                        <div class="progress sm">
                          <div class="progress-bar progress-bar-aqua" style="width:  <?php echo $item['percentation']?>%"></div>
                        </div>
                      </div></a></li>
                      
                      <li><a><div class="progress-group">
                        <span class="progress-text">最近情况（最近一张试卷）</span>
                        <span class="progress-number"><b><?php echo $item['recent_correct']?></b>/<?php echo $item['recent_sum'];?></span>
                        <div class="progress sm">
                          <div class="progress-bar progress-bar-red" style="width:  <?php echo $item['percentation_re']?>%"></div>
                        </div>
                      </div></a></li> 
                  </ul>
                    </div><!-- /.box-body -->

                  </div><!--/.direct-chat -->
                </div>
             <?php endforeach; ?>
          </div><!-- /.row -->
 
        </section><!-- /.content -->
      </div>
      

      
      <script>
      $(document).ready(function(){
    	  $("button#edit").on("click",function(event){
        	  var id = $(event.currentTarget).attr("attr");
    		  window.open ('<?php echo site_url('Question/show_update_question').'/'?>'+id, 'newwindow', 'height=600, width=1000, top=0, left=200, toolbar=no, menubar=no, scrollbars=no,location=no, status=no')  
       	});


    	  $("button#delete").on("click",function(event){
    		  var id = $(event.currentTarget).attr("attr");
    		  if(confirm("您确定删除题目吗？")){
    		  $.ajax({
                  type: 'POST',
                  url: "<?php echo site_url('Question/delete_question')?>",
                  data:{
                      question_id:id,
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

        $("a#newQuestion").on("click",function(){
    		  window.open ('<?php echo site_url('Question/show_insert_question').'/'.$chapter_id;?>', 'newwindow', 'height=600, width=1000, top=0, left=200, toolbar=no, menubar=no, scrollbars=no,location=no, status=no')  
              
    	});

      });
      
      </script>
      