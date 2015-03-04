<?php
/**
 * Created by PhpStorm.
 * User: GavinLe
 * Date: 10/22/14
 * Time: 4:53 PM
 */
?>

<?php foreach($replies as $reply): ?>
    <div class="comment">
        <div>
            <div class="author" style="width: 535px;display: inline-block;">
                <?php echo $reply['username']; ?>:
            </div>
            <div style="display: inline-block;vertical-align: bottom;text-align: right;width: 180px;">
                on <?php echo date('Y-m-d H:i:s',$reply['create_time_utc']); ?>
            </div>
        </div>
        <div class="content" >
            <?php echo nl2br(CHtml::encode($reply['content'])); ?>
        </div>

        <hr>
    </div>
<?php endforeach; ?>