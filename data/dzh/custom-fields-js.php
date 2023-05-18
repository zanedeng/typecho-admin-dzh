<?php if(!defined('__TYPECHO_ADMIN__')) exit; ?>
<script>
$(document).ready(function () {
    // 自定义字段
    $('#custom-fields').click(function() {

      $('#custom-field').toggleClass('hidden');
    });

    function attachDeleteEvent (el) {
      $('button.operate-del', el).click(function () {
        if (confirm('<?php _e('确认要删除此字段吗?'); ?>')) {
          $(this).parents('tr').fadeOut(function () {
              $(this).remove();
          });

          $(this).parents('form').trigger('field');
        }
      });
    }

    $('#custom-field table tbody tr').each(function () {
        attachDeleteEvent(this);
    });

    $('#custom-field button.operate-add').click(function () {
      var html = '<tr>'
        + '<td style="vertical-align: top;"><input type="text" name="fieldNames[]" placeholder="<?php _e('字段名称'); ?>" class="form-control" style="font-size: 12px"></td>'
        + '<td style="vertical-align: top;"><select name="fieldTypes[]" id="fieldtype" class="form-select" style="font-size: 12px">'
        + '<option value="str"><?php _e('字符'); ?></option>'
        + '<option value="int"><?php _e('整数'); ?></option>'
        + '<option value="float"><?php _e('小数'); ?></option>'
        + '</select></td>'
        + '<td style="vertical-align: top;"><input type="text" name="fieldValues[]" placeholder="<?php _e('字段值'); ?>" id="fieldvalue" class="form-control" style="font-size: 12px" ></td>'
        + '<td style="vertical-align: top;"><button type="button" class="btn btn-sm btn-primary operate-del"><?php _e('删除'); ?></button></td></tr>',
      el = $(html).hide().appendTo('#custom-field table tbody').fadeIn();

      $(':input', el).bind('input change', function () {
          $(this).parents('form').trigger('field');
      });

      attachDeleteEvent(el);
    });
});
</script>
