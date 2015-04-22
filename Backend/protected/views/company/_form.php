<?php
/* @var $this CompanyController */
/* @var $model Company */
/* @var $form CActiveForm */
?>


<div class="left" style="width: 340px;">
    <div class="row">
        <?php echo CHtml::label("EditClient: ", false, array('style'=>'')); ?>
    </div>
    <div class="row" style="width: 100%; height: 470px;">
        <?php
        /*$query = "SELECT eea.id, eea.attribute_id, ea.name, eea.parent_id
            FROM lt_ebay_entity_attribute eea
            left join lt_ebay_attribute ea on ea.id = eea.attribute_id
            where eea.attribute_set_id = ".($model->isNewRecord ? 0 : $model->id)." order by eea.parent_id asc; ";
        $result = Yii::app()->db->createCommand($query)->queryAll();*/

        $this->widget('ext.zTree.zTree',array(
            'data'=>array(
                'key'=>array('name'=>'name'),
                'simpleDate'=>array(
                    'enable'=>true,//Set zTree's node to accept the simple data format, when zTree is initialized or when ajax get / or when use addNodes method.
                    'idKey'=>'id',//The node data's attribute to save node data's unique identifier. It is valid when [setting.data.simpleData.enable = true]
                    'pIdKey'=>'parent_id',
                ),
            ),

            'view'=>array(
                'expandSpeed'=>"",
                'showLine'=>true,
                'selectedMulti'=>false,
                'showIcon'=>true,
                'autoCancelSelected'=>true,
            ),
            'callback'=>array(
                'onClick'=>'zTreeOnClick',
                'beforeRemove'=>'befRemove',
                'beforeRename'=>'zTreeBeforeRename',
                'beforeDrop'=>'zTreeBeforeDrop',
            ),
            'edit'=>array(
                'enable'=>true,
                'showRemoveBtn'=>true,
                'showRenameBtn'=>true,
                'removeTitle'=>'del',
            ),
            'htmlOptions'=>array('id'=>'attribute_has','name'=>'attribute_has','class'=>'treeList', 'style'=>'overflow-y: scroll; overflow-x: auto; height: 350px;'),
            'input'=>$attributes,
        ));
        echo CHtml::textField('ebay_attribute_set', null, array('hidden'=>'hidden', 'style'=>'visibility: hidden;'));
        ?>
    </div>
</div>
<div class="right" style="width: 340px;display: none"  id="editDiv">
    <div class="row">
        <?php echo CHtml::label("EditUser: ", false, array('style'=>'')); ?>
    </div>
    <div class="row" style="width: 100%; height: 470px;" id="editDiv">
        <table>
            <tr>
                <td>UserName</td><td><input type="text" id="userName"></td>
            </tr>
            <tr>
                <td>Email</td><td><input type="text" id="email"></td>
            </tr>
            <tr>
                <td>Password</td><td><input type="password" id="password"></td>
            </tr>
            <tr>
                <td>Password Repeat</td><td><input type="password" id="passwordRepeat"></td>
            </tr>
            <tr>
                <td><input type="hidden" id="userId"><input type="hidden" id="treeId"></td>
                <td><input type="button" name="update" id="editUser" value="update" onclick="editUser()"></td>
            </tr>
        </table>

    </div>
</div>
<div class="right" style="width: 340px;display: none; height: 250px;"  id="addUser">
    <div class="row">
        <?php echo CHtml::label("AddUser: ", false, array('style'=>'')); ?>
    </div>
    <div class="row" style="width: 100%; height: 250px;" id="editDiv">
        <table>
            <tr>
                <td>Email</td><td><input type="text" id="addEmail"></td>
            </tr>
            <tr>
                <td>UserName</td><td><input type="text" id="addUserName"></td>
            </tr>
            <tr>
                <td>Password</td><td><input type="password" id="addPassword"></td>
            </tr>
            <tr>
                <td>Password Repeat</td><td><input type="password" id="addPasswordRepeat"></td>
            </tr>
            <tr>
                <td><input type="hidden" id="addDepartmentId"><input type="hidden" id="addCompanyId"><input type="hidden" id="userTreeId"></td>
                <td><input type="button" name="addUser" id="addUser" value="addUser" onclick="addUser()"></td>
            </tr>
        </table>

    </div>
