<?php
include 'common.php';
include 'header.php';
?>
      <div class="container-fluid my-5">
        <div class="row">
          <div class="col-12 col-md-8 col-lg-6 col-xl-5 col-xxl-4 mx-auto">
            <div class="card">
              <div class="card-header bg-body-tertiary text-center">
                <h5 class="card-title"><?php _e('欢迎您使用 "%s" 管理后台', $options->title); ?></h5>
              </div>
              <div class="card-body">
                <form action="<?php $options->adminUrl(); ?>" method="get">
                  <div class="team-list">
                    <div class="d-flex align-items-center justify-content-center">
                      <a 
                        class="btn btn-outline-primary rounded-5 btn-sm w-75"
                        href="<?php $options->adminUrl('profile.php#change-password'); ?>"
                      >
                      <?php _e('强烈建议更改你的默认密码'); ?>
                      </a>
                    </div>
                    <hr>
                    <?php if($user->pass('contributor', true)): ?>
                    <div class="d-flex align-items-center justify-content-center">
                      <a 
                        class="btn btn-outline-primary rounded-5 btn-sm w-75"
                        href="<?php $options->adminUrl('write-post.php'); ?>"
                      >
                      <?php _e('撰写第一篇日志'); ?>
                      </a>
                    </div>
                    <hr>
                    <?php endif; ?>
                    <div class="d-flex align-items-center justify-content-center">
                      <a 
                        class="btn btn-outline-primary rounded-5 btn-sm w-75"
                        href="<?php $options->siteUrl(); ?>"
                      >
                      <?php _e('查看我的站点'); ?>
                      </a>
                    </div>
                    <hr>
                    <div class="d-flex align-items-center justify-content-center">
                      <button type="submit" class="btn btn-primary rounded-5 w-75"><?php _e('让我直接开始使用吧 &raquo;'); ?></button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div><!--end row-->
      </div>
<?php
include 'footer-js.php';
include 'footer.php';
?>