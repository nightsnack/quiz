<div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
          收到分享
                    <small>来自 <?php echo $course_name?> 课程的全部章节和题目</small>

          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> 控制台</a></li>
            <li><a href="">章节：</a></li>
            <li class="active">章节列表</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
        
 
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
               您收到来自 <?php echo $course_name?> 课程的全部章节和题目的分享
            </h4>
         </div>
         <div class="modal-body">
            请问是否添加该课程到我的课程列表？
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-primary pull-left" id="add">
               添加
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
	$('#identifier').modal('show');

	$("button#add").click(function(){
		alert("添加成功");
		window.location.href=('<?php echo site_url('Course/add_share').'/'.$code;?>')  
    });
	
});
</script>