</div>
<div class="right" style="width: 340px;display: none"  id="addDepartment"  >
    <div class="row">
        <?php echo CHtml::label("AddDepartment: ", false, array('style'=>'')); ?>
    </div>
    <div class="row" style="width: 100%; height: 470px;" id="editDiv">
        <table>
            <tr>
                <td>Name</td><td><input type="text" id="departmentName"></td>
            </tr>

            <tr>
                <td><input type="hidden" id="parentId"><input type="hidden" id="departmentCompanyId"><input type="hidden" id="departmentTreeId"></td>
                <td><input type="button" name="addDepartment" id="addDepartment" value="addDepartment" onclick="addDepartment()"></td>
            </tr>
        </table>

    </div>
</div>
<script>
    $("<div id='div_brg_keleyi_com'><img id='close_keleyi_com' src='../../images/loading.gif' width='30' height='30' style='position:absolute; top: 50%;left:50%;' /></div>").css({
        position:'absolute',
        top:0,
        left:0,
        opacity:0.3,
        zIndex:300
    })
        .height($(document).height())
        .width($(document).width()).hide().appendTo("body")
    /*$(document).ready(function(){});*/
        function setRemoveBtn(treeId, treeNode) {
            alert("1");
        }
        function zTreeOnClick(event, treeId, treeNode) {
            if(treeNode.type==0) {
                $("#editDiv").hide();
                $("#addUser").hide();
                $("#departmentCompanyId").val(treeNode.id);
                $("#departmentTreeId").val(treeNode.tId);
                $("#addDepartment").show();
            }
            else if(treeNode.type==1){
                $("#editDiv").hide();
               /* $("#addDepartment").hide();*/
                $.ajax({
                    type: "POST",
                    url: '<?php echo Yii::app()->createAbsoluteUrl("company/updateUser");?>',
                    data: {
                        id:treeNode.id,
                        type:treeNode.type
                    },
                    dataType: "JSON",
                    success: function(data, status, xhr) {
                        data = eval(data);
                        $("#userTreeId").val(treeNode.tId);
                        $("#departmentTreeId").val(treeNode.tId);
                        $("#addCompanyId").val(data.companyId);
                        $("#addDepartmentId").val(treeNode.id);
                        $("#parentId").val(treeNode.id);
                        $("#departmentCompanyId").val(data.companyId);
                        $("#addUser").show();
                        $("#addDepartment").show();
                    },
                    error: function(data, status, xhr) {

                    }
                })
                /*$("#editDiv").hide();*/
            }
            else if(treeNode.type==2){
                $("#addUser").hide();
                $("#addDepartment").hide();
                $.ajax({
                    type: "POST",
                    url: '<?php echo Yii::app()->createAbsoluteUrl("company/updateUser");?>',
                    data: {
                        id:treeNode.id,
                        type:treeNode.type
                    },
                    dataType: "JSON",
                    success: function(data, status, xhr) {
                        data = eval(data);
                        $("#treeId").val(treeNode.tId);
                        $("#userName").val(data.userName);
                        $("#password").val(data.passWord);
                        $("#email").val(data.email);
                        $("#passwordRepeat").val(data.passWord);
                        $("#userId").val(data.id);
                        $("#editDiv").show();

                    },
                    error: function(data, status, xhr) {

                    }
                })
            }

        }


      function editUser(){
          $("#div_brg_keleyi_com").show();
          var userId=$("#userId").val();
          var password=$("#password").val();
          var userName=$("#userName").val();
          var email=$("#email").val();
          var passwordRepeat=$("#passwordRepeat").val();
          var treeId=$("#treeId").val();

          if(password!=passwordRepeat)
          {
              alert("Password must be repeated exactly.");
              return false;
          }
          $.post('<?php echo Yii::app()->createAbsoluteUrl("company/editUser");?>',{email:email,password:password,userName:userName,id:userId},function(data){
              //alert(data);nodes[0].name = "test";

              $("#editDiv").hide();
              var treeObj = $.fn.zTree.getZTreeObj("attribute_has");
              var node = treeObj.getNodeByTId(treeId);
              node.name = userName;
              treeObj.updateNode(node);
              $("#div_brg_keleyi_com").hide();
          });
      }
    function addUser(){
        $("#div_brg_keleyi_com").show();
        var email=$("#addEmail").val();
        var password=$("#addPassword").val();
        var userName=$("#addUserName").val();
        var passwordRepeat=$("#addPasswordRepeat").val();
        var departmentId=$("#addDepartmentId").val();
        var companyId=$("#addCompanyId").val();
        var userTreeId=$("#userTreeId").val();
        if(password!=passwordRepeat)
        {
            alert("Password must be repeated exactly.");
            return false;
        }
        $.post('<?php echo Yii::app()->createAbsoluteUrl("company/addUser");?>',{password:password,userName:userName,departmentId:departmentId,companyId:companyId,email:email},function(data){
            //alert(data);
            $("#addUser").hide();
            var treeObj = $.fn.zTree.getZTreeObj("attribute_has");
            var node = treeObj.getNodeByTId(userTreeId);
            var newNode = {name:userName+" (User)",id:data,type:2};
            treeObj.addNodes(node, newNode);
            $("#div_brg_keleyi_com").hide();
            /*window.location.reload();*/
        });
    }
    function addDepartment(){
        $("#div_brg_keleyi_com").show();
        var name=$("#departmentName").val();
        var parentId=$("#parentId").val();
        var departmentTreeId=$("#departmentTreeId").val();
        var departmentCompanyId=$("#departmentCompanyId").val();
        $.post('<?php echo Yii::app()->createAbsoluteUrl("company/addDepartment");?>',{name:name,parentId:parentId,departmentCompanyId:departmentCompanyId},function(data){

            $("#addDepartment").hide();
            var treeObj = $.fn.zTree.getZTreeObj("attribute_has");
            var node = treeObj.getNodeByTId(departmentTreeId);
            var newNode = {name:name+" (Department)",id:data,type:1,icon:'../../images/3.png'};
            treeObj.addNodes(node, newNode);
            $("#div_brg_keleyi_com").hide();
            /*window.location.reload();*/
        });
    }
    function zTreeBeforeRename(treeId, treeNode, newName, isCancel) {
        //alert(newName);
        $("#div_brg_keleyi_com").show();
        $.post('<?php echo Yii::app()->createAbsoluteUrl("company/rename");?>',{type:treeNode.type,id:treeNode.id,newName:newName},function(data){
            $("#div_brg_keleyi_com").hide();
        });
    }
    function zTreeBeforeDrop(treeId, treeNodes, targetNode, moveType) {
        $("#div_brg_keleyi_com").show();
        $.post('<?php echo Yii::app()->createAbsoluteUrl("company/drop");?>',{treeType:treeNodes[0].type,treeId:treeNodes[0].id,targetType:targetNode.type,targetId:targetNode.id},function(data){
            $("#div_brg_keleyi_com").hide();
            /*window.location.reload();*/
        });
    };
    function befRemove(treeId, treeNode)
    {
        $("#div_brg_keleyi_com").show();
        $.post('<?php echo Yii::app()->createAbsoluteUrl("company/modify");?>',{type:treeNode.type,id:treeNode.id},function(date){
            /*window.location.reload();*/
            $("#div_brg_keleyi_com").hide();
        });
        $("#div_brg_keleyi_com").hide();
        var zTree = $.fn.zTree.getZTreeObj("attribute_has");
        var filterNode =  function(node)
        {
            var isTrue  = (node.parentTId == treeNode.tId)?true:false;
            return isTrue;
        }
        var childNodes = zTree.getNodesByFilter(filterNode,false,treeNode);
        for(var childNode in childNodes)
        {
            var child=childNodes[childNode];

            if(treeNode.type==1)
            {
                var treeObj = $.fn.zTree.getZTreeObj("attribute_has");
                child.parentTId = treeNode.parentTId;
                treeObj.updateNode(child);
                var node = treeObj.getNodeByTId(treeNode.parentTId);
                treeObj.addNodes(node, child);

            }
        }
    }
    function getChildren(ids,treeNode){

       /* ids.push(treeNode.id);*/

        if (treeNode.isParent){

            for(var obj in treeNode.children){

                getChildren(ids,treeNode.children[obj]);

            }

        }

        return ids;

    }

</script>

