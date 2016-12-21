<div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
<?php echo $course_name;?>        
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> 控制台</a></li>
            <li><a href="<?php echo site_url('Course/query_course')?>">课程：<?php echo $course_name;?></a></li>
            <li class="active">章节列表</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
          
            <div class="col-md-12">
              <div class="box box-info">
                <div class="box-header">
                  <h3 class="box-title">章节列表</h3>
                  <button style="position:absolute;left:70.5%;top:12%;width:9.5%;" class="btn btn-info btn-sm pull-right" id="newChapterModel">新增章节</button>
                  <button style="position:absolute;left:56.5%;top:12%;width:9.5%;" class="btn btn-info btn-sm pull-right" id="newShareModel">分享该课程</button>
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
                          <button type="button" id="edit" class="btn btn-info"><i class="fa fa-edit"></i></button>
                          <button type="button" attr="<?php echo $item['id']?>" id="delete" class="btn btn-info"><i class="fa fa-trash"></i></button>
                          <button type="button" attr="<?php echo $item['id']?>" id="detail" class="btn btn-info"><i class="fa fa-list-ul"></i></button>
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
      
      <div class="modal fade" id="newChapter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
           <form role="form" id="insertForm" method="post">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">新增章节</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="name">章节名称：</label>
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
      
<div class="modal fade" id="shareModal" tabindex="-1" role="dialog" 
   aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" 
               data-dismiss="modal" aria-hidden="true">
                  &times;
            </button>
            <h4 class="modal-title" id="myModalLabel">
               在过期时间前,您分享的题目都可以被拿到分享链接的人克隆。
            </h4>
         </div>
         <div class="modal-body">

           <label for="date-info" style="margin-bottom: 10px;">请设定过期时间</label>
          <input class="form-control" id="dateinfo" type="text" placeholder="请选择过期时间" readonly>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" 
               data-dismiss="modal">关闭
            </button>
            <button type="button" class="btn btn-primary" id="requestShare">
               确定
            </button>
         </div>
      </div><!-- /.modal-content -->
</div><!-- /.modal -->
</div>
 <script src="<?php echo base_url('assets/js/jedate/jedate.min.js')?>" ></script>
      
      <script>
      $(document).ready(function(){
    	  $("button#edit").on("click",function(event){
    			$(event.currentTarget).parent().parent().parent().children("td.second").addClass("editing").find("input").focus();
    	});
    	  $("input.edit").blur(function(event){
        	  if($(event.currentTarget).val()=='')
        	  {
            	  alert("请填写章节名称");    
            	  return false;
        	  }
        	  var id = $(event.currentTarget).attr("attr");
        	  var name = $(event.currentTarget).val();
              $.ajax({
                  type: 'POST',
                  url: "<?php echo site_url('Chapter/update_chapter')?>",
                  data:{
                      chapter_id:id,
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
    		  if(confirm("您确定删除章节吗？删除后对应题目会一并删除！")){
    		  $.ajax({
                  type: 'POST',
                  url: "<?php echo site_url('Chapter/delete_chapter')?>",
                  data:{
                      chapter_id:id,
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

        $("button#newChapterModel").on("click",function(event){
        	$('#newChapter').modal('show');
            
    	});

        $("#insertForm").validate({
            submitHandler: function() {
            	$.ajax({
                    type: 'POST',
                    url: "<?php echo site_url('Chapter/insert_chapter')?>",
                    data:{
                    	course_id:<?php echo $course_id;?>,
                        name:$("#name").val()
                        },
                        success: function (data) {
                        	if(data.errno==0)
                            {
                                $('#newChapter').modal('hide');
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
        	window.location.href=("<?php echo site_url('Question/query_question').'/'?>"+course_id);
            
    	});
        
  		  
        $("button#newShareModel").on("click",function(){
    		$("#shareModal").modal('show');
    	});

        $("button#requestShare").on("click",function(event){
            var endtime = $("#dateinfo").val();
        	$.ajax({
                type: 'POST',
                url: "<?php echo site_url('Course/share_course')?>",
                data:{
                    course_id:<?php echo $course_id?>,
                    endtime:endtime
                },
                    success: function (data) {
                    if (data.errno!==0) {
                        alert(data.error);
                        return false;
                    }
                    $(".modal-body").append('<hr><label style="margin-bottom: 10px;">请牢记此链接，将此链接发送给想要分享的人!</label><textarea class="form-control"  type="text">'+data.url+'</textarea>');
                    $("button#requestShare").hide();
                },
                dataType: 'json'
            });
    	});
  		  
      });
      
      jeDate({
          dateCell: "#dateinfo",
          format: "YYYY-MM-DD hh:mm:ss",
          isinitVal: true,
          isTime: true, //isClear:false,
          minDate: "2016-03-19 00:00:00",
          okfun: function(val) {
              alert(val)
          }
      })
      </script>
      
<style type="text/css">
 .jedatebox
 {
 	z-index:99999!important;
 }
</style>