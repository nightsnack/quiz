<div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
我创建的课程         

          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> 控制台</a></li>
            <li class="active">我的课程</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
          
            <div class="col-md-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">我的课程列表</h3>
                  <button style="position:absolute;left:70.5%;top:12%;width:12%;" class="btn btn-default btn-sm pull-right" id="newCourseModel">新增课程</button>
                </div><!-- /.box-header -->
                <div class="box-body no-padding">
                  <table class="table table-striped">
                    <tbody><tr>
                      <th style="width: 10%">编号</th>
                      <th style="width: 60%">名称</th>
                      <th style="width: 30%">操作</th>
                    </tr>
                    <?php foreach ($res as $num=>$item):?>
                    <tr>
                      <td><?php echo ($num+1)?></td>
                      <td class="second">
                      <input attr="<?php echo $item['id']?>" class="edit" value="<?php echo $item['name']?>"/>
                      <div class="showw"><?php echo $item['name']?></div>
                    </td>
                      <td>
                         <div class="btn-group">
                          <button type="button" id="edit" class="btn btn-default"><i class="fa fa-edit"></i></button>
                          <button type="button" attr="<?php echo $item['id']?>" id="delete" class="btn btn-default"><i class="fa fa-trash"></i></button>
                          <button type="button" attr="<?php echo $item['id']?>" id="detail" class="btn btn-default"><i class="fa fa-list-ul"></i></button>
                        </div>
                     </td>
                    </tr>
                  <?php endforeach; ?>
                                        
                  </tbody></table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
 
        </section><!-- /.content -->
      </div>
      
      <div class="modal fade" id="newCourse" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
           <form role="form" id="insertForm" method="post">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">新增课程</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="name">课程名称：</label>
                    <input class="form-control" type="text" name="name" id="name" value="" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                </button>
                <button class="btn btn-primary" type="submit">提交更改</button>
            </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal -->
</div>
      
      <script>
      $(document).ready(function(){
    	  $("button#edit").on("click",function(event){
    			$(event.currentTarget).parent().parent().parent().children("td.second").addClass("editing").find("input").focus();
    	});
    	  $("input.edit").blur(function(event){
        	  if($(event.currentTarget).val()=='')
        	  {
            	  alert("请填写课程名称");    
            	  return false;
        	  }
        	  var id = $(event.currentTarget).attr("attr");
        	  var name = $(event.currentTarget).val();
              $.ajax({
                  type: 'POST',
                  url: "<?php echo site_url('Course/update_course')?>",
                  data:{
                      course_id:id,
                      name:name
                      },
                      success: function (data) {
                      $(event.currentTarget).next().text(name);    
                  },
                  dataType: 'json'
              });
              $(event.currentTarget).parent().removeClass("editing");
  		  });

    	  $("button#delete").on("click",function(event){
    		  var id = $(event.currentTarget).attr("attr");
    		  if(confirm("您确定删除课程吗？删除后对应章节和题目会一并删除！")){
    		  $.ajax({
                  type: 'POST',
                  url: "<?php echo site_url('Course/delete_course')?>",
                  data:{
                      course_id:id,
                      },
                      success: function (data) {
                      if (data.errno!==0) {
                          alert(data.error);
                          return false;
                      }
                      $(event.currentTarget).parent().parent().parent().fadeOut();
                  },
                  dataType: 'json'
              });
    		  }     
    	});

        $("button#newCourseModel").on("click",function(event){
        	$('#newCourse').modal('show');
            
    	});

        $("#insertForm").validate({
            submitHandler: function() {
            	$.ajax({
                    type: 'POST',
                    url: "<?php echo site_url('Course/insert_course')?>",
                    data:{
                        name:$("#name").val()
                        },
                        success: function (data) {
                        	if(data.errno==0)
                            {
                                $('#newCourse').modal('hide');
                                alert("添加成功!");
                                location.reload();  
                            }
                            else{
                                alert(data.error);
                                return false;
                            }
                            
                    },
                    dataType: 'json'
                });
            }
        });

        $("button#detail").on("click",function(event){
        	var course_id = $(event.currentTarget).attr("attr");
        	window.location.href=("<?php echo site_url('Chapter/query_chapter').'/'?>"+course_id);
            
    	});
        
  		  
      });
      
      </script>