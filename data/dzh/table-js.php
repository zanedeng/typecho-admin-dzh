<?php if(!defined('__TYPECHO_ADMIN__')) exit; ?>
<script>
(function () {
    $(document).ready(function () {
      $('.table').tableSelectable({
        checkEl     :   'input[type=checkbox]:not("#checkAll")',
        rowEl       :   'tr',
        selectAllEl :   '#checkAll',
        actionEl    :   '.dropdown-menu a,button.btn-operate'
      });

    });
})();
</script>
