<?php
include 'common.php';

if ($user->hasLogin()) {
  $response->redirect($options->adminUrl);
}
$rememberName = htmlspecialchars(Typecho_Cookie::get('__typecho_remember_name'));
Typecho_Cookie::delete('__typecho_remember_name');

include 'header.php';
?>
      <!--authentication-->
      <div class="container-fluid my-5">
        <div class="row">
          <div class="col-12 col-md-8 col-lg-6 col-xl-5 col-xxl-4 mx-auto">
            <div class="card border-3">
              <div class="card-body p-5">
                  <img src="assets/images/logo-icon.png" class="mb-4" width="45" alt="">
                  <h4 class="fw-bold"><?php _e('现在就开始吧') ?></h4>
                  <p class="mb-0"><?php _e('输入你的凭证来登录你的账户'); ?></p>

                  
                  <div class="form-body mt-4">
										<form class="row g-3" action="<?php $options->loginAction(); ?>" method="post" name="login" role="form">
											<div class="col-12">
												<label for="name" class="form-label"><?php _e('用户名'); ?></label>
												<input type="text" class="form-control" id="name" name="name" placeholder="<?php _e('请输入用户名'); ?>">
											</div>
											<div class="col-12">
												<label for="password" class="form-label"><?php _e('密码'); ?></label>
												<div class="input-group" id="show_hide_password">
													<input type="password" class="form-control border-end-0" id="password" name="password" placeholder="<?php _e('请输入密码'); ?>">
                          <a href="javascript:;" class="input-group-text bg-transparent"><i class="bi bi-eye-slash-fill"></i></a>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-check form-switch">
													<input class="form-check-input" type="checkbox" id="remember" name="remember" >
													<label class="form-check-label" for="remember"><?php _e('下次自动登录'); ?></label>
												</div>
											</div>
											<div class="col-md-6 text-end">	<a href="#"><?php _e('忘记密码 ？'); ?></a>
											</div>
											<div class="col-12">
												<div class="d-grid">
													<button type="submit" class="btn btn-primary"><?php _e('登录'); ?></button>
                          <input type="hidden" name="referer" value="<?php echo htmlspecialchars($request->get('referer')); ?>" />
												</div>
											</div>
											<div class="col-12">
                        <?php if($options->allowRegister): ?>
												<div class="text-start">
													<p class="mb-0"><?php _e('还没有账户吗？'); ?> <a href="<?php $options->registerUrl(); ?>"><?php _e('点击这里注册'); ?></a>
													</p>
												</div>
                        <?php endif; ?>
											</div>
										</form>
									</div>

              </div>
            </div>
          </div>
        </div><!--end row-->
      </div>
      <!--authentication-->
      <!--plugins-->
      <script src="<?php echo Typecho_Common::url('jquery.min.js?v=' . $suffixVersion, $options->adminStaticUrl('assets/js')) ?>"></script>
      <script>
        $(document).ready(function () {
          $("#show_hide_password a").on('click', function (event) {
            event.preventDefault();
            if ($('#show_hide_password input').attr("type") == "text") {
              $('#show_hide_password input').attr('type', 'password');
              $('#show_hide_password i').addClass("bi-eye-slash-fill");
              $('#show_hide_password i').removeClass("bi-eye-fill");
            } else if ($('#show_hide_password input').attr("type") == "password") {
              $('#show_hide_password input').attr('type', 'text');
              $('#show_hide_password i').removeClass("bi-eye-slash-fill");
              $('#show_hide_password i').addClass("bi-eye-fill");
            }
          });
        });
      </script>
