<?php if(!defined('__TYPECHO_ADMIN__')) exit; ?>
<?php
$fields = isset($post) ? $post->getFieldItems() : $page->getFieldItems();
$defaultFields = isset($post) ? $post->getDefaultFieldItems() : $page->getDefaultFieldItems();
?>
<div id="custom-field" class="card hidden">
  <div class="card-body">
    <table class="typecho-list-table mono">
      <colgroup>
          <col width="25%"/>
          <col width="15%"/>
          <col width="50%"/>
          <col width="10%"/>
      </colgroup>
      <?php foreach ($defaultFields as $field): ?>
      <?php list ($label, $input) = $field; ?>
      <tr>
        <td><?php $label->render(); ?></td>
        <td colspan="3"><?php $input->render(); ?></td>
      </tr>
      <?php endforeach; ?>
      <?php foreach ($fields as $field): ?>
      <tr>
        <td style="vertical-align: top;">
          <input
            type="text"
            name="fieldNames[]"
            value="<?php echo htmlspecialchars($field['name']); ?>"
            id="fieldname"
            class="form-control"
            style="font-size: 12px"
          >
        </td>
        <td style="vertical-align: top;">
          <select name="fieldTypes[]" id="fieldtype" class="form-select" style="font-size: 12px">
            <option value="str"<?php if ('str' == $field['type']): ?> selected<?php endif; ?>><?php _e('字符'); ?></option>
            <option value="int"<?php if ('int' == $field['type']): ?> selected<?php endif; ?>><?php _e('整数'); ?></option>
            <option value="float"<?php if ('float' == $field['type']): ?> selected<?php endif; ?>><?php _e('小数'); ?></option>
          </select>
        </td>
        <td style="vertical-align: top;">
          <input
            type="text"
            name="fieldValues[]"
            placeholder="<?php _e('字段值'); ?>"
            id="fieldvalue"
            class="form-control"
            style="font-size: 12px"
            value="<?php echo htmlspecialchars($field[$field['type'] . '_value']); ?>"
          >
        </td>
        <td style="vertical-align: top;">
          <button type="button" class="btn btn-sm btn-primary operate-del"><?php _e('删除'); ?></button>
        </td>
      </tr>
      <?php endforeach; ?>
      <?php if (empty($defaultFields) && empty($fields)): ?>
      <tr>
          <td style="vertical-align: top;">
            <input
              type="text"
              name="fieldNames[]"
              placeholder="<?php _e('字段名称'); ?>"
              id="fieldname"
              class="form-control"
              style="font-size: 12px"
            >
          </td>
          <td style="vertical-align: top;">
            <select name="fieldTypes[]" id="fieldtype" class="form-select" style="font-size: 12px">
              <option value="str"><?php _e('字符'); ?></option>
              <option value="int"><?php _e('整数'); ?></option>
              <option value="float"><?php _e('小数'); ?></option>
            </select>
          </td>
          <td style="vertical-align: top;">
            <input
              type="text"
              name="fieldValues[]"
              placeholder="<?php _e('字段值'); ?>"
              id="fieldvalue"
              class="form-control"
              style="font-size: 12px"
            >
          </td>
          <td style="vertical-align: top;">
            <button type="button" class="btn btn-sm btn-primary operate-del"><?php _e('删除'); ?></button>
          </td>
      </tr>
      <?php endif; ?>
    </table>
    <div class="text-end mt-4">
      <button type="button" class="btn btn-sm btn-primary float-start operate-add"><?php _e('+添加字段'); ?></button>
      <?php _e('自定义字段可以扩展你的模板功能, 使用方法参见 <a href="http://docs.typecho.org/help/custom-fields">帮助文档</a>'); ?>
    </div>
  </div>
</div>
