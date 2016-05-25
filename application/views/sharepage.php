<div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
          收到一套分享
                    <small>题目来自 <?php echo $course_name?> 课程的 <?php echo $chapter_name?> 章节</small>
             <button type="button" class="btn btn-primary" id="add">
               添加到我的题库
            </button>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> 控制台</a></li>
            <li><a href="">章节：</a></li>
            <li class="active">章节列表</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
        
          <div class="row">
              <?php foreach ($question as $num=>$item):?>
                <div class="col-md-6">
                  <!-- DIRECT CHAT -->
                  <div class="box box-default direct-chat direct-chat-warning">
                    <div class="box-header with-border">
                      <h3 class="box-title1">第<?php echo $num+1 ?>题</h3>
                      
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
                  </ul>
                    </div><!-- /.box-body -->

                  </div><!--/.direct-chat -->
                </div>
             <?php endforeach; ?>
          </div><!-- /.row -->
 
        </section><!-- /.content -->
      </div>
      
      
<!-- 模态框（Modal） -->
<div class="modal fade" id="identifier" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" 
               data-dismiss="modal" aria-hidden="true">
                  &times;
            </button>
            <h4 class="modal-title" id="myModalLabel">
               您收到一套分享的题目
            </h4>
         </div>
         <div class="modal-body">
            请问您是否预览该题目？
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-primary pull-left" id="show">
               预览
            </button>
            <button type="button" class="btn btn-primary pull-left" id="add">
               不预览，直接添加
            </button>
            <button type="button" class="btn btn-default pull-right" 
               data-dismiss="modal">取消
            </button>
         </div>
      </div><!-- /.modal-content -->
</div><!-- /.modal -->
</div>

<script>
$(document).ready(function(){
	$("section.content").hide();
	$('#identifier').modal('show');
	$("button#show").click(function(){
		$("section.content").show();
		$('#identifier').modal('hide');
    });
	$("button#add").click(function(){
		alert("添加成功");
		window.location.href=('<?php echo site_url('Testpaper/add_share').'/'.$code;?>')  
    });
	
});
</script>
