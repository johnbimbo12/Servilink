<?php $__currentLoopData = $message; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

    <tr class="<?php echo e($msg->isread == 1 ? '' : 'unread'); ?>" onclick="window.location='<?php echo e(route('message.details', $msg->id)); ?>';">
        <td>
            <div class="checkbox m-t-0 m-b-0 ">
                <input type="checkbox" class="sub_chk" data-id="<?php echo e($msg->id); ?>">
                <label></label>
            </div>
        </td>
        <td><?php echo e($msg->sender); ?></td>
        <td class="hidden-xs"><?php echo e($msg->title); ?></td>
        <td class="max-texts"> <a href="<?php echo e(route('message.details', $msg->id)); ?>"> <?php echo Str::words($msg->request, 4, ' ...'); ?></a></td>
        </td>
        
        <td class="text-right"><?php echo e($msg->created_at->diffForHumans()); ?> </td>
        <td class="text-right"> <a href="<?php echo e(route('message.details', $msg->id)); ?>"
            title="View" ><i class="fa fa-eye text-success" style="font-size: 24px"></i></a> </td>
    </tr>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /home/ocqv5p3q51h2/Servilink/resources/views/theme/msg_item.blade.php ENDPATH**/ ?>