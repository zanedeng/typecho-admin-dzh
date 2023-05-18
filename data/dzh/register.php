<?php
include 'common.php';

if ($user->hasLogin() || !$options->allowRegister) {
    $response->redirect($options->siteUrl);
}
$rememberName = htmlspecialchars(Typecho_Cookie::get('__typecho_remember_name'));
$rememberMail = htmlspecialchars(Typecho_Cookie::get('__typecho_remember_mail'));
Typecho_Cookie::delete('__typecho_remember_name');
Typecho_Cookie::delete('__typecho_remember_mail');

include 'header.php';
?>
      <!--authentication-->
      <div class="container-fluid my-5">
        <div class="row">
          <div class="col-12 col-md-8 col-lg-6 col-xl-5 col-xxl-5 mx-auto">
            <div class="card border-3">
              <div class="card-body p-5">
                <img src="assets/images/logo-icon.png" class="mb-4" width="45" alt="">
                <h4 class="fw-bold"><?php _e('现在就开始吧') ?></h4>
                <p class="mb-0"><?php _e('输入你的凭证以创建你的账户') ?></p>

                <div class="row g-3 my-4">
                  <div class="col-12 col-lg-6">
                    <button class="btn btn-light py-2 font-text1 fw-bold d-flex align-items-center justify-content-center w-100">
                      <img src="assets/images/icons/google-2.png" width="18" class="me-2" alt="">
                      <?php _e('使用谷歌登录') ?>
                    </button>
                  </div>
                  <div class="col col-lg-6">
                    <button class="btn btn-light py-2 font-text1 fw-bold d-flex align-items-center justify-content-center w-100">
                      <img src="assets/images/icons/apple-logo.png" width="18" class="me-2" alt="">
                      <?php _e('使用苹果登录') ?>
                    </button>
                  </div>
                </div>

                <div class="separator section-padding">
                  <div class="line"></div>
                  <p class="mb-0 fw-bold"><?php _e('或者'); ?></p>
                  <div class="line"></div>
                </div>

                <div class="form-body mt-4">
                  <form class="row g-3">
                    <div class="col-12">
                      <label for="name" class="form-label"><?php _e('用户名'); ?></label>
                      <input type="text" class="form-control" id="name" name="name" placeholder="<?php _e('请输入用户名'); ?>">
                    </div>
                    <div class="col-12">
                      <label for="mail" class="form-label"><?php _e('电子邮箱地址'); ?></label>
                      <input type="email" class="form-control" id="mail" name="mail" placeholder="<?php _e('请输入电子邮箱地址'); ?>">
                    </div>
                    <div class="col-12">
                      <label for="password" class="form-label"><?php _e('密码'); ?></label>
                      <div class="input-group" id="show_hide_password">
                        <input type="password" class="form-control border-end-0" id="password" name="password" placeholder="<?php _e('请输入密码'); ?>">
                        <a href="javascript:;" class="input-group-text bg-transparent"><i class="bi bi-eye-slash-fill"></i></a>
                      </div>
                    </div>
                    <div class="col-12">
                      <label for="confirm" class="form-label"><?php _e('密码确认'); ?></label>
                      <div class="input-group" id="show_hide_confirm">
                        <input type="password" class="form-control border-end-0" id="confirm" name="confirm" placeholder="<?php _e('请再次输入密码'); ?>">
                        <a href="javascript:;" class="input-group-text bg-transparent"><i class="bi bi-eye-slash-fill"></i></a>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="d-grid">
                        <button type="submit" class="btn btn-primary"><?php _e('注册'); ?></button>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="text-start">
                        <p class="mb-0"><?php _e('已经有账号了'); ?><a href="<?php $options->adminUrl('login.php'); ?>">点击这里登录</a></p>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!--end row-->
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
          $("#show_hide_confirm a").on('click', function (event) {
            event.preventDefault();
            if ($('#show_hide_confirm input').attr("type") == "text") {
              $('#show_hide_confirm input').attr('type', 'password');
              $('#show_hide_confirm i').addClass("bi-eye-slash-fill");
              $('#show_hide_confirm i').removeClass("bi-eye-fill");
            } else if ($('#show_hide_confirm input').attr("type") == "password") {
              $('#show_hide_confirm input').attr('type', 'text');
              $('#show_hide_confirm i').removeClass("bi-eye-slash-fill");
              $('#show_hide_confirm i').addClass("bi-eye-fill");
            }
          });
        });
      </script>
