<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info" id="validate">

                <div class="box-header">
                    <h3 class="box-title">新增题目
                <small>请选择题目类型并填写详细信息</small>
              </h3>
                    <!-- /. tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body pad">
                    <label>题目类型</label>
                    <select class="form-control" id="type" name="type">
                        <option value=0>选择</option>
                        <option value=1>判断</option>
                        <option value=2>填空</option>
                    </select>

                    <hr />
                    <label>题目详情</label>
                    <textarea id="content" name="content" class="form-control" style="visibility:hidden;" placeholder="请在此输入题目详情">

                    </textarea>
                    <hr />
                    <label>正确答案</label>
                   <select class="form-control" id="textOne">
                       <option value=''>请选择</option>
                        <option value=A>A</option>
                        <option value=B>B</option>
                        <option value=C>C</option>
                        <option value=D>D</option>
                    </select> 
                   <select class="form-control" id="textTwo">
                       <option value=''>请选择</option>
                        <option value=T>正确</option>
                        <option value=F>错误</option>
                    </select>
                    <input class="form-control" type="text" id="textThree">
                      
                </div>
                <div class="box-footer">
                    <button id="submitquestion" class="btn btn-info pull-right">提交</button>
                  </div>
            </div>
        </div>
    </div>
</section>

<script>
$(document).ready(function(){
	window.K = KindEditor;
	window.editor = K.create('#content', {
	    basePath: "<?php echo base_url('assets/css/kindeditor').'/'?>",
	    items: [
	'source', '|', 'undo', 'redo', '|', 'preview', 'print', 'template', 'code', 'cut', 'copy', 'paste',
	'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
	'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
	'superscript', 'clearhtml', 'quickformat', 'selectall', '|', 'fullscreen', '/',
	'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
	'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|', 'image', 'table', 'hr', 'emoticons', 'baidumap', 'pagebreak',
	'anchor', 'link', 'unlink'
	],
	    
	    uploadJson: "<?php echo site_url('Question/upload_json')?>",
	    fileManagerJson: "<?php echo site_url('Question/file_manager_json')?>",
	    allowFileManager : true
	});

	$('#type').change(function(){
		var sel_val = $('#type').val();
		if (sel_val == 0) {
            $('#textOne').show();
            $('#textTwo').hide();
            $('#textThree').hide();
        }
        if (sel_val == 1) {
            $('#textOne').hide();
            $('#textTwo').show();
            $('#textThree').hide();
        }
        if (sel_val == 2) {
            $('#textOne').hide();
            $('#textTwo').hide();
            $('#textThree').show();
        }
	  });


	   void function() {
		var sel_val = $('#type').val();
		if (sel_val == 0) {
            $('#textOne').show();
            $('#textTwo').hide();
            $('#textThree').hide();
        }
        if (sel_val == 1) {
            $('#textOne').hide();
            $('#textTwo').show();
            $('#textThree').hide();
        }
        if (sel_val == 2) {
            $('#textOne').hide();
            $('#textTwo').hide();
            $('#textThree').show();
        }
	   }();

	   $("button#submitquestion").on("click",function(){
		   window.editor.sync('#content');
           var type = $('#type').val();
           var answer = switchType(type);
           var content = $('#content').val();
           if (!content) {
               alert("请填写题目详情");
               return false;
           }
           if (!answer) {
               alert("请填写答案详情");
               return false;
           }
           $.ajax({
               url:"<?php echo site_url('Question/insert_question')?>",
               type: 'POST',
               data: {
                   chapter_id: "<?php echo $chapter_id?>",
                   type: $('#type').val(),
                   content: $('#content').val(),
                   answer: answer,
               },
               success: function (data) {
                   if (data.errno == 0) {
                       alert("添加成功");
                       window.opener.location.href = window.opener.location.href;
                       window.close(); 
                   } else
                       alert(data.error);
               },
               dataType: "json"
           });
	   });

	   function switchType(num) {
           switch (num) {
               case "0":
                   return $('#textOne').val();
               case "1":
                   return $('#textTwo').val();
               case "2":
                   return $('#textThree').val();
           }
       }
});

</script>